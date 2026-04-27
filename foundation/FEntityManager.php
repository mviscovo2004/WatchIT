<?php

class FEntityManager
{
    private static $conn;

    private function __construct() {}

    public static function getInstance()
    {
        if (!isset(self::$conn)) {
            $config = require_once __DIR__ . '/bootstrap.php';
            self::$conn = $config['entityManager'];
        }

        return self::$conn;
    }
}
