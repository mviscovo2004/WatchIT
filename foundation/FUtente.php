<?php

/**
 * Classe FUtente
 * 
 * Gestisce l'interazione con il database per quanto riguarda gli utenti.
 * Estende la classe FFoundation che fornisce metodi generici per l'interazione con il database.
 * 
 * @package foundation
 * @author Marco Viscovo
 */
class FUtente extends FFoundation
{

    /**
     * Inserisce un utente nel database
     * 
     * @param EUtente $utente Utente da inserire
     * @return bool True se l'utente è stato inserito correttamente, false altrimenti
     */
    public static function insert(EUtente $utente)
    {
        $em = self::getEntityManager();
        $em->persist($utente);
        $em->flush();
        return ($utente->getId() != null) ? true : false;
    }


    /**
     * Elimina un utente dal database
     * 
     * @param EUtente $utente Utente da eliminare
     * @return bool True se l'utente è stato eliminato correttamente, false altrimenti
     */
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

    /**
     * Aggiorna un utente nel database
     * 
     * @param EUtente $utente Utente da aggiornare
     * @return bool True se l'utente è stato aggiornato correttamente, false altrimenti
     */
    public static function update(EUtente $utente)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }


    /**
     * Trova un utente tramite ID
     * 
     * @param int $id ID dell'utente
     * @return EUtente Utente trovato
     */
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $utente = $em->find(EUtente::class, $id);
        return $utente;
    }

    /**
     * Trova un utente tramite username
     * 
     * @param string $username Username dell'utente
     * @return EUtente Utente trovato
     */
    public static function findByUsername(string $username)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['username' => $username]);
        return $utente;
    }

    /**
     * Trova un utente tramite email
     * 
     * @param string $email Email dell'utente
     * @return EUtente Utente trovato
     */
    public static function findByEmail(string $email)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['email' => $email]);
        return $utente;
    }

    /**
     * Trova tutti gli utenti
     * 
     * @return array Array di utenti
     */
    public static function findAll()
    {
        $em = self::getEntityManager();
        $utenti = $em->getRepository(EUtente::class)->findAll();
        return $utenti;
    }

    /**
     * Cerca utenti tramite una query
     * 
     * @param string $query Query da cercare
     * @return array Array di utenti trovati
     */
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

    /**
     * Segue un utente
     * 
     * @param int $idUtente ID dell'utente che segue
     * @param int $idUtenteSeguito ID dell'utente seguito
     * @return bool True se l'utente è stato seguito correttamente, false altrimenti
     */
    public static function follow(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        $utente->addSeguito($utenteSeguito);
        $em->flush();
        return true;
    }

    /**
     * Smette di seguire un utente
     * 
     * @param int $idUtente ID dell'utente che smette di seguire
     * @param int $idUtenteSeguito ID dell'utente smesso di seguire
     * @return bool True se l'utente è stato smesso di seguire correttamente, false altrimenti
     */
    public static function unfollow(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        $utente->removeSeguito($utenteSeguito);
        $em->flush();
        return true;
    }

    /**
     * Verifica se un utente segue un altro utente
     * 
     * @param int $idUtente ID dell'utente che segue
     * @param int $idUtenteSeguito ID dell'utente seguito
     * @return bool True se l'utente segue l'altro utente, false altrimenti
     */
    public static function isFollowing(int $idUtente, int $idUtenteSeguito)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        $utenteSeguito = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtenteSeguito]);
        return $utente->isFollowing($utenteSeguito);
    }

    /**
     * Ottiene i seguaci di un utente
     * 
     * @param int $idUtente ID dell'utente
     * @return array Array di utenti seguaci
     */
    public static function getFollowers(int $idUtente)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        return $utente->getSeguaci();
    }

    /**
     * Ottiene gli utenti seguiti da un utente
     * 
     * @param int $idUtente ID dell'utente
     * @return array Array di utenti seguiti
     */
    public static function getFollowing(int $idUtente)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['id' => $idUtente]);
        return $utente->getSeguiti();
    }

    /**
     * Esegue il login di un utente
     * 
     * @param string $identificativo Email o username dell'utente
     * @param string $password Password dell'utente
     * @return EUtente Utente loggato
     */
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

    /**
     * Registra un nuovo utente
     * 
     * @param string $nome Nome dell'utente
     * @param string $cognome Cognome dell'utente
     * @param string $foto Foto dell'utente
     * @param string $username Username dell'utente
     * @param string $email Email dell'utente
     * @param string $password Password dell'utente
     * @return EUtente Utente registrato
     */
    public static function register(string $nome, string $cognome, string $foto, string $username, string $email, string $password)
    {
        $em = self::getEntityManager();
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $utente = new EUtente(0, $nome, $cognome, $foto, $username, $email, $passwordHash);
        $em->persist($utente);
        $em->flush();
        return $utente;
    }

    /**
     * Promuove un utente ad amministratore
     * 
     * @param int $idUtente ID dell'utente
     * @return bool True se l'utente è stato promosso correttamente, false altrimenti
     */
    public static function promuoviAdAdmin(int $idUtente)
    {
        $em = self::getEntityManager();
        $connection = $em->getConnection();
        $connection->executeStatement("UPDATE utenti SET tipo = 'admin' WHERE id = :id", ['id' => $idUtente]);
        return true;
    }

    /**
     * Retrocede un utente ad admin
     * 
     * @param int $idUtente ID dell'utente
     * @return bool True se l'utente è stato retrocesso correttamente, false altrimenti
     */
    public static function retrocediAdUtente(int $idUtente)
    {
        $em = self::getEntityManager();
        $connection = $em->getConnection();
        $connection->executeStatement("UPDATE utenti SET tipo = 'utente' WHERE id = :id", ['id' => $idUtente]);
        return true;
    }

    /**
     * Manda email per recupero password
     * 
     * @param string $email Email dell'utente
     * @return bool True se la password è stata recuperata correttamente, false altrimenti
     */
    public static function forgotPassword(string $email)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->findOneBy(['email' => $email]);
        if ($utente != null) {
            $token = bin2hex(random_bytes(32));


            $dataScadenza = new DateTime('+1 hour');

            $utente->setTokenRecupero($token);
            $utente->setDataScadenzaToken($dataScadenza);
            $host = Session::getServer('HTTP_HOST', 'localhost');
            $scriptName = Session::getServer('SCRIPT_NAME', '');
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

    /**
     * Cambia la password di un utente
     * 
     * @param string $token Token di recupero
     * @param string $password Nuova password
     * @return bool True se la password è stata resettata correttamente, false altrimenti
     */
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
