<?php

/**
 * Classe CRecensione
 * 
 * Controller per la gestione delle recensioni.
 * Gestisce l'inserimento, la modifica e l'eliminazione delle recensioni per film,
 * serie TV ed episodi, oltre alla verifica dei permessi degli utenti che le inseriscono.
 * 
 * @package Controller
 * @author Marco Viscovo
 */
class CRecensione
{
    /**
     * Reindirizza l'utente alla pagina dopo un'operazione
     * 
     * @param int $contenuto_id ID del contenuto
     * @param int|null $episodio_id ID dell'episodio
     * @return void
     */
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

    /**
     * Ricalcola la media di un oggetto (contenuto o episodio)
     * 
     * @param EContenuto|EEpisodio $oggetto Oggetto da aggiornare
     * @param array $recensioni Lista di recensioni
     * @return void
     */
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

    /**
     * Aggiunge una recensione
     */
    public function aggiungiRecensione()
    {
        if (Session::getPost('contenuto_id') !== null && Session::getPost('testo') !== null && Session::getPost('voto') !== null) {
            $contenuto_id = Session::getPost('contenuto_id');
            $testo = Session::getPost('testo');
            $voto = (int)Session::getPost('voto');
            $user_id = Session::get('user_id');

            $utente = FUtente::findById($user_id);
            $contenuto = FContenuto::findById($contenuto_id);

            $episodio_id = (Session::getPost('episodio_id') !== null && Session::getPost('episodio_id') !== '') ? Session::getPost('episodio_id') : null;

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


    /**
     * Modifica una recensione
     */
    public function modificaRecensione()
    {
        if (Session::getPost('recensione_id') !== null && Session::getPost('testo') !== null && Session::getPost('voto') !== null) {
            $recensione_id = Session::getPost('recensione_id');
            $testo = Session::getPost('testo');
            $voto = (int)Session::getPost('voto');

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


                $contenuto_id = Session::getPost('contenuto_id');
                $episodio_id = (Session::getPost('episodio_id') !== null && Session::getPost('episodio_id') !== '') ? Session::getPost('episodio_id') : null;


                self::aggiornaMediaContenutoOEpisodio($contenuto_id, $episodio_id);
                self::reindirizzaDopoOperazione($contenuto_id, $episodio_id);
            }
        }
    }

    /**
     * Elimina una recensione
     */
    public function eliminaRecensione()
    {
        if (Session::getPost('recensione_id') !== null) {
            $recensione_id = Session::getPost('recensione_id');
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


                $redirect_to = Session::getPost('redirect_to') ?? null;
                if ($redirect_to === 'admin') {
                    header("Location: index.php?controller=Admin&action=listaRecensioni");
                    exit();
                } else if ($redirect_to === 'profilo') {
                    $profile_id = Session::getPost('profile_id') ?? Session::get('user_id');
                    header("Location: index.php?controller=Utente&action=mostraProfilo&id=" . $profile_id);
                    exit();
                }

                self::reindirizzaDopoOperazione($contenuto_id, $episodio_id);
            }
        }
    }

    /**
     * Aggiorna la media di un contenuto o di un episodio
     * 
     * @param int $contenuto_id ID del contenuto
     * @param int|null $episodio_id ID dell'episodio
     * @return void
     */
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
