<?php

class FEpisodio extends FContenuto
{
    // Cerca l'episodio interrogando direttamente la classe EEpisodio
    #[Override]
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        return $em->find(EEpisodio::class, $id);
    }

    // Cerca tutti gli episodi interrogando la classe EEpisodio
    #[Override]
    public static function findAll()
    {
        $em = self::getEntityManager();
        return $em->getRepository(EEpisodio::class)->findAll();
    }
}
