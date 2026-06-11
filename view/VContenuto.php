<?php

class VContenuto extends VView
{
    public function mostraHome($filmPopolari = [], $seriePopolari = [], $watchlistIds = [])
    {
        $this->assign("filmPopolari", $filmPopolari);
        $this->assign("seriePopolari", $seriePopolari);
        $this->assign("watchlistIds", $watchlistIds);
        $this->display("homepage.tpl");
    }

    public function mostraDettagli($contenuto, $error = null, $recensioni = [])
    {
        $this->assign("contenuto", $contenuto);
        $this->assign("error", $error);
        $this->assign("recensioni", $recensioni);
        $this->display("dettagli.tpl");
    }

    public function mostraUltimeRecensioni($ultimeRecensioni)
    {
        $this->assign("ultimeRecensioni", $ultimeRecensioni);
        $this->display("homepage.tpl");
    }

    public function mostraSerie($serie, $watchlistIds = [], $recensioni = [])
    {
        $this->assign("serie", $serie);
        $this->assign("watchlistIds", $watchlistIds);
        $this->assign("recensioni", $recensioni);
        $this->display("serie.tpl");
    }

    public function mostraFilm($film, $watchlistIds = [], $recensioni = [])
    {
        $this->assign("film", $film);
        $this->assign("watchlistIds", $watchlistIds);
        $this->assign("recensioni", $recensioni);
        $this->display("film.tpl");
    }

    public function mostraEpisodio($episodio, $serie, $recensioni = [])
    {
        $this->assign("episodio", $episodio);
        $this->assign("serie", $serie);
        $this->assign("recensioni", $recensioni);
        $this->display("episodio.tpl");
    }

    public function mostraRicerca($film, $serie, $utenti)
    {
        $this->assign("film", $film);
        $this->assign("serie", $serie);
        $this->assign("utenti", $utenti);
        $this->display("ricerca.tpl");
    }
}
