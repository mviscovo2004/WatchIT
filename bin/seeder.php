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
                    $attoreDB = $em->getRepository(EPersona::class)->findOneBy(['tmdbId' => $attoreId]);
                    
                    if (!$attoreDB) {
                        $partiNome = explode(" ", $attoreData['name'], 2);
                        $nome = $partiNome[0];
                        $cognome = $partiNome[1] ?? '';
                        $attoreDB = new EPersona($attoreId, 0, $nome, $cognome, $attoreData['profile_path'] ?? '');
                        $em->persist($attoreDB);
                    }

                    $partecipazione = new EPartecipazione(0, $attoreDB, $film, 'Attore');
                    $em->persist($partecipazione);
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

            // Salviamo i primi 5 attori
            if (isset($ftmdbDetails['credits']['cast'])) {
                $cast = array_slice($ftmdbDetails['credits']['cast'], 0, 5);
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

                    $partecipazione = new EPartecipazione(0, $attoreDB, $serie, 'Attore');
                    $em->persist($partecipazione);
                }
            }
            $em->flush();
            echo "Salvata Serie TV: " . $serie->getTitolo() . "\n";
        }
    }
}
