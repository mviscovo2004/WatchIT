<?php

class CRecensione
{

    public function aggiungiRecensione()
    {
        if (!Session::isLogged()) {
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }

        $idContenuto = $_GET['id'] ?? null;
        $idUtente = Session::get('user_id');
        $descrizione = $_POST['descrizione'] ?? null;
        $voto = $_POST['voto'] ?? null;
        $titolo = $_POST['titolo'] ?? null;
        $contenuto = FContenuto::findById($idContenuto);
        $utente = FUtente::findById($idUtente);
        $idRecensione = 0;

        if ($contenuto && $utente && $titolo && $voto && $descrizione) {
            FRecensione::aggiungiRecensione($idRecensione, $titolo, $voto, $descrizione, $contenuto, $utente);
            header("Location: index.php?controller=Contenuto&action=dettagli&id=" . $idContenuto);
            exit();
        } else {
            $error = "Errore durante l'aggiunta della recensione.";
            $view = new VContenuto();
            $view->mostraDettagli($contenuto, $error);
        }
    }

    public function eliminaRecensione()
    {
        if (!Session::isLogged()) {
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }

        $idRecensione = $_GET['id'] ?? null;
        $recensione = FRecensione::findById($idRecensione);
        $contenuto = $recensione->getContenuto();
        $idContenuto = $contenuto->getId();
        $idUtente = Session::get('user_id');
        $utente = FUtente::findById($idUtente);
        if ($recensione && $recensione->getUtente() == $utente) {
            FRecensione::delete($recensione);
            header("Location: index.php?controller=Contenuto&action=dettagli&id=" . $idContenuto);
            exit();
        } else {
            $error = "Errore durante l'eliminazione della recensione.";
            $view = new VContenuto();
            $view->mostraDettagli($contenuto, $error);
        }
    }

    public function modificaRecensione()
    {
        if (!Session::isLogged()) {
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }

        $idRecensione = $_GET['id'] ?? null;
        $recensione = FRecensione::findById($idRecensione);
        $contenuto = $recensione->getContenuto();
        $idContenuto = $contenuto->getId();
        $idUtente = Session::get('user_id');
        $utente = FUtente::findById($idUtente);
        $descrizione = $_POST['descrizione'] ?? null;
        $voto = $_POST['voto'] ?? null;
        $titolo = $_POST['titolo'] ?? null;
        if ($recensione && $recensione->getUtente() == $utente && $descrizione && $voto && $titolo) {
            $recensione->setTitolo($titolo);
            $recensione->setVoto($voto);
            $recensione->setDescrizione($descrizione);
            FRecensione::update($recensione);
            header("Location: index.php?controller=Contenuto&action=dettagli&id=" . $idContenuto);
            exit();
        } else {
            $error = "Errore durante la modifica della recensione.";
            $view = new VContenuto();
            $view->mostraDettagli($contenuto, $error);
        }
    }


    public function mostraRecensioni()
    {
        $idContenuto = $_GET['id'] ?? null;
        $contenuto = FContenuto::findById($idContenuto);
        $recensioni = FRecensione::findByContenuto($idContenuto);
        $view = new VContenuto();
        $view->mostraDettagli($contenuto, $recensioni);
    }

    public function mostraUltimeRecensioni(int $limit = 5)
    {
        $recensioni = FRecensione::getUltimeRecensioni($limit);
        $view = new VContenuto();
        $view->mostraUltimeRecensioni($recensioni, $limit);
    }
}
