<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bin/config.php';
require_once __DIR__ . '/../foundation/FTMDb.php';

echo "Avvio Seeder TMDb...\n";

$em = FEntityManager::getInstance();

echo "Inizio download film...\n";

for ($i = 1; $i <= 3; $i++) {
    $movies = FTMDb::getPopularMovies($i);
    foreach ($movies as $movie) {
        $ftmdbId = $movie['id'];
        $esiste = $em->getRepository(EFilm::class)->findOneBy(['tmdbId' => $ftmdbId]);

        if ($esiste) {
            echo "Film $ftmdbId già presente\n";
            continue;
        } else {
            $ftmdbDetails = FTMDb::fetchFilm($ftmdbId);
            $title = $ftmdbDetails['title'] ?? '';
            if (!preg_match('/^[\p{Latin}\p{Nd}\p{P}\s]+$/u', $title)) {
                echo "Film $title saltato\n";
                continue;
            }
            $film = new EFilm(
                $ftmdbDetails['id'],
                0,
                $ftmdbDetails['title'] ?? 'N/A',
                $ftmdbDetails['release_date'] ?? '',
                $ftmdbDetails['overview'] ?? '',
                $ftmdbDetails['vote_average'] ?? 0.0,
                [], // Array vuoto per Doctrine
                $ftmdbDetails['poster_path'] ?? '',
                $ftmdbDetails['genres'] ?? [],
                $ftmdbDetails['runtime'] ?? 0
            );
            $em->persist($film);
            // Salviamo i primi 5 attori
            if (isset($ftmdbDetails['credits']['cast'])) {
                $cast = array_slice($ftmdbDetails['credits']['cast'], 0, 5);
                foreach ($cast as $attoreData) {
                    $attoreId = $attoreData['id'];

                    // Cerca prima nella cache locale, poi nel database
                    if (isset($personeInMemoria[$attoreId])) {
                        $attoreDB = $personeInMemoria[$attoreId];
                    } else {
                        $attoreDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $attoreId]);
                        if ($attoreDB) {
                            $personeInMemoria[$attoreId] = $attoreDB;
                        }
                    }

                    if (!$attoreDB) {
                        $partiNome = explode(" ", $attoreData['name'], 2);
                        $nome = $partiNome[0];
                        $cognome = $partiNome[1] ?? '';
                        $attoreDB = new EPersona($attoreId, 0, $nome, $cognome, $attoreData['profile_path'] ?? '');
                        $em->persist($attoreDB);
                        $personeInMemoria[$attoreId] = $attoreDB; // Salva in cache
                    }

                    $partecipazione = new EPartecipazione(0, $attoreDB, $film, 'Attore');
                    $em->persist($partecipazione);
                }
            }

            // Salviamo il Regista (Director)
            if (isset($ftmdbDetails['credits']['crew'])) {
                foreach ($ftmdbDetails['credits']['crew'] as $crewMember) {
                    if ($crewMember['job'] === 'Director') {
                        $registaId = $crewMember['id'];

                        // Cerca prima nella cache locale, poi nel database
                        if (isset($personeInMemoria[$registaId])) {
                            $registaDB = $personeInMemoria[$registaId];
                        } else {
                            $registaDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $registaId]);
                            if ($registaDB) {
                                $personeInMemoria[$registaId] = $registaDB;
                            }
                        }

                        if (!$registaDB) {
                            $partiNome = explode(" ", $crewMember['name'], 2);
                            $nome = $partiNome[0];
                            $cognome = $partiNome[1] ?? '';
                            $registaDB = new EPersona($registaId, 0, $nome, $cognome, $crewMember['profile_path'] ?? '');
                            $em->persist($registaDB);
                            $personeInMemoria[$registaId] = $registaDB; // Salva in cache
                        }

                        $partecipazione = new EPartecipazione(0, $registaDB, $film, 'Regista');
                        $em->persist($partecipazione);
                        break; // Salviamo solo il primo regista principale
                    }
                }
            }

            $em->flush();
            echo "Salvato Film: " . $film->getTitolo() . "\n";
        }
    }
}

echo "Inizio download serie TV...\n";

for ($i = 1; $i <= 3; $i++) {
    $series = FTMDb::getPopularSeries($i);
    foreach ($series as $serieData) {
        $ftmdbId = $serieData['id'];
        $esiste = $em->getRepository(ESerie::class)->findOneBy(['tmdbId' => $ftmdbId]);
        if ($esiste) {
            echo "Serie TV $ftmdbId già presente\n";
            continue;
        } else {
            $ftmdbDetails = FTMDb::fetchSerie($ftmdbId);

            // CORREZIONE FILTRO TITOLO (name invece di title)
            $title = $ftmdbDetails['name'] ?? '';
            if (!preg_match('/^[\p{Latin}\p{Nd}\p{P}\s]+$/u', $title)) {
                echo "Serie $title saltata\n";
                continue;
            }

            // Conversione stringa -> Enum
            $statoAPI = $ftmdbDetails['status'] ?? '';
            $statoObj = match ($statoAPI) {
                'Ended' => Stato::conclusa,
                'Canceled' => Stato::cancellata,
                default => Stato::in_corso,
            };

            $serie = new ESerie(
                $ftmdbDetails['id'],
                0,
                $ftmdbDetails['name'] ?? 'N/A',
                $ftmdbDetails['first_air_date'] ?? '',
                $ftmdbDetails['overview'] ?? '',
                $ftmdbDetails['vote_average'] ?? 0.0,
                [], // Array vuoto per Doctrine
                $ftmdbDetails['poster_path'] ?? '',
                $ftmdbDetails['genres'] ?? [],
                $ftmdbDetails['number_of_seasons'] ?? 1,
                [], // Episodi vuoti
                $statoObj
            );
            $em->persist($serie);

            // Scarichiamo e salviamo tutti gli episodi per ciascuna stagione della serie
            $numeroStagioni = $ftmdbDetails['number_of_seasons'] ?? 1;
            for ($s = 1; $s <= $numeroStagioni; $s++) {
                $stagioneDetails = FTMDb::fetchSeriesEpisodes($ftmdbId, $s);
                if (isset($stagioneDetails['episodes'])) {
                    foreach ($stagioneDetails['episodes'] as $epData) {
                        $episodio = new EEpisodio(
                            $epData['id'],                // tmdbId
                            0,                            // id auto-generato
                            $serie,                       // Oggetto Serie associato
                            $s,                           // Numero Stagione
                            $epData['episode_number'],    // Numero Episodio
                            $epData['name'] ?? 'Senza Titolo',
                            $epData['overview'] ?? '',    // Trama
                            $epData['runtime'] ?? 45,     // Durata (in minuti)
                            $epData['vote_average'] ?? 0.0
                        );
                        $em->persist($episodio);
                        $serie->addEpisodio($episodio); // Collega l'episodio alla serie
                    }
                }
            }

            // Salviamo i primi 5 attori (con controllo duplicati)
            if (isset($ftmdbDetails['credits']['cast'])) {
                $cast = array_slice($ftmdbDetails['credits']['cast'], 0, 5);
                foreach ($cast as $attoreData) {
                    $attoreId = $attoreData['id'];

                    if (isset($personeInMemoria[$attoreId])) {
                        $attoreDB = $personeInMemoria[$attoreId];
                    } else {
                        $attoreDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $attoreId]);
                        if ($attoreDB) {
                            $personeInMemoria[$attoreId] = $attoreDB;
                        }
                    }

                    if (!$attoreDB) {
                        $partiNome = explode(" ", $attoreData['name'], 2);
                        $nome = $partiNome[0];
                        $cognome = $partiNome[1] ?? '';
                        $attoreDB = new EPersona($attoreId, 0, $nome, $cognome, $attoreData['profile_path'] ?? '');
                        $em->persist($attoreDB);
                        $personeInMemoria[$attoreId] = $attoreDB;
                    }

                    $partecipazione = new EPartecipazione(0, $attoreDB, $serie, 'Attore');
                    $em->persist($partecipazione);
                }
            }

            // Salviamo il Creatore/Autore (come Regista, con controllo duplicati)
            if (isset($ftmdbDetails['created_by'])) {
                foreach ($ftmdbDetails['created_by'] as $creator) {
                    $creatoreId = $creator['id'];

                    if (isset($personeInMemoria[$creatoreId])) {
                        $creatoreDB = $personeInMemoria[$creatoreId];
                    } else {
                        $creatoreDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $creatoreId]);
                        if ($creatoreDB) {
                            $personeInMemoria[$creatoreId] = $creatoreDB;
                        }
                    }

                    if (!$creatoreDB) {
                        $partiNome = explode(" ", $creator['name'], 2);
                        $nome = $partiNome[0];
                        $cognome = $partiNome[1] ?? '';
                        $creatoreDB = new EPersona($creatoreId, 0, $nome, $cognome, $creator['profile_path'] ?? '');
                        $em->persist($creatoreDB);
                        $personeInMemoria[$creatoreId] = $creatoreDB;
                    }

                    $partecipazione = new EPartecipazione(0, $creatoreDB, $serie, 'Regista');
                    $em->persist($partecipazione);
                    break; // Salviamo solo il primo creatore
                }
            }

            $em->flush();
            echo "Salvata Serie TV: " . $serie->getTitolo() . "\n";
        }
    }
}
