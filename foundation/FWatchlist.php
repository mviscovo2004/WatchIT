<?php

class FWatchlist extends FFoundation
{

    
    
    public static function insert(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->persist($watchlist);
        $em->flush();
        return ($watchlist->getId() != null) ? true : false;
    }

    
    public static function delete(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->remove($watchlist);
        $em->flush();
        return true;
    }

    
    public static function update(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $id);
        return $watchlist;
    }

    
    public static function findAll()
    {
        $em = self::getEntityManager();
        $watchlists = $em->getRepository(EWatchlist::class)->findAll();
        return $watchlists;
    }

    
    public static function findByUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $watchlists = $em->getRepository(EWatchlist::class)->findBy(['utente' => $idUtente]);
        return $watchlists;
    }


    
    public static function getContenuti(int $idWatchlist)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $idWatchlist);
        $contenuti = $watchlist->getContenutiSalvati();
        return $contenuti;
    }

    
    public static function addContenuto(int $idWatchlist, int $idContenuto)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $idWatchlist);
        $contenuto = $em->find(EContenuto::class, $idContenuto);
        if (self::contains($idWatchlist, $idContenuto)) {
            return false;
        } else {
            $contenuti = $watchlist->getContenutiSalvati();
            $contenuti[] = $contenuto;
            $watchlist->setContenutiSalvati($contenuti);
            $em->flush();
            return true;
        }
    }

    
    public static function removeContenuto(int $idWatchlist, int $idContenuto)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $idWatchlist);
        if (self::contains($idWatchlist, $idContenuto)) {
            $contenuti = $watchlist->getContenutiSalvati();
            
            foreach ($contenuti as $index => $c) {
                if ($c->getId() == $idContenuto) {
                    unset($contenuti[$index]);
                    break;
                }
            }
            $watchlist->setContenutiSalvati($contenuti);
            $em->flush();
            return true;
        } else {
            return false;
        }
    }

    
    public static function contains(int $idWatchlist, int $idContenuto)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $idWatchlist);
        $contenuti = $watchlist->getContenutiSalvati();
        foreach ($contenuti as $c) {
            if ($c->getId() == $idContenuto) {
                return true;
            }
        }
        return false;
    }

    public static function findPubblicheByUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $watchlists = $em->getRepository(EWatchlist::class)->findBy([
            'utente' => $idUtente,
            'visibilita' => Privacy::pubblico->name
        ]);
        return $watchlists;
    }
}
