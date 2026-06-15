<?php

class CAdmin
{


    private VAdmin $view;

    public function __construct()
    {
        $this->view = new VAdmin();
    }


    public function verificaAdmin()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            $view = new VAdmin();
            $view->mostraAccessoNegato();
        }
    }

    public function dashboard()
    {
        $this->verificaAdmin();

        $stats = [
            'utenti' => count(FUtente::findAll()),
            'contenuti' => count(FContenuto::findAll()),
            'recensioni' => count(FRecensione::findAll())
        ];
        $contenuti = FContenuto::findAll();
        $contenutiRecenti = array_slice(array_reverse($contenuti), 0, 5);
        $this->view->mostraDashboard($stats, $contenutiRecenti);
    }

    public function listaUtenti()
    {
        $this->verificaAdmin();
        $utenti = FUtente::findAll();
        $this->view->mostraUtenti($utenti);
    }

    public function listaContenuti()
    {
        $this->verificaAdmin();
        $contenuti = FContenuto::findAll();
        $this->view->mostraContenuti($contenuti);
    }

    public function listaFilm()
    {
        $this->verificaAdmin();
        $film = FContenuto::findAllFilm();
        $this->view->mostraFilm($film);
    }

    public function listaSerie()
    {
        $this->verificaAdmin();
        $serie = FContenuto::findAllSerie();
        $this->view->mostraSerie($serie);
    }

    public function listaRecensioni()
    {
        $this->verificaAdmin();
        $recensioni = FRecensione::findAll();
        $this->view->mostraRecensioni($recensioni);
    }

    public function mostraAggiungiContenuto()
    {
        $this->verificaAdmin();
        $this->view->mostraAggiungiContenuto();
    }

    public function aggiungiContenuto()
    {
        $this->verificaAdmin();

        if (Session::isPost()) {
            $tipo = trim(Session::getPost('tipo') ?? 'film');
            $titolo = trim(Session::getPost('titolo') ?? '');
            $anno = trim(Session::getPost('anno') ?? '');
            $trama = trim(Session::getPost('trama') ?? '');
            $valutazioneMedia = (float)(Session::getPost('valutazioneMedia') ?? 0.0);
            $locandina = trim(Session::getPost('locandina') ?? '');
            $generi = Session::getPost('generi') ?? [];

            $em = FEntityManager::getInstance();

            if ($tipo === 'film') {
                $durataMinuti = (int)(Session::getPost('durataMinuti') ?? 0);
                $contenuto = new EFilm(
                    null,
                    0,
                    $titolo,
                    $anno,
                    $trama,
                    $valutazioneMedia,
                    [],
                    $locandina,
                    $generi,
                    [],
                    $durataMinuti
                );
            } else {
                $numeroStagioni = (int)(Session::getPost('numeroStagioni', 1));
                $statoInput = Session::getPost('stato', 'in_corso');
                $statoEnum = match ($statoInput) {
                    'conclusa' => Stato::conclusa,
                    'cancellata' => Stato::cancellata,
                    default => Stato::in_corso,
                };
                $contenuto = new ESerie(
                    null,
                    0,
                    $titolo,
                    $anno,
                    $trama,
                    $valutazioneMedia,
                    [],
                    $locandina,
                    $generi,
                    [],
                    $numeroStagioni,
                    [],
                    $statoEnum
                );
            }

            $contenuto->setValutazioneIniziale($valutazioneMedia);
            $em->persist($contenuto);
            $em->flush();


            $registaInput = Session::getPost('regista') ?? '';
            $attoriInput = Session::getPost('attori') ?? '';
            $this->salvaPartecipazioni($contenuto, $registaInput, $attoriInput);


            $referer = Session::getServer('HTTP_REFERER') ?? 'index.php?controller=Admin&action=listaContenuti';
            header("Location: " . $referer);
            exit();
        }

        $this->view->mostraAggiungiContenuto();
    }

    public function dettagliContenutoAjax()
    {
        if (!Session::isLogged() || Session::get('ruolo') !== 'admin') {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Non autorizzato']);
            exit();
        }


        $id = (int)(Session::getGet('id') ?? 0);
        if ($id) {
            $contenuto = FContenuto::findById($id);
            if ($contenuto) {
                $tipo = ($contenuto instanceof EFilm) ? 'film' : 'serie';
                $data = [
                    'id' => $contenuto->getId(),
                    'tipo' => $tipo,
                    'titolo' => $contenuto->getTitolo(),
                    'anno' => $contenuto->getAnno(),
                    'trama' => $contenuto->getTrama(),
                    'valutazioneMedia' => $contenuto->getValutazioneMedia(),
                    'locandina' => $contenuto->getLocandina(),
                    'generi' => $contenuto->getGeneri(),
                    'regista' => $contenuto->getRegista(),
                    'attori' => $contenuto->getAttori()
                ];

                if ($tipo === 'film') {
                    $data['durataMinuti'] = $contenuto->getDurata();
                } else {
                    $data['numeroStagioni'] = $contenuto->getNumeroStagioni();
                    $data['stato'] = $contenuto->getStato()->value;
                }

                header('Content-Type: application/json');
                echo json_encode($data);
                exit();
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['error' => 'Contenuto non trovato']);
        exit();
    }

    public function modificaContenuto()
    {
        $this->verificaAdmin();

        if (Session::isPost()) {
            $id = (int)(Session::getPost('id', 0));
            $contenuto = FContenuto::findById($id);
            if ($contenuto) {
                $contenuto->setTitolo(trim(Session::getPost('titolo', '')));
                $contenuto->setAnno(trim(Session::getPost('anno', '')));
                $contenuto->setTrama(trim(Session::getPost('trama', '')));
                $contenuto->setValutazioneMedia((float)(Session::getPost('valutazioneMedia', 0.0)));


                $locandina = trim(Session::getPost('locandina', ''));
                if (strpos($locandina, 'https://image.tmdb.org/t/p/w500') === 0) {
                    $locandina = str_replace('https://image.tmdb.org/t/p/w500', '', $locandina);
                }
                $contenuto->setLocandina($locandina);

                $contenuto->setGeneri(Session::getPost('generi') ?? []);

                if ($contenuto instanceof EFilm) {
                    $contenuto->setDurata((int)(Session::getPost('durataMinuti', 0)));
                } else if ($contenuto instanceof ESerie) {
                    $contenuto->setNumeroStagioni((int)(Session::getPost('numeroStagioni', 0)));
                    $statoInput = Session::getPost('stato', 'in_corso');
                    $statoEnum = match ($statoInput) {
                        'conclusa' => Stato::conclusa,
                        'cancellata' => Stato::cancellata,
                        default => Stato::in_corso,
                    };
                    $contenuto->setStato($statoEnum);
                }

                $em = FEntityManager::getInstance();
                $em->persist($contenuto);
                $em->flush();


                $registaInput = Session::getPost('regista') ?? '';
                $attoriInput = Session::getPost('attori') ?? '';
                $this->salvaPartecipazioni($contenuto, $registaInput, $attoriInput);

                $referer = Session::getServer('HTTP_REFERER', 'index.php?controller=Admin&action=listaContenuti');
                header("Location: " . $referer);
                exit();
            }
        }
    }

    private function ottieniOCreaPersona(string $nomeCompleto)
    {
        $em = FEntityManager::getInstance();
        $parti = explode(" ", trim($nomeCompleto), 2);
        $nome = trim($parti[0]);
        $cognome = isset($parti[1]) ? trim($parti[1]) : '';


        $persona = $em->getRepository(EPersona::class)->findOneBy(['nome' => $nome, 'cognome' => $cognome]);
        if (!$persona) {

            $persona = new EPersona(null, 0, $nome, $cognome, '');
            $em->persist($persona);
            $em->flush();
        }
        return $persona;
    }


    private function salvaPartecipazioni($contenuto, $registaInput, $attoriInput)
    {
        $em = FEntityManager::getInstance();


        $vecchiePartecipazioni = $em->getRepository(EPartecipazione::class)->findBy(['contenuto' => $contenuto]);
        foreach ($vecchiePartecipazioni as $p) {
            $em->remove($p);
        }
        $em->flush();


        $registaInput = trim($registaInput);
        if (!empty($registaInput)) {

            $regista = $this->ottieniOCreaPersona($registaInput);

            $p = new EPartecipazione(0, $regista, $contenuto, 'Regista', '');
            $em->persist($p);
        }


        if (!empty($attoriInput)) {
            $attoriNomi = explode(",", $attoriInput);
            foreach ($attoriNomi as $nomeAttore) {
                $nomeAttore = trim($nomeAttore);
                if (empty($nomeAttore)) continue;


                $attore = $this->ottieniOCreaPersona($nomeAttore);

                $p = new EPartecipazione(0, $attore, $contenuto, 'Attore', '');
                $em->persist($p);
            }
        }

        $em->flush();
    }



    public function inserisciDaTMDB()
    {
        $this->verificaAdmin();

        $film = FContenuto::findAllFilm();
        $serie = FContenuto::findAllSerie();


        $ultimiFilm = array_slice(array_reverse($film), 0, 5);
        $ultimeSerie = array_slice(array_reverse($serie), 0, 5);

        $this->view->mostraInserisciDaTMDB($ultimiFilm, $ultimeSerie);
    }


    public function importaDaTMDB()
    {
        $this->verificaAdmin();

        if (Session::isPost()) {
            $titolo = trim(Session::getPost('titolo') ?? '');

            if (empty($titolo)) {
                Session::set('import_error', "Inserisci un titolo valido.");
                header("Location: index.php?controller=Admin&action=inserisciDaTMDB");
                exit();
            }


            $risultati = FTMDb::search($titolo);

            if (empty($risultati)) {
                Session::set('import_error', "Nessun contenuto trovato su TMDB con il titolo '$titolo'.");
                header("Location: index.php?controller=Admin&action=inserisciDaTMDB");
                exit();
            }


            $contenutoScelto = null;
            foreach ($risultati as $r) {
                if (isset($r['media_type']) && ($r['media_type'] === 'movie' || $r['media_type'] === 'tv')) {
                    $contenutoScelto = $r;
                    break;
                }
            }

            if ($contenutoScelto === null) {
                Session::set('import_error', "Nessun film o serie TV trovato per '$titolo'.");
                header("Location: index.php?controller=Admin&action=inserisciDaTMDB");
                exit();
            }

            $em = FEntityManager::getInstance();
            $tmdbId = $contenutoScelto['id'];
            $mediaType = $contenutoScelto['media_type'];

            if ($mediaType === 'movie') {

                $esiste = $em->getRepository(EFilm::class)->findOneBy(['tmdbId' => $tmdbId]);
                if ($esiste) {
                    Session::set('import_error', "Il film '" . $esiste->getTitolo() . "' è già presente a catalogo.");
                    header("Location: index.php?controller=Admin&action=inserisciDaTMDB");
                    exit();
                }


                $details = FTMDb::fetchFilm($tmdbId);

                $film = new EFilm(
                    $details['id'],
                    0,
                    $details['title'] ?? 'N/A',
                    $details['release_date'] ?? '',
                    $details['overview'] ?? '',
                    $details['vote_average'] ?? 0.0,
                    [],
                    $details['poster_path'] ?? '',
                    $details['genres'] ?? [],
                    $details['videos']['results'] ?? [],
                    $details['runtime'] ?? 0
                );

                $film->setValutazioneIniziale($details['vote_average'] ?? 0.0);
                $em->persist($film);


                if (isset($details['credits']['cast'])) {
                    $cast = array_slice($details['credits']['cast'], 0, 5);
                    foreach ($cast as $attoreData) {
                        $attoreId = $attoreData['id'];
                        $attoreDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $attoreId]);

                        if (!$attoreDB) {
                            $partiNome = explode(" ", $attoreData['name'], 2);
                            $nome = $partiNome[0];
                            $cognome = $partiNome[1] ?? '';
                            $attoreDB = new EPersona($attoreId, 0, $nome, $cognome, $attoreData['profile_path'] ?? '');
                            $em->persist($attoreDB);
                        }

                        $partecipazione = new EPartecipazione(0, $attoreDB, $film, 'Attore', $attoreData['character'] ?? '');
                        $em->persist($partecipazione);
                    }
                }


                if (isset($details['credits']['crew'])) {
                    foreach ($details['credits']['crew'] as $crewMember) {
                        if ($crewMember['job'] === 'Director') {
                            $registaId = $crewMember['id'];
                            $registaDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $registaId]);

                            if (!$registaDB) {
                                $partiNome = explode(" ", $crewMember['name'], 2);
                                $nome = $partiNome[0];
                                $cognome = $partiNome[1] ?? '';
                                $registaDB = new EPersona($registaId, 0, $nome, $cognome, $crewMember['profile_path'] ?? '');
                                $em->persist($registaDB);
                            }

                            $partecipazione = new EPartecipazione(0, $registaDB, $film, 'Regista', '');
                            $em->persist($partecipazione);
                            break;
                        }
                    }
                }

                $em->flush();
                Session::set('import_success', "Il film '" . $film->getTitolo() . "' è stato importato con successo!");
            } else if ($mediaType === 'tv') {

                $esiste = $em->getRepository(ESerie::class)->findOneBy(['tmdbId' => $tmdbId]);
                if ($esiste) {
                    Session::set('import_error', "La serie TV '" . $esiste->getTitolo() . "' è già presente a catalogo.");
                    header("Location: index.php?controller=Admin&action=inserisciDaTMDB");
                    exit();
                }


                $details = FTMDb::fetchSerie($tmdbId);

                $statoAPI = $details['status'] ?? '';
                $statoObj = match ($statoAPI) {
                    'Ended' => Stato::conclusa,
                    'Canceled' => Stato::cancellata,
                    default => Stato::in_corso,
                };

                $serie = new ESerie(
                    $details['id'],
                    0,
                    $details['name'] ?? 'N/A',
                    $details['first_air_date'] ?? '',
                    $details['overview'] ?? '',
                    $details['vote_average'] ?? 0.0,
                    [],
                    $details['poster_path'] ?? '',
                    $details['genres'] ?? [],
                    $details['videos']['results'] ?? [],
                    $details['number_of_seasons'] ?? 1,
                    [],
                    $statoObj
                );

                $serie->setValutazioneIniziale($details['vote_average'] ?? 0.0);
                $em->persist($serie);


                $numeroStagioni = $details['number_of_seasons'] ?? 1;
                for ($s = 1; $s <= $numeroStagioni; $s++) {
                    $stagioneDetails = FTMDb::fetchSeriesEpisodes($tmdbId, $s);
                    if (isset($stagioneDetails['episodes'])) {
                        foreach ($stagioneDetails['episodes'] as $epData) {
                            $episodio = new EEpisodio(
                                $epData['id'],
                                0,
                                $serie,
                                $s,
                                $epData['episode_number'],
                                $epData['name'] ?? 'Senza Titolo',
                                $epData['overview'] ?? '',
                                $epData['runtime'] ?? 45,
                                $epData['vote_average'] ?? 0.0
                            );
                            $episodio->setValutazioneIniziale($epData['vote_average'] ?? 0.0);
                            $em->persist($episodio);
                            $serie->addEpisodio($episodio);
                        }
                    }
                }


                if (isset($details['credits']['cast'])) {
                    $cast = array_slice($details['credits']['cast'], 0, 5);
                    foreach ($cast as $attoreData) {
                        $attoreId = $attoreData['id'];
                        $attoreDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $attoreId]);

                        if (!$attoreDB) {
                            $partiNome = explode(" ", $attoreData['name'], 2);
                            $nome = $partiNome[0];
                            $cognome = $partiNome[1] ?? '';
                            $attoreDB = new EPersona($attoreId, 0, $nome, $cognome, $attoreData['profile_path'] ?? '');
                            $em->persist($attoreDB);
                        }

                        $partecipazione = new EPartecipazione(0, $attoreDB, $serie, 'Attore', $attoreData['character'] ?? '');
                        $em->persist($partecipazione);
                    }
                }


                if (isset($details['created_by'])) {
                    foreach ($details['created_by'] as $creator) {
                        $creatoreId = $creator['id'];
                        $creatoreDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $creatoreId]);

                        if (!$creatoreDB) {
                            $partiNome = explode(" ", $creator['name'], 2);
                            $nome = $partiNome[0];
                            $cognome = $partiNome[1] ?? '';
                            $creatoreDB = new EPersona($creatoreId, 0, $nome, $cognome, $creator['profile_path'] ?? '');
                            $em->persist($creatoreDB);
                        }

                        $partecipazione = new EPartecipazione(0, $creatoreDB, $serie, 'Regista', '');
                        $em->persist($partecipazione);
                        break;
                    }
                }

                $em->flush();
                Session::set('import_success', "La serie TV '" . $serie->getTitolo() . "' è stata importata con successo!");
            }

            header("Location: index.php?controller=Admin&action=inserisciDaTMDB");
            exit();
        }
    }


    public function banUtente()
    {
        $this->verificaAdmin();
        $durata = Session::getGet('durata');
        $idUtente = Session::getGet('idUtente');
        $dataFine = new DateTime('+' . $durata . ' days');
        $motivo = Session::getPost('motivo');
        $idAmministratore = Session::get('user_id');
        FBan::ban($idUtente, $dataFine, $motivo, $idAmministratore);
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }

    public function unbanUtente()
    {
        $this->verificaAdmin();
        $idUtente = Session::getGet('idUtente');
        FBan::unban($idUtente);
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }

    public function listaBannati()
    {
        $this->verificaAdmin();
        $bannati = FBan::findByBannati();

        $this->view->mostraBannati($bannati);
    }

    public function promuoviAdAdmin()
    {
        $this->verificaAdmin();
        $idUtente = Session::getGet('idUtente') ?? Session::getGet('id');
        if ($idUtente) {
            $utente = FUtente::findById($idUtente);
            if ($utente) {

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
        $this->verificaAdmin();
        $idUtente = Session::getGet('idUtente') ?? Session::getGet('id');
        if ($idUtente) {
            FUtente::retrocediAdUtente($idUtente);
        }
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }

    public function eliminaUtente()
    {
        $this->verificaAdmin();
        $idUtente = Session::getGet('idUtente') ?? Session::getGet('id');
        if ($idUtente) {
            $utente = FUtente::findById($idUtente);
            if ($utente) {
                FUtente::delete($utente);
            }
        }
        header("Location: index.php?controller=Admin&action=listaUtenti");
        exit();
    }

    public function eliminaContenuto()
    {
        $this->verificaAdmin();
        $idContenuto = Session::getGet('idContenuto') ?? Session::getGet('id');
        if ($idContenuto) {
            $contenuto = FContenuto::findById($idContenuto);
            if ($contenuto) {
                FContenuto::delete($contenuto);
            }
        }
        header("Location: index.php?controller=Admin&action=listaContenuti");
        exit();
    }
}
