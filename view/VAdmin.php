<?php

/**
 * Classe VAdmin
 * 
 * Gestisce la presentazione e il rendering delle pagine del pannello di controllo dell'amministratore.
 * Associa le variabili necessarie e compila i template Smarty per la gestione utenti,
 * la lista dei contenuti, le recensioni e la moderazione dei ban.
 * 
 * @package View
 * @author Marco Viscovo
 */
class VAdmin extends VView
{
    /**
     * Mostra la pagina di dashboard del pannello di controllo dell'amministratore
     * 
     * @param array $stats Array di statistiche
     * @param array $contenutiRecenti Array di contenuti recenti
     * @return void
     */
    public function mostraDashboard($stats, $contenutiRecenti)
    {
        $this->assign('stats', $stats);
        $this->assign('contenutiRecenti', $contenutiRecenti);
        $this->display('admin/dashboard.tpl');
    }

    /**
     * Mostra la pagina di gestione utenti del pannello di controllo dell'amministratore
     * 
     * @param array $utenti Array di utenti
     * @return void
     */
    public function mostraUtenti($utenti)
    {
        $this->assign('utenti', $utenti);
        $this->display('admin/gestioneUtenti.tpl');
    }

    /**
     * Mostra la pagina di gestione contenuti del pannello di controllo dell'amministratore
     * 
     * @param array $contenuti Array di contenuti
     * @return void
     */
    public function mostraContenuti($contenuti)
    {
        $this->assign('contenuti', $contenuti);
        $this->display('admin/gestioneContenuti.tpl');
    }

    /**
     * Mostra la pagina di gestione recensioni del pannello di controllo dell'amministratore
     * 
     * @param array $recensioni Array di recensioni
     * @return void
     */
    public function mostraRecensioni($recensioni)
    {
        $this->assign('recensioni', $recensioni);
        $this->display('admin/gestioneRecensioni.tpl');
    }

    /**
     * Mostra la pagina di aggiunta contenuto del pannello di controllo dell'amministratore
     * 
     * @return void
     */
    public function mostraAggiungiContenuto()
    {
        $this->display('admin/aggiungiContenuto.tpl');
    }

    /**
     * Mostra la pagina di gestione utenti bannati del pannello di controllo dell'amministratore
     * 
     * @param array $bannati Array di utenti bannati
     * @return void
     */
    public function mostraBannati($bannati)
    {
        $this->assign('bannati', $bannati);
        $this->display('admin/gestioneUtentiBannati.tpl');
    }

    /**
     * Mostra la pagina di importazione da TMDB del pannello di controllo dell'amministratore
     * 
     * @param array $ultimiFilm Array di film recenti
     * @param array $ultimeSerie Array di serie TV recenti
     * @return void
     */
    public function mostraInserisciDaTMDB($ultimiFilm = [], $ultimeSerie = [])
    {
        $this->assign('ultimiFilm', $ultimiFilm);
        $this->assign('ultimeSerie', $ultimeSerie);
        $this->display('admin/importaTMDB.tpl');
    }

    /**
     * Mostra la pagina di gestione film del pannello di controllo dell'amministratore
     * 
     * @param array $film Array di film
     * @return void
     */
    public function mostraFilm($film)
    {
        $this->assign('film', $film);
        $this->display('admin/gestioneFilm.tpl');
    }

    /**
     * Mostra la pagina di gestione serie TV del pannello di controllo dell'amministratore
     * 
     * @param array $serie Array di serie TV
     * @return void
     */
    public function mostraSerie($serie)
    {
        $this->assign('serie', $serie);
        $this->display('admin/gestioneSerie.tpl');
    }

    /**
     * Mostra la pagina di accesso negato del pannello di controllo dell'amministratore
     * 
     * @return void
     */
    public function mostraAccessoNegato()
    {
        header("HTTP/1.0 403 Forbidden");
        $this->display('admin/accessoNegato.tpl');
        exit();
    }
}
