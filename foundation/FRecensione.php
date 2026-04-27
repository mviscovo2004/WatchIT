<?php





class FRecensione
{
    //istanza del gestore entita
    public static function getEntityManager()
    {
        return FEntityManager::getInstance();
    }

    //--- CRUD ---
    //create
    public static function insert(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->persist($recensione);
        $em->flush();
        return ($recensione->getId() != null) ? true : false;
    }

    //delete
    public static function delete(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->remove($recensione);
        $em->flush();
        return true;
    }

    //update
    public static function update(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    //read
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $recensione = $em->find(ERecensione::class, $id);
        return $recensione;
    }

    //read all
    public static function findAll()
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findAll();
        return $recensioni;
    }

    //read by user
    public static function findByUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['utente' => $idUtente]);
        return $recensioni;
    }

    //read by content
    public static function findByContenuto(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto]);
        return $recensioni;
    }

    //read by user and content
    public static function findByUtenteAndContenuto(int $idUtente, int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['utente' => $idUtente, 'contenuto' => $idContenuto]);
        return $recensioni;
    }

    //read by content (solo recensioni positive)
    public static function findByContenutoPositivo(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto, 'voto' => 5]);
        return $recensioni;
    }

    //read by content (solo recensioni negative)
    public static function findByContenutoNegativo(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto, 'voto' => 1]);
        return $recensioni;
    }
}
