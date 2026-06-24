<?php

/**
 * Classe VWatchlist
 * 
 * Gestisce la presentazione delle watchlist degli utenti.
 * Rendering della pagina con l'elenco di tutte le watchlist di un utente
 * e della singola watchlist di dettaglio con i relativi contenuti salvati.
 * 
 * @package View
 * @author Marco Viscovo
 */
class VWatchlist extends VView
{
    /**
     * Mostra la pagina con l'elenco di tutte le watchlist di un utente
     * 
     * @param array $watchlist Array di watchlist
     * @return void
     */
    public function mostraTutteWatchlist($watchlist)
    {
        $this->assign('watchlist', $watchlist);
        $this->display('mieWatchlist.tpl');
    }

    /**
     * Mostra la pagina di dettaglio di una watchlist con i relativi contenuti
     * 
     * @param EWatchlist $watchlist Watchlist da mostrare
     * @param array $contenuti Array di contenuti
     * @return void
     */
    public function mostraWatchlist($watchlist, $contenuti)
    {
        $this->assign('watchlist', $watchlist);
        $this->assign('contenuti', $contenuti);
        $this->display('watchlist.tpl');
    }
}
