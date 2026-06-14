<?php


class FUtente extends FFoundation
{

    
    
    public static function insert(EUtente $utente)
    {
        $em = self::getEntityManager();
        $em->persist($utente);
        $em->flush();
        return ($utente->getId() != null) ? true : false;
    }

    
    public static function delete(EUtente $utente)
    {
        $em = self::getEntityManager();


        
        $recensioni = $em->getRepository(ERecensione::class)->findBy(['utente' => $utente]);
        foreach ($recensioni as $recensione) {
            $em->remove($recensione);
        }

        
        $watchlists = $em->getRepository(EWatchlist::class)->findBy(['utente' => $utente]);
        foreach ($watchlists as $watchlist) {
            $em->remove($watchlist);
        }

        
        $banSubiti = $em->getRepository(EBan::class)->findBy(['utente' => $utente]);
        foreach ($banSubiti as $b) {
            $em->remove($b);
        }

        
        if ($utente instanceof EAmministratore) {
            $banEmessi = $em->getRepository(EBan::class)->findBy(['amministratore' => $utente]);
            foreach ($banEmessi as $b) {
                $em->remove($b);
            }
        }

        
        $em->remove($utente);

        $em->flush();
        return true;
    }


    
    public static function update(EUtente $utente)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $utente = $em->find(EUtente::class, $id);
        return $utente;
    }

    
    public static function findByUsername(string $username)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['username' => $username]);
        return $utente;
    }

    
    public static function findByEmail(string $email)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['email' => $email]);
        return $utente;
    }

    
    public static function findAll()
    {
        $em = self::getEntityManager();
        $utenti = $em->getRepository(EUtente::class)->findAll();
        return $utenti;
    }

    
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

    
    
    public static function follow(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        $utente->addSeguito($utenteSeguito);
        $em->flush();
        return true;
    }

    
    public static function unfollow(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        $utente->removeSeguito($utenteSeguito);
        $em->flush();
        return true;
    }

    
    public static function isFollowing(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        return $utente->isFollowing($utenteSeguito);
    }

    
    public static function getFollowers(int $idUtente)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        return $utente->getSeguaci();
    }

    
    public static function getFollowing(int $idUtente)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        return $utente->getSeguiti();
    }

    
    public static function login(string $identificativo, string $password)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['email' => $identificativo]);
        if ($utente == null) {
            $utente = $em->getRepository(EUtente::class)->findOneBy(['username' => $identificativo]);
        }
        if ($utente != null && password_verify($password, $utente->getHashPassword())) {
            return $utente;
        }
        return null;
    }

    
    public static function register(string $nome, string $cognome, string $foto, string $username, string $email, string $password)
    {
        $em = self::getEntityManager();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $utente = new EUtente(0, $nome, $cognome, $foto, $username, $email, $passwordHash);
        $em->persist($utente);
        $em->flush();
        return $utente;
    }

    
    public static function promuoviAdAdmin(int $idUtente)
    {
        $em = self::getEntityManager();
        $connection = $em->getConnection();
        $connection->executeStatement("UPDATE utenti SET tipo = 'admin' WHERE id = :id", ['id' => $idUtente]);
        return true;
    }

    
    public static function retrocediAdUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $connection = $em->getConnection();
        $connection->executeStatement("UPDATE utenti SET tipo = 'utente' WHERE id = :id", ['id' => $idUtente]);
        return true;
    }


    
    public static function forgotPassword(string $email)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['email' => $email]);
        if ($utente != null) {
            $token = bin2hex(random_bytes(32));

            
            $dataScadenza = new DateTime('+1 hour');

            $utente->setTokenRecupero($token);
            $utente->setDataScadenzaToken($dataScadenza);

            
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $dir = dirname($scriptName);
            $baseDir = ($dir === DIRECTORY_SEPARATOR || $dir === '/' || $dir === '\\') ? '' : $dir;

            $link = 'http://' . $host . $baseDir . '/index.php?controller=Utente&action=resetPassword&token=' . $token;


            $mailSent = false;

            
            if (function_exists('mail')) {
                
                $mailSent = @mail(
                    $email,
                    'Recupera Password - WatchIT',
                    "Gentile utente,\n\nAbbiamo ricevuto una richiesta di recupero password per il tuo account WatchIT.\n\nClicca sul link seguente per impostare una nuova password:\n\n"
                        . $link . "\n\n"
                        . "Questo link scadrà tra un'ora.\n\nSe non hai richiesto tu questo recupero, puoi ignorare questa email.",
                    "From: noreply@watchit.altervista.org\r\nContent-Type: text/plain; charset=UTF-8\r\n"
                );
            }

            
            if (!$mailSent || in_array($host, ['localhost', '127.0.0.1', '[::1]'])) {
                file_put_contents(__DIR__ . '/../recupero_link.txt', "Link per $email: " . $link . "\n");
            }

            $em->flush();
            return true;
        }
        return false;
    }

    
    public static function resetPassword(string $token, string $password)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['tokenRecupero' => $token]);

        
        if ($utente != null && $utente->getDataScadenzaToken() !== null && $utente->getDataScadenzaToken() > new DateTime()) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $utente->setHashPassword($passwordHash); 

            
            $utente->setTokenRecupero(null);
            $utente->setDataScadenzaToken(null);

            $em->flush();
            return true;
        }
        return false;
    }
}
