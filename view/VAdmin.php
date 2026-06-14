<?php

class VAdmin extends VView
{

    public function mostraDashboard($stats, $contenutiRecenti)
    {
        $this->assign('stats', $stats);
        $this->assign('contenutiRecenti', $contenutiRecenti);
        $this->display('admin/dashboard.tpl');
    }

    public function mostraUtenti($utenti)
    {
        $this->assign('utenti', $utenti);
        $this->display('admin/gestioneUtenti.tpl');
    }

    public function mostraContenuti($contenuti)
    {
        $this->assign('contenuti', $contenuti);
        $this->display('admin/gestioneContenuti.tpl');
    }

    public function mostraRecensioni($recensioni)
    {
        $this->assign('recensioni', $recensioni);
        $this->display('admin/gestioneRecensioni.tpl');
    }

    public function mostraAggiungiContenuto()
    {
        $this->display('admin/aggiungiContenuto.tpl');
    }

    public function mostraBannati($bannati)
    {
        $this->assign('bannati', $bannati);
        $this->display('admin/gestioneUtentiBannati.tpl');
    }

    public function mostraInserisciDaTMDB($ultimiFilm = [], $ultimeSerie = [])
    {
        $this->assign('ultimiFilm', $ultimiFilm);
        $this->assign('ultimeSerie', $ultimeSerie);
        $this->display('admin/importaTMDB.tpl');
    }


    public function mostraFilm($film)
    {
        $this->assign('film', $film);
        $this->display('admin/gestioneFilm.tpl');
    }

    public function mostraSerie($serie)
    {
        $this->assign('serie', $serie);
        $this->display('admin/gestioneSerie.tpl');
    }



    public function mostraAccessoNegato()
    {
        header("HTTP/1.0 403 Forbidden");
        $this->display('admin/accessoNegato.tpl');
        exit();
    }
}
