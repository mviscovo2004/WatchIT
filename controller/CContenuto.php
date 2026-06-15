<?php

class CContenuto
{
    private VContenuto $view;

    public function __construct()
    {
        $this->view = new VContenuto();
    }

    private function getWatchlistIdsUtente()
    {
        $watchlistIds = [];
        $userId = Session::get('user_id');
        if ($userId) {
            $watchlists = FWatchlist::findByUtente($userId);
            foreach ($watchlists as $watchlist) {
                $contenutiSalvati = $watchlist->getContenutiSalvati();
                foreach ($contenutiSalvati as $c) {
                    $watchlistIds[] = $c->getId();
                }
            }
            $watchlistIds = array_unique($watchlistIds);
        }
        return $watchlistIds;
    }


    public function homepage()
    {
        $filmPopolari = FContenuto::getFilmPopolari(5);
        $seriePopolari = FContenuto::getSeriePopolari(5);

        $watchlistIds = $this->getWatchlistIdsUtente();

        $recensioni = FRecensione::getUltimeRecensioni(6);

        $this->view->mostraHome($filmPopolari, $seriePopolari, $watchlistIds, $recensioni);
    }

    public function mostra()
    {
        $id = Session::getGet('id') ?? null;
        if ($id) {
            $contenuto = FContenuto::findById($id);
            if ($contenuto) {
                if ($contenuto instanceof EFilm) {
                    $this->mostraFilm();
                } else if ($contenuto instanceof ESerie) {
                    $this->mostraSerie();
                }
                return;
            }
        }
        $this->homepage();
    }

    public function mostraSerie()
    {
        $id = Session::getGet('id') ?? null;

        $serie = FContenuto::findById($id);

        $watchlistIds = $this->getWatchlistIdsUtente();

        $recensioni = FRecensione::findByContenuto($serie->getId());
        $this->view->mostraSerie($serie, $watchlistIds, $recensioni);
    }

    public function mostraFilm()
    {
        $id = Session::getGet('id') ?? null;

        $film = FContenuto::findById($id);

        $watchlistIds = $this->getWatchlistIdsUtente();


        $recensioni = FRecensione::findByContenuto($film->getId());
        $this->view->mostraFilm($film, $watchlistIds, $recensioni);
    }

    public function mostraEpisodio()
    {
        $id = Session::getGet('id') ?? null;
        $serieId = Session::getGet('serie') ?? null;

        $episodio = FEpisodio::findById($id);
        $serie = FContenuto::findById($serieId);


        $recensioni = FRecensione::findByEpisodio($id);

        $this->view->mostraEpisodio($episodio, $serie, $recensioni);
    }


    public function cerca()
    {
        $query = Session::getGet('query');
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

        $this->view->mostraRicerca($film, $serie, $utenti);
    }
}
