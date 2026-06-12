<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bin/config.php';
require_once __DIR__ . '/../foundation/FTMDb.php';

echo "Avvio Seeder TMDb...\n";

$em = FEntityManager::getInstance();
// Creazione di utenti fittizi per le recensioni con password sicure generate casualmente
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
                $ftmdbDetails['videos']['results'] ?? [],
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

            // Creazione di recensioni fittizie per il film
            $recensioniEsempio = [
                ['voto' => 8, 'titolo' => 'Molto bello', 'descrizione' => 'Mi è piaciuto moltissimo, lo consiglio a tutti! Ambientazione superba e cast eccezionale.'],
                ['voto' => 9, 'titolo' => 'Capolavoro assoluto', 'descrizione' => 'Uno dei migliori film dell\'anno. Regia e fotografia magistrali.'],
                ['voto' => 5, 'titolo' => 'Deludente', 'descrizione' => 'Sinceramente mi aspettavo di meglio. Trama piatta e ritmo troppo lento.'],
                ['voto' => 7, 'titolo' => 'Interessante', 'descrizione' => 'Un buon intrattenimento. Non un capolavoro ma scorre bene ed è divertente.'],
                ['voto' => 10, 'titolo' => 'Perfetto', 'descrizione' => 'Assolutamente consigliato, merita 10 stelle! Storia originale e interpretazioni da oscar.'],
            ];

            $numRecensioni = rand(1, 2); // Genera casualmente 1 o 2 recensioni
            for ($r = 0; $r < $numRecensioni; $r++) {
                $recData = $recensioniEsempio[array_rand($recensioniEsempio)];
                $utenteRecensione = $utentiRecensioni[array_rand($utentiRecensioni)];

                $recensione = new ERecensione(
                    0,
                    $recData['titolo'],
                    $recData['voto'],
                    $recData['descrizione'],
                    $film,
                    null, // Nessun episodio
                    $utenteRecensione,
                    new DateTime('-' . rand(1, 30) . ' days') // Data di pubblicazione casuale negli ultimi 30 giorni
                );
                $em->persist($recensione);
            }
            $em->flush();
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
                $ftmdbDetails['videos']['results'] ?? [],
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

            // Creazione di recensioni fittizie per la serie
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
                    null, // Nessun episodio
                    $utenteRecensione,
                    new DateTime('-' . rand(1, 30) . ' days')
                );
                $em->persist($recensione);
            }
            $em->flush();
        }
    }
}
