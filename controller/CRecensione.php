<?php
class CRecensione
{
    private static function reindirizzaDopoOperazione($contenuto_id, $episodio_id = null)
    {
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


    private static function ricalcolaMediaOggetto($oggetto, array $recensioni)
    {
        $em = FEntityManager::getInstance();

        
        if ($oggetto->getValutazioneIniziale() === null) {
            $oggetto->setValutazioneIniziale($oggetto->getValutazioneMedia());
        }

        $votoIniziale = $oggetto->getValutazioneIniziale();
        $totaleRecensioni = count($recensioni);

        
        $somma = $votoIniziale;
        foreach ($recensioni as $r) {
            $somma += $r->getVoto();
        }

        $media = $somma / (1 + $totaleRecensioni);

        $oggetto->setValutazioneMedia(round($media, 1));
        $em->persist($oggetto);
        $em->flush();
    }

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
                    
                    self::aggiornaMediaContenutoOEpisodio($contenuto_id, $episodio_id);
                    self::reindirizzaDopoOperazione($contenuto_id, $episodio_id);
                }
            } else {
                $successo = FRecensione::aggiungiRecensione(0, "", $voto, $testo, $contenuto, $utente);

                if ($successo) {
                    
                    self::aggiornaMediaContenutoOEpisodio($contenuto_id);
                    self::reindirizzaDopoOperazione($contenuto_id);
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
                
                $idUtenteLoggato = Session::get('user_id');
                
                if ($idUtenteLoggato === null || ($recensione->getUtente()->getId() !== $idUtenteLoggato)) {
                    $view = new VView();
                    $view->assign('errore', 'Non hai i permessi per modificare questa recensione.');
                    $view->display('errore.tpl');
                    exit();
                }
                

                $recensione->setDescrizione($testo);
                $recensione->setVoto($voto);

                FRecensione::update($recensione);


                $contenuto_id = $_POST['contenuto_id'];
                $episodio_id = isset($_POST['episodio_id']) && $_POST['episodio_id'] !== '' ? $_POST['episodio_id'] : null;

                
                self::aggiornaMediaContenutoOEpisodio($contenuto_id, $episodio_id);
                self::reindirizzaDopoOperazione($contenuto_id, $episodio_id);
            }
        }
    }


    public function eliminaRecensione()
    {
        if (isset($_POST['recensione_id'])) {
            $recensione_id = $_POST['recensione_id'];
            $recensione = FRecensione::findById($recensione_id);

            if ($recensione) {

                
                $idUtenteLoggato = Session::get('user_id');
                $ruolo = Session::get('ruolo');

                
                if ($idUtenteLoggato === null || ($recensione->getUtente()->getId() !== $idUtenteLoggato && $ruolo !== 'admin')) {
                    $view = new VView();
                    $view->assign('errore', 'Non hai i permessi per eliminare questa recensione.');
                    $view->display('errore.tpl');
                    exit();
                }
                


                
                $contenuto_id = $recensione->getContenuto() ? $recensione->getContenuto()->getId() : null;
                $episodio_id = $recensione->getEpisodio() ? $recensione->getEpisodio()->getId() : null;

                FRecensione::delete($recensione);

                
                self::aggiornaMediaContenutoOEpisodio($contenuto_id, $episodio_id);

                
                $redirect_to = $_POST['redirect_to'] ?? null;
                if ($redirect_to === 'admin') {
                    header("Location: index.php?controller=Admin&action=listaRecensioni");
                    exit();
                } else if ($redirect_to === 'profilo') {
                    $profile_id = $_POST['profile_id'] ?? Session::get('user_id');
                    header("Location: index.php?controller=Utente&action=mostraProfilo&id=" . $profile_id);
                    exit();
                }

                self::reindirizzaDopoOperazione($contenuto_id, $episodio_id);
            }
        }
    }

    private static function aggiornaMediaContenutoOEpisodio($contenuto_id, $episodio_id = null)
    {
        $em = FEntityManager::getInstance();
        if ($episodio_id) {
            $episodio = $em->find(EEpisodio::class, $episodio_id);
            if ($episodio) {
                $recensioni = $em->getRepository(ERecensione::class)->findBy([
                    'episodio' => $episodio
                ]);
                self::ricalcolaMediaOggetto($episodio, $recensioni);
            }
        } else if ($contenuto_id) {
            $contenuto = $em->find(EContenuto::class, $contenuto_id);
            if ($contenuto) {
                $recensioni = $em->getRepository(ERecensione::class)->findBy([
                    'contenuto' => $contenuto,
                    'episodio' => null
                ]);
                self::ricalcolaMediaOggetto($contenuto, $recensioni);
            }
        }
    }
}
