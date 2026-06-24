<?php

/**
 * Classe VContenuto
 * 
 * Gestisce la presentazione dei contenuti multimediali a catalogo.
 * Si occupa di caricare la homepage (con film e serie popolari), le schede di dettaglio
 * di film, serie TV, singoli episodi e la pagina dei risultati di ricerca.
 * 
 * @package View
 * @author Marco Viscovo
 */
class VContenuto extends VView
{
    /**
     * Mostra la homepage con i contenuti più popolari e le recensioni recenti.
     * 
     * @param array $filmPopolari Array di film popolari
     * @param array $seriePopolari Array di serie popolari
     * @param array $watchlistIds Array di ID watchlist dell'utente
     * @param array $recensioni Array di recensioni recenti
     * @return void
     */
    public function mostraHome($filmPopolari = [], $seriePopolari = [], $watchlistIds = [], $recensioni = [])
    {
        $this->assign("filmPopolari", $filmPopolari);
        $this->assign("seriePopolari", $seriePopolari);
        $this->assign("watchlistIds", $watchlistIds);
        $this->assign("recensioni", $recensioni);
        $this->display("homepage.tpl");
    }

    /**
     * Mostra la pagina di dettaglio di un contenuto, con informazioni complete e recensioni.
     * 
     * @param EContenuto $contenuto Contenuto da visualizzare
     * @param string|null $error Messaggio di errore (se presente)
     * @param array $recensioni Array di recensioni relative al contenuto
     * @return void
     */
    public function mostraDettagli($contenuto, $error = null, $recensioni = [])
    {
        $this->assign("contenuto", $contenuto);
        $this->assign("error", $error);
        $this->assign("recensioni", $recensioni);
        $this->display("dettagli.tpl");
    }

    /**
     * Mostra l'elenco delle serie TV disponibili, con indicazione di quelle presenti nella watchlist.
     * 
     * @param array $serie Array di serie TV
     * @param array $watchlistIds Array di ID watchlist dell'utente
     * @param array $recensioni Array di recensioni recenti
     * @return void
     */
    public function mostraSerie($serie, $watchlistIds = [], $recensioni = [])
    {
        $this->assign("serie", $serie);
        $this->assign("watchlistIds", $watchlistIds);
        $this->assign("recensioni", $recensioni);
        $this->display("serie.tpl");
    }

    /**
     * Mostra l'elenco dei film disponibili, con indicazione di quelli presenti nella watchlist.
     * 
     * @param array $film Array di film
     * @param array $watchlistIds Array di ID watchlist dell'utente
     * @param array $recensioni Array di recensioni recenti
     * @return void
     */
    public function mostraFilm($film, $watchlistIds = [], $recensioni = [])
    {
        $this->assign("film", $film);
        $this->assign("watchlistIds", $watchlistIds);
        $this->assign("recensioni", $recensioni);
        $this->display("film.tpl");
    }

    /**
     * Mostra la pagina di dettaglio di un episodio specifico di una serie TV.
     * 
     * @param EEpisodio $episodio Episodio da visualizzare
     * @param ESerie $serie Serie di appartenenza dell'episodio
     * @param array $recensioni Array di recensioni relative all'episodio
     * @return void
     */
    public function mostraEpisodio($episodio, $serie, $recensioni = [])
    {
        $this->assign("episodio", $episodio);
        $this->assign("serie", $serie);
        $this->assign("recensioni", $recensioni);
        $this->display("episodio.tpl");
    }

    /**
     * Mostra la pagina dei risultati di ricerca combinata tra film, serie TV e utenti.
     * 
     * @param array $film Array di film trovati
     * @param array $serie Array di serie TV trovate
     * @param array $utenti Array di utenti trovati
     * @return void
     */
    public function mostraRicerca($film, $serie, $utenti)
    {
        $this->assign("film", $film);
        $this->assign("serie", $serie);
        $this->assign("utenti", $utenti);
        $this->display("ricerca.tpl");
    }
}
