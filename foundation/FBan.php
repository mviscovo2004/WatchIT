<?php

/**
 * Classe FBan
 * 
 * Classe foundation per l'entità EBan
 * Gestisce le operazioni di CRUD e dei privilegi per l'entità EBan.
 * Estende FFoundation per l'instanza di EntityManager.
 * 
 * @package Foundation
 * @author Marco Viscovo
 */
class FBan extends FFoundation
{

    /**
     * Inserisce un nuovo ban nel database.
     *
     * @param EBan $ban L'oggetto EBan da inserire.
     * @return bool True se l'inserimento è andato a buon fine.
     */
    public static function insert(EBan $ban)
    {
        $em = self::getEntityManager();
        $em->persist($ban);
        $em->flush();
        return true;
    }

    /**
     * Elimina un ban dal database.
     *
     * @param EBan $ban L'oggetto EBan da eliminare.
     * @return bool True se l'eliminazione è andata a buon fine.
     */
    public static function delete(EBan $ban)
    {
        $em = self::getEntityManager();
        $em->remove($ban);
        $em->flush();
        return true;
    }

    /**
     * Aggiorna un ban esistente nel database.
     *
     * @param EBan $ban L'oggetto EBan da aggiornare.
     * @return bool True se l'aggiornamento è andato a buon fine.
     */
    public static function update(EBan $ban)
    {
        $em = self::getEntityManager();
        $em->flush();
        return true;
    }

    /**
     * Restituisce tutti i ban presenti nel database.
     *
     * @return array Un array contenente tutti gli oggetti EBan.
     */
    public static function findAll(): array
    {
        $em = self::getEntityManager();
        $bans = $em->getRepository(EBan::class)->findAll();
        return $bans;
    }

    /**
     * Restituisce un ban tramite ID.
     *
     * @param int $id L'ID del ban da cercare.
     * @return EBan|null L'oggetto EBan trovato, oppure null se non esiste.
     */
    public static function findById(int $id)
    {
        $em = self::getEntityManager();
        $ban = $em->find(EBan::class, $id);
        return $ban;
    }

    /**
     * Restituisce tutti i ban di un utente.
     *
     * @param EUtente $utente L'utente di cui cercare i ban.
     * @return array Un array contenente tutti gli oggetti EBan dell'utente.
     */
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

    /**
     * Restituisce tutti i ban attivi (scadenza futura).
     *
     * @return array Un array contenente tutti gli oggetti EBan attivi.
     */
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

    /**
     * Restituisce i ban filtrati per data di fine.
     *
     * @param DateTime $dataFine La data di fine da usare come filtro.
     * @return array Un array contenente gli oggetti EBan che soddisfano il filtro.
     */
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

    /**
     * Verifica se un utente è bannato e restituisce il ban se attivo.
     *
     * @param int $idUtente L'ID dell'utente da verificare.
     * @return EBan|null L'oggetto EBan se l'utente è bannato, oppure null se non lo è.
     */
    public static function isBanned(int $idUtente)
    {
        $em = self::getEntityManager();
        $utente = $em->getRepository(EUtente::class)->find($idUtente);
        if ($utente == null) {
            return null;
        }
        $ban = $em->getRepository(EBan::class)->findOneBy(['utente' => $utente]);
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

    /**
     * Pulisce i ban scaduti.
     */
    public static function cleanExpiredBans()
    {
        $em = self::getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('b')
            ->from('EBan', 'b')
            ->where('b.dataFine <= :ora')
            ->setParameter('ora', new DateTime());

        $expiredBans = $qb->getQuery()->getResult();

        if (!empty($expiredBans)) {
            foreach ($expiredBans as $ban) {
                $em->remove($ban);
            }
            $em->flush();
        }
    }

    /**
     * Crea un nuovo ban.
     *
     * @param int $idUtente L'ID dell'utente da bannare.
     * @param DateTime $dataFine La data di fine del ban.
     * @param string $motivo Il motivo del ban.
     * @param int $idAmministratore L'ID dell'amministratore che effettua il ban.
     * @return bool True se la creazione è andata a buon fine.
     */
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

    /**
     * Rimuove il ban da un utente.
     *
     * @param int $idUtente L'ID dell'utente da rimuovere il ban.
     * @return bool True se la rimozione è andata a buon fine.
     */
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
