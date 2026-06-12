<?php
class CRecensione
{

    public function aggiungiRecensione()
    {
        if (isset($_POST['contenuto_id']) && isset($_POST['testo']) && isset($_POST['voto'])) {
            $contenuto_id = $_POST['contenuto_id'];
            $testo = $_POST['testo'];
            $voto = (int)$_POST['voto'];
            $user_id = Session::get('user_id');

            $utente = FUtente::findById($user_id);
            $contenuto = FContenuto::findById($contenuto_id);


            $episodio_id = isset($_POST['episodio_id']) && $_POST['episodio_id'] !== '' ? $_POST['episodio_id'] : null;

            if ($episodio_id) {

                $episodio = FEpisodio::findById($episodio_id);
                $successo = FRecensione::aggiungiRecensioneEpisodio(0, "", $voto, $testo, $contenuto, $episodio, $utente);

                if ($successo) {
                    header("Location: index.php?controller=Contenuto&action=mostraEpisodio&serie=" . $contenuto_id . "&id=" . $episodio_id);
                    exit();
                }
            } else {
                $successo = FRecensione::aggiungiRecensione(0, "", $voto, $testo, $contenuto, $utente);

                if ($successo) {
                    if ($contenuto instanceof ESerie) {
                        header("Location: index.php?controller=Contenuto&action=mostraSerie&id=" . $contenuto_id);
                    } else {
                        header("Location: index.php?controller=Contenuto&action=mostraFilm&id=" . $contenuto_id);
                    }
                    exit();
                }
            }
        }
    }


    public function modificaRecensione()
    {
        if (isset($_POST['recensione_id']) && isset($_POST['testo']) && isset($_POST['voto'])) {
            $recensione_id = $_POST['recensione_id'];
            $testo = $_POST['testo'];
            $voto = (int)$_POST['voto'];


            $recensione = FRecensione::findById($recensione_id);

            if ($recensione) {

                $recensione->setDescrizione($testo);
                $recensione->setVoto($voto);

                FRecensione::update($recensione);

                $contenuto_id = $_POST['contenuto_id'];
                $episodio_id = isset($_POST['episodio_id']) && $_POST['episodio_id'] !== '' ? $_POST['episodio_id'] : null;

                if ($episodio_id) {
                    header("Location: index.php?controller=Contenuto&action=mostraEpisodio&serie=" . $contenuto_id . "&id=" . $episodio_id);
                } else {
                    $contenuto = FContenuto::findById($contenuto_id);
                    if ($contenuto instanceof ESerie) {
                        header("Location: index.php?controller=Contenuto&action=mostraSerie&id=" . $contenuto_id);
                    } else {
                        header("Location: index.php?controller=Contenuto&action=mostraFilm&id=" . $contenuto_id);
                    }
                }
                exit();
            }
        }
    }


    public function eliminaRecensione()
    {
        if (isset($_POST['recensione_id'])) {
            $recensione_id = $_POST['recensione_id'];

            $recensione = FRecensione::findById($recensione_id);

            if ($recensione) {
                FRecensione::delete($recensione);

                // Gestione dei redirect personalizzati
                $redirect_to = $_POST['redirect_to'] ?? null;
                if ($redirect_to === 'admin') {
                    header("Location: index.php?controller=Admin&action=listaRecensioni");
                    exit();
                } else if ($redirect_to === 'profilo') {
                    $profile_id = $_POST['profile_id'] ?? Session::get('user_id');
                    header("Location: index.php?controller=Utente&action=mostraProfilo&id=" . $profile_id);
                    exit();
                }


                $contenuto_id = $_POST['contenuto_id'];
                $episodio_id = isset($_POST['episodio_id']) && $_POST['episodio_id'] !== '' ? $_POST['episodio_id'] : null;

                if ($episodio_id) {
                    header("Location: index.php?controller=Contenuto&action=mostraEpisodio&serie=" . $contenuto_id . "&id=" . $episodio_id);
                } else {
                    $contenuto = FContenuto::findById($contenuto_id);
                    if ($contenuto instanceof ESerie) {
                        header("Location: index.php?controller=Contenuto&action=mostraSerie&id=" . $contenuto_id);
                    } else {
                        header("Location: index.php?controller=Contenuto&action=mostraFilm&id=" . $contenuto_id);
                    }
                }
                exit();
            }
        }
    }
}
