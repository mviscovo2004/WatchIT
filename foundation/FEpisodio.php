<?php

class FEpisodio extends FContenuto
{
    
    #[Override]
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        return $em->find(EEpisodio::class, $id);
    }

    
    #[Override]
    public static function findAll()
    {
        $em = self::getEntityManager();
        return $em->getRepository(EEpisodio::class)->findAll();
    }
}
