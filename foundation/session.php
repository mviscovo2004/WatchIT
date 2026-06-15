<?php

class Session
{
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function isLogged()
    {
        return self::exists('user_id');
    }

    public static function getGet($key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    public static function getPost($key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }


    public static function getServer($key = null, $default = null)
    {
        if ($key === null) {
            return $_SERVER;
        }
        return $_SERVER[$key] ?? $default;
    }


    public static function getCookie($key = null, $default = null)
    {
        if ($key === null) {
            return $_COOKIE;
        }
        return $_COOKIE[$key] ?? $default;
    }

    public static function getFiles($key = null, $default = null)
    {
        if ($key === null) {
            return $_FILES;
        }
        return $_FILES[$key] ?? $default;
    }


    public static function getRequestMethod()
    {
        return self::getServer('REQUEST_METHOD', 'GET');
    }


    public static function isPost()
    {
        return self::getRequestMethod() === 'POST';
    }

    public static function isGet()
    {
        return self::getRequestMethod() === 'GET';
    }
}
