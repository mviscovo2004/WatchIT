<?php

class CAdmin
{


    public function dashboard()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $stats = [
            'utenti' => count(FUtente::findAll()),
            'contenuti' => count(FContenuto::findAll()),
            'recensioni' => count(FRecensione::findAll())
        ];
        $contenuti = FContenuto::findAll();
        $contenutiRecenti = array_slice(array_reverse($contenuti), 0, 5);
        $view = new VAdmin();
        $view->mostraDashboard($stats, $contenutiRecenti);
    }

    public function listaUtenti()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $utenti = FUtente::findAll();
        $view = new VAdmin();
        $view->mostraUtenti($utenti);
    }

    public function listaContenuti()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $contenuti = FContenuto::findAll();
        $view = new VAdmin();
        $view->mostraContenuti($contenuti);
    }

    public function listaRecensioni()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $recensioni = FRecensione::findAll();
        $view = new VAdmin();
        $view->mostraRecensioni($recensioni);
    }

    public function mostraAggiungiContenuto()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $view = new VAdmin();
        $view->mostraAggiungiContenuto();
    }

    public function aggiungiContenuto()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }

        $contenuto = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contenuto = new EContenuto(
                null,
                0,
                trim($_POST['titolo'] ?? ''),
                trim($_POST['anno'] ?? ''),
                trim($_POST['trama'] ?? ''),
                (float)($_POST['valutazioneMedia'] ?? 0.0),
                [],
                trim($_POST['locandina'] ?? ''),
                $_POST['generi'] ?? []
            );

            if (isset($_POST['partecipazioni'])) {
                $contenuto->setPartecipazioni($_POST['partecipazioni']);
            }

            $contenuto = FContenuto::insert($contenuto);
        }

        if ($contenuto) {
            header("Location: index.php?controller=Admin&action=listaContenuti");
            exit();
        } else {
            $view = new VAdmin();
            $view->mostraAggiungiContenuto();
        }
    }

    public function banUtente()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $durata = $_GET['durata'];
        $idUtente = $_GET['idUtente'];
        $dataFine = new DateTime('+' . $durata . ' days');
        $motivo = $_POST['motivo'] ?? '';
        $idAmministratore = Session::get('user_id');
        FBan::ban($idUtente, $dataFine, $motivo, $idAmministratore);
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }

    public function unbanUtente()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $idUtente = $_GET['idUtente'];
        FBan::unban($idUtente);
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }

    public function listaBannati()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $bannati = FBan::findByBannati();
        $view = new VAdmin();
        $view->mostraBannati($bannati);
    }

    public function promuoviAdAdmin()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $idUtente = $_GET['idUtente'] ?? $_GET['id'] ?? null;
        if ($idUtente) {
            $utente = FUtente::findById($idUtente);
            if ($utente) {
                // Esegui la promozione solo se l'utente non ha ban attivi
                $userBans = FBan::findByUtente($utente);
                if (empty($userBans)) {
                    FUtente::promuoviAdAdmin($idUtente);
                }
            }
        }
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }


    public function retrocediAdUtente()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $idUtente = $_GET['idUtente'] ?? $_GET['id'] ?? null;
        if ($idUtente) {
            FUtente::retrocediAdUtente($idUtente);
        }
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }

    public function eliminaUtente()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
        $idUtente = $_GET['idUtente'] ?? $_GET['id'] ?? null;
        if ($idUtente) {
            $utente = FUtente::findById($idUtente);
            if ($utente) {
                FUtente::delete($utente);
            }
        }
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }
}
