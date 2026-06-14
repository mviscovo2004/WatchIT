<?php





class FRecensione extends FFoundation
{

    
    
    public static function insert(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->persist($recensione);
        $em->flush();
        return ($recensione->getId() != null) ? true : false;
    }

    
    public static function delete(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->remove($recensione);
        $em->flush();
        return true;
    }

    
    public static function update(ERecensione $recensione)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $recensione = $em->find(ERecensione::class, $id);
        return $recensione;
    }

    
    public static function findAll()
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findAll();
        return $recensioni;
    }

    
    public static function findByUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['utente' => $idUtente]);
        return $recensioni;
    }

    
    public static function findByContenuto(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto]);
        return $recensioni;
    }

    public static function findByEpisodio(int $idEpisodio)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['episodio' => $idEpisodio]);
        return $recensioni;
    }

    
    public static function findByUtenteAndContenuto(int $idUtente, int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['utente' => $idUtente, 'contenuto' => $idContenuto]);
        return $recensioni;
    }

    
    public static function findByContenutoPositivo(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto, 'voto' => 5]);
        return $recensioni;
    }

    
    public static function findByContenutoNegativo(int $idContenuto)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['contenuto' => $idContenuto, 'voto' => 1]);
        return $recensioni;
    }

    public static function aggiungiRecensione(int $idRecensione, string $titolo, int $voto, string $descrizione, EContenuto $contenuto, EUtente $utente)
    {
        $em = self::getEntityManager();
        $recensione = new ERecensione($idRecensione, $titolo, $voto, $descrizione, $contenuto, null, $utente, new DateTime());
        $em->persist($recensione);
        $em->flush();
        return true;
    }

    public static function aggiungiRecensioneEpisodio(int $idRecensione, string $titolo, int $voto, string $descrizione, EContenuto $contenuto, EEpisodio $episodio, EUtente $utente)
    {
        $em = self::getEntityManager();
        $recensione = new ERecensione($idRecensione, $titolo, $voto, $descrizione, $contenuto, $episodio, $utente, new DateTime());
        $em->persist($recensione);
        $em->flush();
        return true;
    }

    public static function getUltimeRecensioni(int $limit = 5)
    {
        $em = self::getEntityManager();
        $recensioni = $em->getRepository(ERecensione::class)->findBy([], ['dataPubblicazione' => 'DESC'], $limit);
        return $recensioni;
    }
}
