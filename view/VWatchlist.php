<?php

class VWatchlist extends VView
{

    public function mostraTutteWatchlist($watchlist)
    {
        $this->assign('watchlist', $watchlist);
        $this->display('../view/templates/liste.tpl');
    }

    public function mostraWatchlist($watchlist, $contenuti)
    {
        $this->assign('watchlist', $watchlist);
        $this->assign('contenuti', $contenuti);
        $this->display('../view/templates/watchlist.tpl');
    }

    public function mostraErrore($errore)
    {
        $this->assign('errore', $errore);
        $this->display('../view/templates/errore.tpl');
    }
}
