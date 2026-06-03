<?php

class CWatchlist
{
    public function aggiungi()
    {
        $idContenuto = $_GET['id'];
        $idUtente = Session::get('user_id');
        $idWatchlist = $_GET['idWatchlist'] ?? null;
        $view = new VWatchlist();
        if ($idContenuto && $idUtente && $idWatchlist) {
            FWatchlist::addContenuto($idUtente, $idContenuto);
            $watchlist = FWatchlist::findById($idWatchlist);
            $contenuti = $watchlist->getContenutiSalvati();
            $view->mostraWatchlist($watchlist, $contenuti);
        } else {
            $view->mostraErrore('Errore nel salvataggio ' . $idWatchlist);
        }
    }

    public function rimuovi()
    {
        $idContenuto = $_GET['id'];
        $idUtente = Session::get('user_id');
        $idWatchlist = $_GET['idWatchlist'] ?? null;
        $view = new VWatchlist();
        if ($idContenuto && $idUtente && $idWatchlist) {
            FWatchlist::removeContenuto($idUtente, $idContenuto);
            $watchlist = FWatchlist::findById($idWatchlist);
            $contenuti = $watchlist->getContenutiSalvati();
            $view->mostraWatchlist($watchlist, $contenuti);
        } else {
            $view->mostraErrore('Errore nel salvataggio ' . $idWatchlist);
        }
    }

    public function mostraTutteWatchlist()
    {
        $idUtente = Session::get('user_id');
        $view = new VWatchlist();
        if ($idUtente) {
            $watchlists = FWatchlist::findByUtente($idUtente);
            $view->mostraTutteWatchlist($watchlists);
        } else {
            $view->mostraErrore('Errore nel salvataggio ');
        }
    }
}
