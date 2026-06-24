<?php

/**
 * Classe FWatchlist
 * 
 * Classe foundation per l'entità EWatchlist
 * Gestisce le operazioni di CRUD e dei privilegi per l'entità EWatchlist
 * Estende FFoundation per l'instanza di EntityManager
 * 
 * @package Foundation
 * @author Marco Viscovo
 */
class FWatchlist extends FFoundation
{

    /**
     * Inserisce una nuova watchlist nel database.
     *
     * @param EWatchlist $watchlist L'oggetto EWatchlist da inserire.
     * @return bool True se l'inserimento è andato a buon fine.
     */
    public static function insert(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->persist($watchlist);
        $em->flush();
        return ($watchlist->getId() != null) ? true : false;
    }

    /**
     * Elimina una watchlist dal database.
     *
     * @param EWatchlist $watchlist L'oggetto EWatchlist da eliminare.
     * @return bool True se l'eliminazione è andata a buon fine.
     */
    public static function delete(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->remove($watchlist);
        $em->flush();
        return true;
    }

    /**
     * Aggiorna una watchlist esistente nel database.
     *
     * @param EWatchlist $watchlist L'oggetto EWatchlist da aggiornare.
     * @return bool True se l'aggiornamento è andato a buon fine.
     */
    public static function update(EWatchlist $watchlist)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    /**
     * Restituisce una watchlist tramite ID.
     *
     * @param int $id L'ID della watchlist da cercare.
     * @return EWatchlist|null L'oggetto EWatchlist trovato, oppure null se non esiste.
     */
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $id);
        return $watchlist;
    }

    /**
     * Restituisce tutte le watchlist presenti nel database.
     *
     * @return array Un array contenente tutti gli oggetti EWatchlist.
     */
    public static function findAll()
    {
        $em = self::getEntityManager();
        $watchlists = $em->getRepository(EWatchlist::class)->findAll();
        return $watchlists;
    }

    /**
     * Restituisce tutte le watchlist di un utente.
     *
     * @param int $idUtente L'ID dell'utente di cui cercare le watchlist.
     * @return array Un array contenente tutti gli oggetti EWatchlist dell'utente.
     */
    public static function findByUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $watchlists = $em->getRepository(EWatchlist::class)->findBy(['utente' => $idUtente]);
        return $watchlists;
    }

    /**
     * Restituisce tutti i contenuti di una watchlist.
     *
     * @param int $idWatchlist L'ID della watchlist di cui cercare i contenuti.
     * @return array Un array contenente tutti gli oggetti EContenuto della watchlist.
     */
    public static function getContenuti(int $idWatchlist)
    {
        $em = self::getEntityManager();
        $watchlist = $em->find(EWatchlist::class, $idWatchlist);
        $contenuti = $watchlist->getContenutiSalvati();
        return $contenuti;
    }

    /**
     * Aggiunge un contenuto a una watchlist.
     *
     * @param int $idWatchlist L'ID della watchlist a cui aggiungere il contenuto.
     * @param int $idContenuto L'ID del contenuto da aggiungere.
     * @return bool True se l'aggiunta è andata a buon fine.
     */
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

    /**
     * Rimuove un contenuto da una watchlist.
     *
     * @param int $idWatchlist L'ID della watchlist da cui rimuovere il contenuto.
     * @param int $idContenuto L'ID del contenuto da rimuovere.
     * @return bool True se la rimozione è andata a buon fine.
     */
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

    /**
     * Verifica se una watchlist contiene un determinato contenuto.
     *
     * @param int $idWatchlist L'ID della watchlist da controllare.
     * @param int $idContenuto L'ID del contenuto da cercare.
     * @return bool True se la watchlist contiene il contenuto, false altrimenti.
     */
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

    /**
     * Restituisce tutte le watchlist pubbliche di un utente.
     *
     * @param int $idUtente L'ID dell'utente di cui cercare le watchlist pubbliche.
     * @return array Un array contenente tutte le watchlist pubbliche dell'utente.
     */
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
