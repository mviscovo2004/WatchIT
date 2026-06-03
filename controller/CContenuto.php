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

        $view = new VContenuto();

        $view->mostraHome($filmPopolari, $seriePopolari, $watchlistIds);
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
        $view->mostraSerie($serie, $watchlistIds);
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

        $view->mostraFilm($film, $watchlistIds);
    }
}
