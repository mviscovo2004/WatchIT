<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bin/config.php';
require_once __DIR__ . '/../foundation/FTMDb.php';

/**
 * Script CLI per il popolamento (seeding) iniziale del database.
 * 
 * Genera account utente di test con password criptate,
 * interroga le API di TMDB per importare automaticamente un catalogo iniziale
 * di film e serie TV (completo di stagioni, episodi, cast e clip video),
 * e simula il rilascio di recensioni realistiche da parte degli utenti.
 * 
 * @package Bin
 * @author Marco Viscovo
 */
echo "Avvio Seeder TMDb...\n";

$em = FEntityManager::getInstance();

/**
 * Creazione di utenti fittizi per le recensioni
 */
echo "Creazione utenti fittizi per le recensioni...\n";
$utentiRecensioni = [];

$esisteLuca = $em->getRepository(EUtente::class)->findOneBy(['username' => 'lucabianchi']);
if (!$esisteLuca) {
    $luca = new EUtente(0, 'Luca', 'Bianchi', 'default.png', 'lucabianchi', 'luca@bianchi.it', password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT));
    $em->persist($luca);
    $utentiRecensioni[] = $luca;
} else {
    $utentiRecensioni[] = $esisteLuca;
}

$esisteGiulia = $em->getRepository(EUtente::class)->findOneBy(['username' => 'giuliaverdi']);
if (!$esisteGiulia) {
    $giulia = new EUtente(0, 'Giulia', 'Verdi', 'default.png', 'giuliaverdi', 'giulia@verdi.it', password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT));
    $em->persist($giulia);
    $utentiRecensioni[] = $giulia;
} else {
    $utentiRecensioni[] = $esisteGiulia;
}
$em->flush();

/**
 * Download dei film popolari
 */
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
                [],
                $ftmdbDetails['poster_path'] ?? '',
                $ftmdbDetails['genres'] ?? [],
                $ftmdbDetails['videos']['results'] ?? [],
                $ftmdbDetails['runtime'] ?? 0
            );
            $em->persist($film);

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

                    $partecipazione = new EPartecipazione(0, $attoreDB, $film, 'Attore', $attoreData['character'] ?? '');
                    $em->persist($partecipazione);;
                }
            }

            if (isset($ftmdbDetails['credits']['crew'])) {
                foreach ($ftmdbDetails['credits']['crew'] as $crewMember) {
                    if ($crewMember['job'] === 'Director') {
                        $registaId = $crewMember['id'];

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
                            $personeInMemoria[$registaId] = $registaDB;
                        }

                        $partecipazione = new EPartecipazione(0, $registaDB, $film, 'Regista', '');
                        $em->persist($partecipazione);

                        break;
                    }
                }
            }

            $em->flush();
            echo "Salvato Film: " . $film->getTitolo() . "\n";


            $recensioniEsempio = [
                ['voto' => 8, 'titolo' => 'Molto bello', 'descrizione' => 'Mi è piaciuto moltissimo, lo consiglio a tutti! Ambientazione superba e cast eccezionale.'],
                ['voto' => 9, 'titolo' => 'Capolavoro assoluto', 'descrizione' => 'Uno dei migliori film dell\'anno. Regia e fotografia magistrali.'],
                ['voto' => 5, 'titolo' => 'Deludente', 'descrizione' => 'Sinceramente mi aspettavo di meglio. Trama piatta e ritmo troppo lento.'],
                ['voto' => 7, 'titolo' => 'Interessante', 'descrizione' => 'Un buon intrattenimento. Non un capolavoro ma scorre bene ed è divertente.'],
                ['voto' => 10, 'titolo' => 'Perfetto', 'descrizione' => 'Assolutamente consigliato, merita 10 stelle! Storia originale e interpretazioni da oscar.'],
            ];

            $numRecensioni = rand(1, 2);
            for ($r = 0; $r < $numRecensioni; $r++) {
                $recData = $recensioniEsempio[array_rand($recensioniEsempio)];
                $utenteRecensione = $utentiRecensioni[array_rand($utentiRecensioni)];

                $recensione = new ERecensione(
                    0,
                    $recData['titolo'],
                    $recData['voto'],
                    $recData['descrizione'],
                    $film,
                    null,
                    $utenteRecensione,
                    new DateTime('-' . rand(1, 30) . ' days')
                );
                $em->persist($recensione);
            }
            $em->flush();
        }
    }
}

/**
 * Download delle serie TV popolari
 */
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


            $title = $ftmdbDetails['name'] ?? '';
            if (!preg_match('/^[\p{Latin}\p{Nd}\p{P}\s]+$/u', $title)) {
                echo "Serie $title saltata\n";
                continue;
            }


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
                [],
                $ftmdbDetails['poster_path'] ?? '',
                $ftmdbDetails['genres'] ?? [],
                $ftmdbDetails['videos']['results'] ?? [],
                $ftmdbDetails['number_of_seasons'] ?? 1,
                [],
                $statoObj
            );
            $em->persist($serie);


            $numeroStagioni = $ftmdbDetails['number_of_seasons'] ?? 1;
            for ($s = 1; $s <= $numeroStagioni; $s++) {
                $stagioneDetails = FTMDb::fetchSeriesEpisodes($ftmdbId, $s);
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
                        $em->persist($episodio);
                        $serie->addEpisodio($episodio);
                    }
                }
            }


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

                    $partecipazione = new EPartecipazione(0, $attoreDB, $serie, 'Attore', $attoreData['character'] ?? '');
                    $em->persist($partecipazione);
                }
            }


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

                    $partecipazione = new EPartecipazione(0, $creatoreDB, $serie, 'Regista', '');
                    $em->persist($partecipazione);

                    break;
                }
            }

            $em->flush();
            echo "Salvata Serie TV: " . $serie->getTitolo() . "\n";


            $recensioniEsempioSerie = [
                ['voto' => 8, 'titolo' => 'Serie TV fantastica', 'descrizione' => 'Ti tiene incollato allo schermo fin dal primo episodio! Ottimo cast.'],
                ['voto' => 9, 'titolo' => 'Coinvolgente e misteriosa', 'descrizione' => 'Una trama complessa e ricca di colpi di scena. Consigliatissima!'],
                ['voto' => 6, 'titolo' => 'Non male', 'descrizione' => 'Inizia bene ma si perde un po\' sul finale. Comunque si fa guardare.'],
                ['voto' => 10, 'titolo' => 'Capolavoro seriale', 'descrizione' => 'Una delle migliori serie TV che abbia mai visto. Personaggi scritti divinamente.'],
            ];

            $numRecensioni = rand(1, 2);
            for ($r = 0; $r < $numRecensioni; $r++) {
                $recData = $recensioniEsempioSerie[array_rand($recensioniEsempioSerie)];
                $utenteRecensione = $utentiRecensioni[array_rand($utentiRecensioni)];

                $recensione = new ERecensione(
                    0,
                    $recData['titolo'],
                    $recData['voto'],
                    $recData['descrizione'],
                    $serie,
                    null,
                    $utenteRecensione,
                    new DateTime('-' . rand(1, 30) . ' days')
                );
                $em->persist($recensione);
            }
            $em->flush();
        }
    }
}
