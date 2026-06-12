<?php

class CWatchlist
{
    public function mostra()
    {
        $idWatchlist = $_GET['id'] ?? null;
        $view = new VWatchlist();
        if ($idWatchlist) {
            $watchlist = FWatchlist::findById($idWatchlist);
            if ($watchlist) {
                $contenuti = $watchlist->getContenutiSalvati();
                $view->mostraWatchlist($watchlist, $contenuti);
            } else {
                $view->mostraErrore('Watchlist non trovata.');
            }
        } else {
            $view->mostraErrore('ID Watchlist non valido.');
        }
    }

    public function aggiungi()
    {
        $idContenuto = $_GET['id'] ?? null;
        $idUtente = Session::get('user_id');
        $idWatchlist = $_GET['idWatchlist'] ?? null;
        $view = new VWatchlist();

        if (!$idUtente) {
            // Se l'utente non è loggato, lo rimandiamo alla pagina di login
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }

        if ($idContenuto) {
            // Se non è stata fornita una watchlist specifica in GET, usiamo quella di default
            if (!$idWatchlist) {
                $watchlists = FWatchlist::findByUtente($idUtente);
                if (empty($watchlists)) {
                    // Crea una watchlist di default se l'utente non ne ha nessuna
                    $utente = FUtente::findById($idUtente);
                    if ($utente) {
                        $defaultWatchlist = new EWatchlist(0, 'La mia Lista', 'Watchlist di default per i tuoi contenuti preferiti.', [], Privacy::privato, $utente);
                        FWatchlist::insert($defaultWatchlist);
                        $idWatchlist = $defaultWatchlist->getId();
                    } else {
                        $view->mostraErrore('Utente non trovato.');
                        return;
                    }
                } else {
                    $idWatchlist = $watchlists[0]->getId();
                }

                // Eseguiamo il toggle: aggiungi se manca, rimuovi se c'è
                if (FWatchlist::contains($idWatchlist, $idContenuto)) {
                    FWatchlist::removeContenuto($idWatchlist, $idContenuto);
                } else {
                    FWatchlist::addContenuto($idWatchlist, $idContenuto);
                }

                // Reindirizza alla pagina precedente per non interrompere la navigazione dell'utente
                $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
                header("Location: " . $referer);
                exit();
            } else {
                // Comportamento esplicito se viene passato un idWatchlist (es. aggiunta mirata da altre sezioni)
                FWatchlist::addContenuto($idWatchlist, $idContenuto);
                $watchlist = FWatchlist::findById($idWatchlist);
                $contenuti = $watchlist->getContenutiSalvati();
                $view->mostraWatchlist($watchlist, $contenuti);
            }
        } else {
            $view->mostraErrore('ID Contenuto non specificato.');
        }
    }


    public function rimuovi()
    {
        $idContenuto = $_GET['id'];
        $idUtente = Session::get('user_id');
        $idWatchlist = $_GET['idWatchlist'] ?? null;
        $view = new VWatchlist();
        if ($idContenuto && $idUtente && $idWatchlist) {
            // Corretto: passiamo $idWatchlist anziché $idUtente
            FWatchlist::removeContenuto($idWatchlist, $idContenuto);
            $watchlist = FWatchlist::findById($idWatchlist);
            $contenuti = $watchlist->getContenutiSalvati();
            $view->mostraWatchlist($watchlist, $contenuti);
        } else {
            $view->mostraErrore('Errore nel salvataggio ' . $idWatchlist);
        }
    }

    public function mostraTutteWatchlist()
    {
        $idUtente = Session::get('user_id');
        $view = new VWatchlist();
        if ($idUtente) {
            $watchlists = FWatchlist::findByUtente($idUtente);
            $view->mostraTutteWatchlist($watchlists);
        } else {
            $view->mostraErrore('Errore nel caricamento delle watchlist.');
        }
    }

    public function crea()
    {
        $idUtente = Session::get('user_id');
        $view = new VWatchlist();
        if ($idUtente && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $descrizione = trim($_POST['descrizione'] ?? '');
            $visibilitaStr = $_POST['visibilita'] ?? 'privato';

            if (!empty($nome)) {
                $visibilita = Privacy::privato;
                if ($visibilitaStr === 'pubblico') {
                    $visibilita = Privacy::pubblico;
                } elseif ($visibilitaStr === 'solo_amici') {
                    $visibilita = Privacy::solo_amici;
                }

                $utente = FUtente::findById($idUtente);
                if ($utente) {
                    $watchlist = new EWatchlist(0, $nome, $descrizione, [], $visibilita, $utente);
                    FWatchlist::insert($watchlist);
                    header("Location: index.php?controller=Watchlist&action=mostraTutteWatchlist");
                    exit();
                } else {
                    $view->mostraErrore('Utente non trovato.');
                }
            } else {
                $view->mostraErrore('Il nome della watchlist è obbligatorio.');
            }
        } else {
            $view->mostraErrore('Operazione non valida.');
        }
    }
    public function getWatchlistsJSON()
    {
        header('Content-Type: application/json');
        $idUtente = Session::get('user_id');
        $idContenuto = $_GET['idContenuto'] ?? null;

        if (!$idUtente || !$idContenuto) {
            echo json_encode(['success' => false, 'error' => 'Non autenticato o parametri mancanti']);
            exit();
        }

        $watchlists = FWatchlist::findByUtente($idUtente);
        $result = [];
        foreach ($watchlists as $w) {
            $result[] = [
                'id' => $w->getId(),
                'nome' => $w->getNome(),
                'contains' => FWatchlist::contains($w->getId(), $idContenuto)
            ];
        }
        echo json_encode(['success' => true, 'watchlists' => $result]);
        exit();
    }

    public function toggleContenutoAJAX()
    {
        header('Content-Type: application/json');
        $idUtente = Session::get('user_id');
        $idContenuto = $_POST['idContenuto'] ?? null;
        $idWatchlist = $_POST['idWatchlist'] ?? null;

        if (!$idUtente || !$idContenuto || !$idWatchlist) {
            echo json_encode(['success' => false, 'error' => 'Parametri mancanti']);
            exit();
        }

        // Verifica che la watchlist appartenga all'utente
        $watchlist = FWatchlist::findById($idWatchlist);
        if (!$watchlist || $watchlist->getUtente()->getId() !== $idUtente) {
            echo json_encode(['success' => false, 'error' => 'Watchlist non autorizzata']);
            exit();
        }

        if (FWatchlist::contains($idWatchlist, $idContenuto)) {
            FWatchlist::removeContenuto($idWatchlist, $idContenuto);
        } else {
            FWatchlist::addContenuto($idWatchlist, $idContenuto);
        }

        // Determina se il contenuto è ancora salvato in ALMENO UNA watchlist dell'utente
        $watchlists = FWatchlist::findByUtente($idUtente);
        $isInAny = false;
        foreach ($watchlists as $w) {
            if (FWatchlist::contains($w->getId(), $idContenuto)) {
                $isInAny = true;
                break;
            }
        }

        echo json_encode(['success' => true, 'added' => $isInAny]);
        exit();
    }
}
