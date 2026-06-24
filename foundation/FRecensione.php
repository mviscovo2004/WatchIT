<?php

/**
 * Classe FRecensione
 * 
 * Classe foundation per l'entità ERecensione
 * Gestisce le operazioni CRUD e delle query per l'entità ERecensione
 * Estende FFoundation per l'instanza di EntityManager
 * 
 * @package Foundation
 * @author Marco Viscovo
 */

class FRecensione extends FFoundation
{
    /**
     * Inserisce una recensione nel database
     * 
     * @param ERecensione $recensione Recensione da inserire
     * @return bool True se l'inserimento è andato a buon fine
     */
    public static function insert(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->persist($recensione);
        $em->flush();
        return ($recensione->getId() != null) ? true : false;
    }

    /**
     * Elimina una recensione dal database
     * 
     * @param ERecensione $recensione Recensione da eliminare
     * @return bool True se l'eliminazione è andata a buon fine
     */
    public static function delete(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->remove($recensione);
        $em->flush();
        return true;
    }

    /**
     * Aggiorna una recensione nel database
     * 
     * @param ERecensione $recensione Recensione da aggiornare
     * @return bool True se l'aggiornamento è andato a buon fine
     */
    public static function update(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    /**
     * Trova una recensione tramite il suo ID
     * 
     * @param int $id ID della recensione
     * @return ERecensione|null Recensione trovata o null se non esiste
     */
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $recensione = $em->find(ERecensione::class, $id);
        return $recensione;
    }

    /**
     * Trova tutte le recensioni
     * 
     * @return array Lista di recensioni
     */
    public static function findAll()
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findAll();
        return $recensioni;
    }

    /**
     * Trova le recensioni di un utente
     * 
     * @param int $idUtente ID dell'utente
     * @return array Lista di recensioni
     */
    public static function findByUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['utente' => $idUtente]);
        return $recensioni;
    }

    /**
     * Trova le recensioni di un contenuto
     * 
     * @param int $idContenuto ID del contenuto
     * @return array Lista di recensioni
     */
    public static function findByContenuto(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto]);
        return $recensioni;
    }

    /**
     * Trova le recensioni di un episodio
     * 
     * @param int $idEpisodio ID dell'episodio
     * @return array Lista di recensioni
     */
    public static function findByEpisodio(int $idEpisodio)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['episodio' => $idEpisodio]);
        return $recensioni;
    }

    /**
     * Trova le recensioni di un utente e di un contenuto
     * 
     * @param int $idUtente ID dell'utente
     * @param int $idContenuto ID del contenuto
     * @return array Lista di recensioni
     */
    public static function findByUtenteAndContenuto(int $idUtente, int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['utente' => $idUtente, 'contenuto' => $idContenuto]);
        return $recensioni;
    }

    /**
     * Trova le recensioni di un contenuto con voto positivo
     * 
     * @param int $idContenuto ID del contenuto
     * @return array Lista di recensioni
     */
    public static function findByContenutoPositivo(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto, 'voto' => 5]);
        return $recensioni;
    }

    /**
     * Trova le recensioni di un contenuto con voto negativo
     * 
     * @param int $idContenuto ID del contenuto
     * @return array Lista di recensioni
     */
    public static function findByContenutoNegativo(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto, 'voto' => 1]);
        return $recensioni;
    }

    /**
     * Aggiunge una recensione al database
     * 
     * @param int $idRecensione ID della recensione
     * @param string $titolo Titolo della recensione
     * @param int $voto Voto della recensione
     * @param string $descrizione Descrizione della recensione
     * @param EContenuto $contenuto Contenuto della recensione
     * @param EUtente $utente Utente della recensione
     * @return bool True se l'aggiunta è andata a buon fine
     */
    public static function aggiungiRecensione(int $idRecensione, string $titolo, int $voto, string $descrizione, EContenuto $contenuto, EUtente $utente)
    {
        $em = self::getEntityManager();
        $recensione = new ERecensione($idRecensione, $titolo, $voto, $descrizione, $contenuto, null, $utente, new DateTime());
        $em->persist($recensione);
        $em->flush();
        return true;
    }

    /**
     * Aggiunge una recensione di episodio al database
     * 
     * @param int $idRecensione ID della recensione
     * @param string $titolo Titolo della recensione
     * @param int $voto Voto della recensione
     * @param string $descrizione Descrizione della recensione
     * @param EContenuto $contenuto Contenuto della recensione
     * @param EEpisodio $episodio Episodio della recensione
     * @param EUtente $utente Utente della recensione
     * @return bool True se l'aggiunta è andata a buon fine
     */
    public static function aggiungiRecensioneEpisodio(int $idRecensione, string $titolo, int $voto, string $descrizione, EContenuto $contenuto, EEpisodio $episodio, EUtente $utente)
    {
        $em = self::getEntityManager();
        $recensione = new ERecensione($idRecensione, $titolo, $voto, $descrizione, $contenuto, $episodio, $utente, new DateTime());
        $em->persist($recensione);
        $em->flush();
        return true;
    }

    /**
     * Ottiene le ultime recensioni
     * 
     * @param int $limit Numero massimo di recensioni da ottenere
     * @return array Lista di recensioni
     */
    public static function getUltimeRecensioni(int $limit = 5)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy([], ['dataPubblicazione' => 'DESC'], $limit);
        return $recensioni;
    }
}
