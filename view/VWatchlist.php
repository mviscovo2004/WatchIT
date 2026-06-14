<?php

class VWatchlist extends VView
{
    public function mostraTutteWatchlist($watchlist)
    {
        $this->assign('watchlist', $watchlist);
        $this->display('mieWatchlist.tpl');
    }

    public function mostraWatchlist($watchlist, $contenuti)
    {
        $this->assign('watchlist', $watchlist);
        $this->assign('contenuti', $contenuti);
        $this->display('watchlist.tpl');
    }
}
