<?php

class FContenuto extends FFoundation
{

    
    
    public static function insert(EContenuto $contenuto)
    {
        $em = self::getEntityManager();
        $em->persist($contenuto);
        $em->flush();
        return ($contenuto->getId() != null) ? true : false;
    }

    
    public static function delete(EContenuto $contenuto)
    {
        $em = self::getEntityManager();

        
        $participations = $em->getRepository(EPartecipazione::class)->findBy(['contenuto' => $contenuto]);
        foreach ($participations as $p) {
            $em->remove($p);
        }

        
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $contenuto]);
        foreach ($recensioni as $r) {
            $em->remove($r);
        }

        
        $watchlists = $em->getRepository(EWatchlist::class)->findAll();
        foreach ($watchlists as $wl) {
            if ($wl->getContenutiSalvati()->contains($contenuto)) {
                $wl->getContenutiSalvati()->removeElement($contenuto);
            }
        }

        
        if ($contenuto instanceof ESerie) {
            $episodi = $em->getRepository(EEpisodio::class)->findBy(['serie' => $contenuto]);
            foreach ($episodi as $ep) {
                
                $recensioniEp = $em->getRepository(ERecensione::class)->findBy(['episodio' => $ep]);
                foreach ($recensioniEp as $rEp) {
                    $em->remove($rEp);
                }

                
                $em->remove($ep);
            }
        }

        
        $em->remove($contenuto);
        $em->flush();
        return true;
    }


    
    public static function update(EContenuto $contenuto)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $contenuto = $em->find(EContenuto::class, $id);
        return $contenuto;
    }

    
    public static function findAll()
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EContenuto::class)->findAll();
        return $contenuti;
    }

    
    public static function findAllFilm()
    {
        $em = self::getEntityManager();
        $film = $em->getRepository(EFilm::class)->findAll();
        return $film;
    }

    
    public static function findAllSerie()
    {
        $em = self::getEntityManager();
        $serie = $em->getRepository(ESerie::class)->findAll();
        return $serie;
    }

    
    public static function search(string $query)
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EContenuto::class)->createQueryBuilder('c')
            ->where('c.titolo LIKE :query')
            ->orderBy('c.titolo', 'ASC')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        return $contenuti;
    }

    
    public static function searchByGenre(string $query)
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EContenuto::class)->createQueryBuilder('c')
            ->where('c.generi LIKE :query')
            ->setParameter('query', '%"' . $query . '"%')
            ->getQuery()
            ->getResult();
        return $contenuti;
    }

    
    public static function searchByAnno(string $query)
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EContenuto::class)->createQueryBuilder('c')
            ->where('c.anno LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        return $contenuti;
    }

    
    public static function searchByTipo(string $query)
    {
        $em = self::getEntityManager();
        if (strtolower($query) == "film") {
            $contenuti = $em->getRepository(EFilm::class)->findAll();
        } else if (strtolower($query) == "serie" || strtolower($query) == "serie tv") {
            $contenuti = $em->getRepository(ESerie::class)->findAll();
        } else {
            $contenuti = [];
        }
        return $contenuti;
    }

    public static function getFilmPopolari(int $limit = 5)
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EFilm::class)->createQueryBuilder('f')
            ->orderBy('f.valutazioneMedia', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return $contenuti;
    }

    public static function getSeriePopolari(int $limit = 5)
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(ESerie::class)->createQueryBuilder('s')
            ->orderBy('s.valutazioneMedia', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return $contenuti;
    }
}
