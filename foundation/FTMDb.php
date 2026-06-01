<?php
require_once __DIR__ . '/../bin/config.php';

class FTMDb
{


    private const BASE_URL = "https://api.themoviedb.org/3";

    //esegue una ricerca su tmdb
    public static function search(string $query)
    {
        $url = self::BASE_URL . "/search/multi?api_key=" . TMDB_API_KEY . "&language=it-IT&query=" . urlencode($query);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $result = json_decode($result, true);
        $result = $result['results'];
        return $result;
    }

    //prende un film da tmdb
    public static function fetchFilm(int $tmdbId)
    {
        $url = self::BASE_URL . "/movie/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT&append_to_response=credits,genres";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $result = json_decode($result, true);
        return $result;
    }

    //prende una serie da tmdb
    public static function fetchSerie(int $tmdbId)
    {
        $url = self::BASE_URL . "/tv/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT&append_to_response=credits,genres";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $result = json_decode($result, true);
        return $result;
    }

    //prende un attore da tmdb
    public static function fetchAttore(int $tmdbId)
    {
        $url = self::BASE_URL . "/person/" . $tmdbId . "?api_key=" . TMDB_API_KEY . "&language=it-IT";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $result = json_decode($result, true);
        return $result;
    }

    //film più popolari
    public static function getPopularMovies(int $page)
    {
        $url = self::BASE_URL . "/movie/popular?api_key=" . TMDB_API_KEY . "&language=it-IT&page=" . $page;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $result = json_decode($result, true);
        return $result['results'] ?? [];
    }

    //serie più popolari
    public static function getPopularSeries(int $page)
    {
        $url = self::BASE_URL . "/tv/popular?api_key=" . TMDB_API_KEY . "&language=it-IT&page=" . $page;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $result = json_decode($result, true);
        return $result['results'] ?? [];
    }
}
