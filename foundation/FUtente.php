<?php


class FUtente
{
    //istanza del gestore entita
    public static function getEntityManager()
    {
        return  FEntityManager::getInstance();
    }

    // --- CRUD ---
    //create
    public static function insert(EUtente $utente)
    {
        $em = self::getEntityManager();
        $em->persist($utente);
        $em->flush();
        return ($utente->getId() != null) ? true : false;
    }

    //delete
    public static function delete(EUtente $utente)
    {
        $em = self::getEntityManager();
        $em->remove($utente);
        $em->flush();
        return true;
    }

    //update
    public static function update(EUtente $utente)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    //read
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $utente = $em->find(EUtente::class, $id);
        return $utente;
    }

    //read by username
    public static function findByUsername(string $username)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['username' => $username]);
        return $utente;
    }

    //read by email 
    public static function findByEmail(string $email)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['email' => $email]);
        return $utente;
    }

    //read all
    public static function findAll()
    {
        $em = self::getEntityManager();
        $utenti = $em->getRepository(EUtente::class)->findAll();
        return $utenti;
    }

    //search
    public static function search(string $query)
    {
        $em = self::getEntityManager();
        $utenti = $em->getRepository(EUtente::class)->createQueryBuilder('u')
            ->where('u.nome LIKE :query OR u.cognome LIKE :query OR u.email LIKE :query OR u.username LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        return $utenti;
    }

    //---Filtri ---
    //find not banned
    public static function findNotBanned()
    {
        $em = self::getEntityManager();
        $utenti = $em->getRepository(EUtente::class)->createQueryBuilder('u')
            ->where('u.bannato = false')
            ->getQuery()
            ->getResult();
        return $utenti;
    }

    //find banned
    public static function findBanned()
    {
        $em = self::getEntityManager();
        $utenti = $em->getRepository(EUtente::class)->createQueryBuilder('u')
            ->where('u.bannato = true')
            ->getQuery()
            ->getResult();
        return $utenti;
    }


    //isBanned
    public static function isBanned(int $id)
    {
        $em = self::getEntityManager();
        $ban = $em->getRepository(EBan::class)->findOneBy(['id' => $id]);
        if ($ban != null) {
            $dataCorrente = new DateTime();
            if ($dataCorrente < $ban->getDataScadenza()) {
                return $ban;
            } else {
                $em->remove($ban);
                $em->flush();
                return null;
            }
        }
        return null;
    }

    //---Operazioni Admin ---
    //ban
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

    //unban
    public static function unban(int $idUtente, DateTime $dataFine)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $ban = $em->getRepository(EBan::class)->findOneBy(['utente' => $utente]);
        $em->remove($ban);
        $em->flush();
        return true;
    }

    //---Operazioni Utente ---
    //follow
    public static function follow(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        $utente->addSeguito($utenteSeguito);
        $em->flush();
        return true;
    }

    //unfollow
    public static function unfollow(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        $utente->removeSeguito($utenteSeguito);
        $em->flush();
        return true;
    }

    //isFollowing
    public static function isFollowing(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        return $utente->isFollowing($utenteSeguito);
    }

    //getFollowers
    public static function getFollowers(int $idUtente)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        return $utente->getSeguaci();
    }

    //getFollowing
    public static function getFollowing(int $idUtente)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        return $utente->getSeguiti();
    }

    //login
    public static function login(string $email, string $password)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['email' => $email]);
        if ($utente != null && password_verify($password, $utente->getHashPassword())) {
            return $utente;
        }
        return null;
    }

    //register
    public static function register(string $nome, string $cognome, string $foto, string $username, string $email, string $password)
    {
        $em = self::getEntityManager();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $utente = new EUtente(0, $nome, $cognome, $foto, $username, $email, $passwordHash);
        $em->persist($utente);
        $em->flush();
        return $utente;
    }
}
