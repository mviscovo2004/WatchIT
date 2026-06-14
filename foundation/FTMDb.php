<?php
if (file_exists(__DIR__ . '/../bin/config.php')) {
    require_once __DIR__ . '/../bin/config.php';
} else {
    if (!defined('TMDB_API_KEY')) {
        define('TMDB_API_KEY', 'INSERISCI_QUI_LA_TUA_CHIAVE');
    }
}

class FTMDb
{
    private static function makeRequest(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }


    private const BASE_URL = "https://api.themoviedb.org/3";


    public static function search(string $query)
    {
        $url = self::BASE_URL . "/search/multi?api_key=" . TMDB_API_KEY . "&language=it-IT&query=" . urlencode($query);

        $result = self::makeRequest($url);
        $result = $result['results'];
        return $result;
    }

    public static function fetchFilm(int $tmdbId)
    {
        $url = self::BASE_URL . "/movie/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT&append_to_response=credits,genres,videos";

        $result = self::makeRequest($url);
        return $result;
    }

    public static function fetchSerie(int $tmdbId)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT&append_to_response=credits,genres,videos";

        $result = self::makeRequest($url);
        return $result;
    }

    public static function fetchAttore(int $tmdbId)
    {
        $url = self::BASE_URL . "/person/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result;
    }


    public static function getPopularMovies(int $page)
    {
        $url = self::BASE_URL . "/movie/popular?api_key=" . TMDB_API_KEY . "&language=it-IT&page=" . $page;

        $result = self::makeRequest($url);
        return $result['results'] ?? [];
    }


    public static function getPopularSeries(int $page)
    {
        $url = self::BASE_URL . "/tv/popular?api_key=" . TMDB_API_KEY . "&language=it-IT&page=" . $page;

        $result = self::makeRequest($url);
        return $result['results'] ?? [];
    }


    public static function fetchFilmTrailers(int $tmdbId)
    {
        $url = self::BASE_URL . "/movie/" . $tmdbId . "/videos?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result['results'] ?? [];
    }

    public static function fetchSerieTrailers(int $tmdbId)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "/videos?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result['results'] ?? [];
    }

    public static function fetchEpisode(int $tmdbId, int $season, int $episode)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "/season/" . $season . "/episode/" . $episode . "?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result;
    }

    public static function fetchSeriesEpisodes(int $tmdbId, int $season)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "/season/" . $season . "?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $result = self::makeRequest($url);
        return $result;
    }
}
