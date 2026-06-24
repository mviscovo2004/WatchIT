<?php

/**
 * Classe Session
 * 
 * Classe che gestisce l'avvio, la distruzione e la manipolazione della sessione utente
 * Fornisce metodi per l'interazione con i dati di sessione superglobali ($_SESSION, $_GET, $_POST, $_SERVER, $_COOKIE, $_FILES)
 * 
 * @package Foundation
 * @author Marco Viscovo
 */
class Session
{
    /**
     * Avvia la sessione se non è già avviata
     * 
     * @return void
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Distrugge la sessione
     * 
     * @return void
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Imposta un valore nella sessione
     * 
     * @param string $key Chiave della sessione
     * @param mixed $value Valore da impostare
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Ottiene un valore dalla sessione
     * 
     * @param string $key Chiave della sessione
     * @param mixed $default Valore di default
     * @return mixed Valore della sessione o valore di default
     */
    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Rimuove un valore dalla sessione
     * 
     * @param string $key Chiave della sessione
     * @return void
     */
    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Verifica se un valore esiste nella sessione
     * 
     * @param string $key Chiave della sessione
     * @return bool True se il valore esiste, false altrimenti
     */
    public static function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Verifica se l'utente è loggato
     * 
     * @return bool True se l'utente è loggato, false altrimenti
     */
    public static function isLogged()
    {
        return self::exists('user_id');
    }

    /**
     * Ottiene un valore da $_GET
     * 
     * @param string|null $key Chiave della superglobale $_GET
     * @param mixed $default Valore di default
     * @return mixed Valore della superglobale $_GET o valore di default
     */
    public static function getGet($key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    /**
     * Ottiene un valore da $_POST
     * 
     * @param string|null $key Chiave della superglobale $_POST
     * @param mixed $default Valore di default
     * @return mixed Valore della superglobale $_POST o valore di default
     */
    public static function getPost($key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    /**
     * Ottiene un valore da $_SERVER
     * 
     * @param string|null $key Chiave della superglobale $_SERVER
     * @param mixed $default Valore di default
     * @return mixed Valore della superglobale $_SERVER o valore di default
     */
    public static function getServer($key = null, $default = null)
    {
        if ($key === null) {
            return $_SERVER;
        }
        return $_SERVER[$key] ?? $default;
    }

    /**
     * Ottiene un valore da $_COOKIE
     * 
     * @param string|null $key Chiave della superglobale $_COOKIE
     * @param mixed $default Valore di default
     * @return mixed Valore della superglobale $_COOKIE o valore di default
     */
    public static function getCookie($key = null, $default = null)
    {
        if ($key === null) {
            return $_COOKIE;
        }
        return $_COOKIE[$key] ?? $default;
    }

    /**
     * Ottiene un valore da $_FILES
     * 
     * @param string|null $key Chiave della superglobale $_FILES
     * @param mixed $default Valore di default
     * @return mixed Valore della superglobale $_FILES o valore di default
     */
    public static function getFiles($key = null, $default = null)
    {
        if ($key === null) {
            return $_FILES;
        }
        return $_FILES[$key] ?? $default;
    }

    /**
     * Ottiene il metodo di richiesta HTTP
     * 
     * @return string Metodo di richiesta HTTP
     */
    public static function getRequestMethod()
    {
        return self::getServer('REQUEST_METHOD', 'GET');
    }


    /**
     * Verifica se la richiesta è di tipo POST
     * 
     * @return bool True se la richiesta è di tipo POST, false altrimenti
     */
    public static function isPost()
    {
        return self::getRequestMethod() === 'POST';
    }

    /**
     * Verifica se la richiesta è di tipo GET
     * 
     * @return bool True se la richiesta è di tipo GET, false altrimenti
     */
    public static function isGet()
    {
        return self::getRequestMethod() === 'GET';
    }
}
