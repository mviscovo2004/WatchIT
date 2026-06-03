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

    public function mostraSerie($serie, $watchlistIds = [])
    {
        $this->assign("serie", $serie);
        $this->assign("watchlistIds", $watchlistIds);
        $this->display("serie.tpl");
    }

    public function mostraFilm($film, $watchlistIds = [])
    {
        $this->assign("film", $film);
        $this->assign("watchlistIds", $watchlistIds);
        $this->display("film.tpl");
    }
}
