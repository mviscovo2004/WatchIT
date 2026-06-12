<?php

class CContenuto
{
    public function homepage()
    {
        $filmPopolari = FContenuto::getFilmPopolari(5);
        $seriePopolari = FContenuto::getSeriePopolari(5);

        // Determina gli ID dei contenuti già salvati in watchlist
        $watchlistIds = [];
        $userId = Session::get('user_id');
        if ($userId) {
            $watchlists = FWatchlist::findByUtente($userId);
            if (!empty($watchlists)) {
                $contenutiSalvati = $watchlists[0]->getContenutiSalvati();
                foreach ($contenutiSalvati as $c) {
                    $watchlistIds[] = $c->getId();
                }
            }
        }
        $recensioni = FRecensione::getUltimeRecensioni(6);

        $view = new VContenuto();

        $view->mostraHome($filmPopolari, $seriePopolari, $watchlistIds, $recensioni);
    }

    public function mostraSerie()
    {
        $id = $_GET['id'] ?? null;

        $serie = FContenuto::findById($id);
        $view = new VContenuto();

        // Determina gli ID dei contenuti già salvati in watchlist
        $watchlistIds = [];
        $userId = Session::get('user_id');
        if ($userId) {
            $watchlists = FWatchlist::findByUtente($userId);
            if (!empty($watchlists)) {
                $contenutiSalvati = $watchlists[0]->getContenutiSalvati();
                foreach ($contenutiSalvati as $c) {
                    $watchlistIds[] = $c->getId();
                }
            }
        }
        $recensioni = FRecensione::findByContenuto($serie->getId());
        $view->mostraSerie($serie, $watchlistIds, $recensioni);
    }

    public function mostraFilm()
    {
        $id = $_GET['id'] ?? null;

        $film = FContenuto::findById($id);
        $view = new VContenuto();

        // Determina gli ID dei contenuti già salvati in watchlist
        $watchlistIds = [];
        $userId = Session::get('user_id');
        if ($userId) {
            $watchlists = FWatchlist::findByUtente($userId);
            if (!empty($watchlists)) {
                $contenutiSalvati = $watchlists[0]->getContenutiSalvati();
                foreach ($contenutiSalvati as $c) {
                    $watchlistIds[] = $c->getId();
                }
            }
        }
        $recensioni = FRecensione::findByContenuto($film->getId());
        $view->mostraFilm($film, $watchlistIds, $recensioni);
    }

    public function mostraEpisodio()
    {
        $id = $_GET['id'] ?? null;
        $serieId = $_GET['serie'] ?? null;

        $episodio = FEpisodio::findById($id);
        $serie = FContenuto::findById($serieId);
        $view = new VContenuto();

        // Carichiamo le recensioni specifiche per questo episodio
        $recensioni = FRecensione::findByEpisodio($id);

        $view->mostraEpisodio($episodio, $serie, $recensioni);
    }


    public function cerca()
    {
        $query = $_GET['query'] ?? null;
        $contenuti = FContenuto::search($query);
        $utenti = FUtente::search($query);

        $film = [];
        $serie = [];
        foreach ($contenuti as $c) {
            if ($c instanceof EFilm) {
                $film[] = $c;
            } else if ($c instanceof ESerie) {
                $serie[] = $c;
            }
        }

        $view = new VContenuto();
        $view->mostraRicerca($film, $serie, $utenti);
    }
}
