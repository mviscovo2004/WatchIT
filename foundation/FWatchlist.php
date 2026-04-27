<?php

class FWatchlist
{
    //istanza del gestore entita
    public static function getEntityManager()
    {
        return  FEntityManager::getInstance();
    }

    //--- CRUD ---
    //create
    public static function insert(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->persist($watchlist);
        $em->flush();
        return ($watchlist->getId() != null) ? true : false;
    }

    //delete
    public static function delete(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->remove($watchlist);
        $em->flush();
        return true;
    }

    //update
    public static function update(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    //read
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $id);
        return $watchlist;
    }

    //read all
    public static function findAll()
    {
        $em = self::getEntityManager();
        $watchlists = $em->getRepository(EWatchlist::class)->findAll();
        return $watchlists;
    }

    //ricerca per utente
    public static function findByUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $watchlists = $em->getRepository(EWatchlist::class)->findBy(['utente' => $idUtente]);
        return $watchlists;
    }


    //ritorna tutti i contenuti di una watchlist
    public static function getContenuti(int $idWatchlist)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $idWatchlist);
        $contenuti = $watchlist->getContenutiSalvati();
        return $contenuti;
    }

    //aggiunge un contenuto alla watchlist
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

    //rimuove un contenuto dalla watchlist
    public static function removeContenuto(int $idWatchlist, int $idContenuto)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $idWatchlist);
        if (self::contains($idWatchlist, $idContenuto)) {
            $contenuti = $watchlist->getContenutiSalvati();
            //rimuove il contenuto dalla lista
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

    //cerca se un contenuto è nella watchlist
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

    //get pubbliche
    public static function getPubbliche()
    {
        $em = self::getEntityManager();
        $watchlists = $em->getRepository(EWatchlist::class)->findBy(['visibilita' => Privacy::pubblico]);
        return $watchlists;
    }
}
