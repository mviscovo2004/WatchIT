<?php

class FBan
{

    private static function getEntityManager()
    {
        return FEntityManager::getInstance();
    }

    //create
    public static function insert(EBan $ban)
    {
        $em = self::getEntityManager();
        $em->persist($ban);
        $em->flush();
        return true;
    }

    //delete
    public static function delete(EBan $ban)
    {
        $em = self::getEntityManager();
        $em->remove($ban);
        $em->flush();
        return true;
    }

    public static function update(EBan $ban)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    //read all
    public static function findAll(): array
    {
        $em = self::getEntityManager();
        $bans = $em->getRepository(EBan::class)->findAll();
        return $bans;
    }

    //read by id
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $ban = $em->find(EBan::class, $id);
        return $ban;
    }

    public static function findByUtente(EUtente $utente): array
    {
        $em = self::getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('b')
            ->from('EBan', 'b')
            ->where('b.utente = :utente')
            ->setParameter('utente', $utente);
        return $qb->getQuery()->getResult();
    }

    public static function findByBannati(): array
    {
        $em = self::getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('b')
            ->from('EBan', 'b')
            ->where('b.dataFine > :dataFine')
            ->setParameter('dataFine', new DateTime());
        return $qb->getQuery()->getResult();
    }

    public static function findByDataFine(DateTime $dataFine): array
    {
        $em = self::getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('b')
            ->from('EBan', 'b')
            ->where('b.dataFine > :dataFine')
            ->setParameter('dataFine', $dataFine);
        return $qb->getQuery()->getResult();
    }

    public static function isBanned(int $id)
    {
        $em = self::getEntityManager();
        $ban = $em->getRepository(EBan::class)->findOneBy(['id' => $id]);
        if ($ban != null) {
            $dataCorrente = new DateTime();
            if ($dataCorrente < $ban->getDataFine()) {
                return $ban;
            } else {
                $em->remove($ban);
                $em->flush();
                return null;
            }
        }
        return null;
    }

    public static function ban(int $idUtente, DateTime $dataFine, string $motivo, int $idAmministratore)
    {
        $em = self::getEntityManager();
        $admin = $em->getRepository(EAmministratore::class)->findOneBy(['id' => $idAmministratore]);
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $ban = new EBan(0, $utente, $admin, new DateTime(), $dataFine, $motivo);
        $em->persist($ban);
        $em->flush();
        return true;
    }

    public static function unban(int $idUtente)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $ban = $em->getRepository(EBan::class)->findOneBy(['utente' => $utente]);
        $em->remove($ban);
        $em->flush();
        return true;
    }
}
