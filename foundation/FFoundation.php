<?php

/**
 * Classe astratta FFoundation
 * 
 * Classe base per tutte le foundation, utile per centralizzare metodi comuni
 * 
 * @package Foundation
 * @author Marco Viscovo
 */
abstract class FFoundation
{
    /**
     * Ottiene l'Entity Manager
     *
     * @return object Istanza di EntityManager
     */
    public static function getEntityManager()
    {
        return FEntityManager::getInstance();
    }
}
