<?php

class FContenuto
{
    //istanza del gestore entita
    public static function getEntityManager()
    {
        return  FEntityManager::getInstance();
    }

    //--- CRUD ---
    //create
    public static function insert(EContenuto $contenuto)
    {
        $em = self::getEntityManager();
        $em->persist($contenuto);
        $em->flush();
        return ($contenuto->getId() != null) ? true : false;
    }

    //delete
    public static function delete(EContenuto $contenuto)
    {
        $em = self::getEntityManager();
        $em->remove($contenuto);
        $em->flush();
        return true;
    }

    //update
    public static function update(EContenuto $contenuto)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    //read
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $contenuto = $em->find(EContenuto::class, $id);
        return $contenuto;
    }

    //read all
    public static function findAll()
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EContenuto::class)->findAll();
        return $contenuti;
    }

    //search by title
    public static function search(string $query)
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EContenuto::class)->createQueryBuilder('c')
            ->where('c.titolo LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        return $contenuti;
    }

    //search by genre
    public static function searchByGenre(string $query)
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EContenuto::class)->createQueryBuilder('c')
            ->where('c.generi LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        return $contenuti;
    }

    //search by anno
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

    //search by tipo (film o serie tv)
    public static function searchByTipo(string $query)
    {
        $em = self::getEntityManager();
        $contenuti = $em->getRepository(EContenuto::class)->createQueryBuilder('c')
            ->where('c.tipo LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        return $contenuti;
    }
}
