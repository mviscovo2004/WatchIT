<?php

/**
 * Classe FEntityManager
 * 
 * Classe foundation per l'accesso al database tramite Doctrine EntityManager
 * Gestisce l'istanza di EntityManager in modo singleton
 * 
 * @package Foundation
 * @author Marco Viscovo
 */

class FEntityManager
{
    /**
     * @var object Istanza di EntityManager
     */
    private static $conn;

    /**
     * Costruttore privato per implementare il pattern singleton
     */
    private function __construct() {}

    /**
     * Ottiene una istanza di EntityManager in modo singleton
     * 
     * @return object Istanza di EntityManager
     */
    public static function getInstance()
    {
        if (!isset(self::$conn)) {
            $config = require __DIR__ . '/bootstrap.php';
            self::$conn = $config['entityManager'];
        }

        return self::$conn;
    }
}
