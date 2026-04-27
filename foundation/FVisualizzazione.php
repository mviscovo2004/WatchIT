<?php


class FVisualizzazione
{
    //istanza del gestore entita
    public static function getEntityManager()
    {
        return FEntityManager::getInstance();
    }

    //---- CRUD ----
    //create
    public static function insert(EVisualizzazione $visualizzazione)
    {
        $em = self::getEntityManager();
        $em->persist($visualizzazione);
        $em->flush();
        return ($visualizzazione->getId() != null) ? true : false;
    }

    //delete
    public static function delete(EVisualizzazione $visualizzazione)
    {
        $em = self::getEntityManager();
        $em->remove($visualizzazione);
        $em->flush();
        return true;
    }

    //update
    public static function update(EVisualizzazione $visualizzazione)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    //read by id
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $visualizzazione = $em->find(EVisualizzazione::class, $id);
        return $visualizzazione;
    }

    //read all
    public static function findAll()
    {
        $em = self::getEntityManager();
        $visualizzazioni = $em->getRepository(EVisualizzazione::class)->findAll();
        return $visualizzazioni;
    }

    //read by user
    public static function findByUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $visualizzazioni = $em->getRepository(EVisualizzazione::class)->findBy(['utente' => $idUtente]);
        return $visualizzazioni;
    }

    //read by content
    public static function findByContenuto(int $idContenuto)
    {
        $em = self::getEntityManager();
        $visualizzazioni = $em->getRepository(EVisualizzazione::class)->findBy(['contenuto' => $idContenuto]);
        return $visualizzazioni;
    }

    //read by episode
    public static function findByEpisodio(int $idEpisodio)
    {
        $em = self::getEntityManager();
        $visualizzazioni = $em->getRepository(EVisualizzazione::class)->findBy(['episodio' => $idEpisodio]);
        return $visualizzazioni;
    }

    //read last by user and content
    public static function findLastByUtenteAndContenuto(int $idUtente, int $idContenuto)
    {
        $em = self::getEntityManager();
        $visualizzazioni = $em->getRepository(EVisualizzazione::class)->findOneBy(['utente' => $idUtente, 'contenuto' => $idContenuto], ['dataVisualizzazione' => 'DESC']);
        return $visualizzazioni;
    }
}
