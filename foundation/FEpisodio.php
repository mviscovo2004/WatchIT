<?php

/**
 * Classe FEpisodio
 * 
 * Classe foundation per l'entità EEpisodio
 * Gestisce le operazioni CRUD e dei privilegi per l'entità EEpisodio
 * Estende FContenuto per ereditare i metodi di FFoundation
 * 
 * @package Foundation
 * @author Marco Viscovo
 */

class FEpisodio extends FContenuto
{

    /**
     * Trova un episodio tramite il suo ID
     * 
     * @param int $id ID dell'episodio
     * @return EEpisodio|null Episodio trovato o null se non esiste
     */
    #[Override]
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        return $em->find(EEpisodio::class, $id);
    }

    /**
     * Trova tutti gli episodi
     * 
     * @return array Lista di episodi
     */
    #[Override]
    public static function findAll()
    {
        $em = self::getEntityManager();
        return $em->getRepository(EEpisodio::class)->findAll();
    }
}
