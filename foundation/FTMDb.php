<?php

/**
 * Carica la configurazione di The Movie Database (TMDb)
 */
if (file_exists(__DIR__ . '/../bin/config.php')) {
    require_once __DIR__ . '/../bin/config.php';
} else {
    if (!defined('TMDB_API_KEY')) {
        define('TMDB_API_KEY', 'INSERISCI_QUI_LA_TUA_CHIAVE');
    }
}

/**
 * Classe FTMDb
 * 
 * Classe foundation per l'accesso alle API di The Movie Database (TMDb)
 * Gestisce le richieste HTTP e il parsing delle risposte JSON
 * 
 * @package Foundation
 * @author Marco Viscovo
 */
class FTMDb
{
    /**
     * Effettua una richiesta all'API di TMDb
     * 
     * @param string $url URL della richiesta
     * @return array Risposta decodificata in formato JSON
     */
    private static function makeRequest(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    /**
     * URL base per le API di TMDb
     */
    private const BASE_URL = "https://api.themoviedb.org/3";

    /**
     * Esegue una ricerca nel database di TMDb
     * 
     * @param string $query Query di ricerca
     * @return array Risultati della ricerca
     */
    public static function search(string $query)
    {
        $url = self::BASE_URL . "/search/multi?api_key=" . TMDB_API_KEY . "&language=it-IT&query=" . urlencode($query);

        $result = self::makeRequest($url);
        $result = $result['results'];
        return $result;
    }

    /**
     * Recupera i dettagli di un film dal database di TMDb
     * 
     * @param int $tmdbId ID del film su TMDb
     * @return array Dettagli del film
     */
    public static function fetchFilm(int $tmdbId)
    {
        $url = self::BASE_URL . "/movie/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT&append_to_response=credits,genres,videos";

        $result = self::makeRequest($url);
        return $result;
    }

    /**
     * Recupera i dettagli di una serie TV dal database di TMDb
     * 
     * @param int $tmdbId ID della serie TV su TMDb
     * @return array Dettagli della serie TV
     */
    public static function fetchSerie(int $tmdbId)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT&append_to_response=credits,genres,videos";

        $result = self::makeRequest($url);
        return $result;
    }

    /**
     * Recupera i dettagli di un attore dal database di TMDb
     * 
     * @param int $tmdbId ID dell'attore su TMDb
     * @return array Dettagli dell'attore
     */
    public static function fetchAttore(int $tmdbId)
    {
        $url = self::BASE_URL . "/person/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result;
    }

    /**
     * Recupera i film più popolari dal database di TMDb
     * 
     * @param int $page Numero di pagina
     * @return array Lista di film
     */
    public static function getPopularMovies(int $page)
    {
        $url = self::BASE_URL . "/movie/popular?api_key=" . TMDB_API_KEY . "&language=it-IT&page=" . $page;

        $result = self::makeRequest($url);
        return $result['results'] ?? [];
    }

    /**
     * Recupera le serie TV più popolari dal database di TMDb
     * 
     * @param int $page Numero di pagina
     * @return array Lista di serie TV
     */
    public static function getPopularSeries(int $page)
    {
        $url = self::BASE_URL . "/tv/popular?api_key=" . TMDB_API_KEY . "&language=it-IT&page=" . $page;

        $result = self::makeRequest($url);
        return $result['results'] ?? [];
    }

    /**
     * Recupera i trailer di un film dal database di TMDb
     * 
     * @param int $tmdbId ID del film su TMDb
     * @return array Lista di trailer
     */
    public static function fetchFilmTrailers(int $tmdbId)
    {
        $url = self::BASE_URL . "/movie/" . $tmdbId . "/videos?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result['results'] ?? [];
    }

    /**
     * Recupera i trailer di una serie TV dal database di TMDb
     * 
     * @param int $tmdbId ID della serie TV su TMDb
     * @return array Lista di trailer
     */
    public static function fetchSerieTrailers(int $tmdbId)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "/videos?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result['results'] ?? [];
    }

    /**
     * Recupera i dettagli di un episodio dal database di TMDb
     * 
     * @param int $tmdbId ID della serie TV su TMDb
     * @param int $season Numero della stagione
     * @param int $episode Numero dell'episodio
     * @return array Dettagli dell'episodio
     */
    public static function fetchEpisode(int $tmdbId, int $season, int $episode)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "/season/" . $season . "/episode/" . $episode . "?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result;
    }

    /**
     * Recupera i dettagli di una stagione dal database di TMDb
     * 
     * @param int $tmdbId ID della serie TV su TMDb
     * @param int $season Numero della stagione
     * @return array Dettagli della stagione
     */
    public static function fetchSeriesEpisodes(int $tmdbId, int $season)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "/season/" . $season . "?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result;
    }
}
