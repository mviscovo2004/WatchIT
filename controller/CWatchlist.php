<?php

class CWatchlist
{
    private VWatchlist $view;

    public function __construct()
    {
        $this->view = new VWatchlist();
    }

    private function richiediLogin()
    {
        $idUtente = Session::get('user_id');
        if (!$idUtente) {
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }
        return $idUtente;
    }


    public function mostra()
    {
        $idWatchlist = $_GET['id'] ?? null;
        if ($idWatchlist) {
            $watchlist = FWatchlist::findById($idWatchlist);
            if ($watchlist) {
                
                $idUtenteLoggato = Session::get('user_id');

                $visibilita = $watchlist->getVisibilita();
                $idProprietario = $watchlist->getUtente()->getId();

                $hasAccess = false;

                if ($visibilita === Privacy::pubblico) {
                    $hasAccess = true;
                } elseif ($idUtenteLoggato !== null) {
                    
                    if ($idUtenteLoggato === $idProprietario) {
                        $hasAccess = true;
                    } elseif ($visibilita === Privacy::solo_amici) {
                        
                        if (class_exists('FUtente') && FUtente::isFollowing($idUtenteLoggato, $idProprietario) && FUtente::isFollowing($idProprietario, $idUtenteLoggato)) {
                            $hasAccess = true;
                        }
                    }
                }

                if ($hasAccess) {
                    $contenuti = $watchlist->getContenutiSalvati();
                    $this->view->mostraWatchlist($watchlist, $contenuti);
                } else {
                    $this->view->mostraErrore('Accesso negato. Questa watchlist è privata.');
                }
            } else {
                $this->view->mostraErrore('Watchlist non trovata.');
            }
        } else {
            $this->view->mostraErrore('ID Watchlist non valido.');
        }
    }

    public function aggiungi()
    {
        $idContenuto = $_GET['id'] ?? null;
        $idWatchlist = $_GET['idWatchlist'] ?? null;

        $idUtente = $this->richiediLogin();

        if ($idContenuto) {
            
            if (!$idWatchlist) {
                $watchlists = FWatchlist::findByUtente($idUtente);
                if (empty($watchlists)) {
                    
                    $utente = FUtente::findById($idUtente);
                    if ($utente) {
                        $defaultWatchlist = new EWatchlist(0, 'La mia Lista', 'Watchlist di default per i tuoi contenuti preferiti.', [], Privacy::privato, $utente);
                        FWatchlist::insert($defaultWatchlist);
                        $idWatchlist = $defaultWatchlist->getId();
                    } else {
                        $this->view->mostraErrore('Utente non trovato.');
                        return;
                    }
                } else {
                    $idWatchlist = $watchlists[0]->getId();
                }

                
                if (FWatchlist::contains($idWatchlist, $idContenuto)) {
                    FWatchlist::removeContenuto($idWatchlist, $idContenuto);
                } else {
                    FWatchlist::addContenuto($idWatchlist, $idContenuto);
                }

                $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
                header("Location: " . $referer);
                exit();
            } else {
                
                $watchlist = FWatchlist::findById($idWatchlist);
                if ($watchlist) {
                    
                    if ($watchlist->getUtente()->getId() === $idUtente) {
                        FWatchlist::addContenuto($idWatchlist, $idContenuto);
                        
                        header("Location: index.php?controller=Watchlist&action=mostra&id=" . $idWatchlist);
                        exit();
                    } else {
                        $this->view->mostraErrore('Operazione non consentita.');
                    }
                } else {
                    $this->view->mostraErrore('Watchlist non trovata.');
                }
            }
        } else {
            $this->view->mostraErrore('ID Contenuto non specificato.');
        }
    }

    public function rimuovi()
    {
        $idContenuto = $_GET['id'] ?? null;
        $idWatchlist = $_GET['idWatchlist'] ?? null;

        $idUtente = $this->richiediLogin();

        if ($idContenuto && $idUtente && $idWatchlist) {
            $watchlist = FWatchlist::findById($idWatchlist);
            if ($watchlist) {
                
                if ($watchlist->getUtente()->getId() === $idUtente) {
                    FWatchlist::removeContenuto($idWatchlist, $idContenuto);
                    
                    header("Location: index.php?controller=Watchlist&action=mostra&id=" . $idWatchlist);
                    exit();
                } else {
                    $this->view->mostraErrore('Operazione non consentita.');
                }
            } else {
                $this->view->mostraErrore('Watchlist non trovata.');
            }
        } else {
            $this->view->mostraErrore('Errore nel salvataggio. Parametri mancanti.');
        }
    }


    public function mostraTutteWatchlist()
    {
        $idUtente = $this->richiediLogin();

        $watchlists = FWatchlist::findByUtente($idUtente);
        $this->view->mostraTutteWatchlist($watchlists);
    }


    public function crea()
    {
        $idUtente = $this->richiediLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $descrizione = trim($_POST['descrizione'] ?? '');
            $visibilita = $_POST['visibilita'] ?? 'privato';

            if (!empty($nome)) {
                $utente = FUtente::findById($idUtente);
                if ($utente) {
                    $privacy = Privacy::privato;
                    if ($visibilita === 'pubblico') {
                        $privacy = Privacy::pubblico;
                    } elseif ($visibilita === 'solo_amici') {
                        $privacy = Privacy::solo_amici;
                    }

                    $watchlist = new EWatchlist(0, $nome, $descrizione, [], $privacy, $utente);
                    FWatchlist::insert($watchlist);

                    header("Location: index.php?controller=Watchlist&action=mostraTutteWatchlist");
                    exit();
                } else {
                    $this->view->mostraErrore('Utente non trovato.');
                }
            } else {
                $this->view->mostraErrore('Il nome della watchlist è obbligatorio.');
            }
        }
    }


    public function elimina()
    {
        $idWatchlist = $_GET['id'] ?? null;
        $idUtente = $this->richiediLogin();

        if ($idWatchlist) {
            $watchlist = FWatchlist::findById($idWatchlist);
            if ($watchlist) {
                if ($watchlist->getUtente()->getId() === $idUtente) {
                    FWatchlist::delete($watchlist);
                    header("Location: index.php?controller=Watchlist&action=mostraTutteWatchlist");
                    exit();
                } else {
                    $this->view->mostraErrore('Operazione non consentita.');
                }
            } else {
                $this->view->mostraErrore('Watchlist non trovata.');
            }
        } else {
            $this->view->mostraErrore('Parametri non validi per l\'eliminazione.');
        }
    }

    public function modifica()
    {
        $idWatchlist = $_GET['id'] ?? null;
        $idUtente = $this->richiediLogin();

        if ($idWatchlist) {
            $watchlist = FWatchlist::findById($idWatchlist);
            if ($watchlist) {
                if ($watchlist->getUtente()->getId() === $idUtente) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $nome = trim($_POST['nome'] ?? $watchlist->getNome());
                        $descrizione = trim($_POST['descrizione'] ?? $watchlist->getDescrizione());
                        $visibilitaStr = $_POST['visibilita'] ?? $watchlist->getVisibilita()->name;

                        if (!empty($nome)) {
                            
                            $privacy = Privacy::privato;
                            if ($visibilitaStr === 'pubblico') {
                                $privacy = Privacy::pubblico;
                            } elseif ($visibilitaStr === 'solo_amici') {
                                $privacy = Privacy::solo_amici;
                            }

                            $watchlist->setNome($nome);
                            $watchlist->setDescrizione($descrizione);
                            $watchlist->setVisibilita($privacy);

                            FWatchlist::update($watchlist);

                            
                            $redirectTo = $_POST['redirect_to'] ?? 'lista';
                            if ($redirectTo === 'dettaglio') {
                                header("Location: index.php?controller=Watchlist&action=mostra&id=" . $idWatchlist);
                            } else {
                                header("Location: index.php?controller=Watchlist&action=mostraTutteWatchlist");
                            }
                            exit();
                        } else {
                            $this->view->mostraErrore('Il nome della watchlist è obbligatorio.');
                        }
                    } else {
                        $this->view->mostraErrore('Metodo di richiesta non supportato.');
                    }
                } else {
                    $this->view->mostraErrore('Operazione non consentita.');
                }
            } else {
                $this->view->mostraErrore('Watchlist non trovata.');
            }
        } else {
            $this->view->mostraErrore('Parametri non validi per la modifica.');
        }
    }


    public function getWatchlistsJSON()
    {
        header('Content-Type: application/json');
        $idUtente = Session::get('user_id');
        if (!$idUtente) {
            echo json_encode(['success' => false, 'error' => 'Utente non autenticato.']);
            exit();
        }

        $idContenuto = (int)($_GET['idContenuto'] ?? 0);
        if (!$idContenuto) {
            echo json_encode(['success' => false, 'error' => 'ID Contenuto mancante.']);
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
        if (!$idUtente) {
            echo json_encode(['success' => false, 'error' => 'Utente non autenticato.']);
            exit();
        }

        $idContenuto = (int)($_POST['idContenuto'] ?? 0);
        $idWatchlist = (int)($_POST['idWatchlist'] ?? 0);

        if (!$idContenuto || !$idWatchlist) {
            echo json_encode(['success' => false, 'error' => 'Parametri mancanti.']);
            exit();
        }

        $watchlist = FWatchlist::findById($idWatchlist);
        if (!$watchlist || $watchlist->getUtente()->getId() !== $idUtente) {
            echo json_encode(['success' => false, 'error' => 'Operazione non consentita.']);
            exit();
        }

        
        if (FWatchlist::contains($idWatchlist, $idContenuto)) {
            FWatchlist::removeContenuto($idWatchlist, $idContenuto);
            $added = false;
        } else {
            FWatchlist::addContenuto($idWatchlist, $idContenuto);
            $added = true;
        }

        echo json_encode(['success' => true, 'added' => $added]);
        exit();
    }
}
