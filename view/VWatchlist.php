<?php

class VWatchlist extends VView
{
    public function mostraTutteWatchlist($watchlist)
    {
        $this->assign('watchlist', $watchlist);
        $this->display('mieWatchlist.tpl'); // Allineato: rimosso '../view/templates/'
    }

    public function mostraWatchlist($watchlist, $contenuti)
    {
        $this->assign('watchlist', $watchlist);
        $this->assign('contenuti', $contenuti);
        $this->display('watchlist.tpl'); // Allineato: rimosso '../view/templates/'
    }

    public function mostraErrore($errore)
    {
        $this->assign('errore', $errore);
        $this->display('errore.tpl'); // Allineato: rimosso '../view/templates/'
    }
}
