<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

/**
 * Classe EBan
 * 
 * Rappresenta un ban imposto ad un utente da parte di un amministratore.
 * 
 * @package Model
 * @author Marco Viscovo
 */

#[ORM\Entity]
#[ORM\Table(name: 'ban')]
class EBan
{
    /**
     * @var int Identificativo univoco del ban
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    /**
     * @var EUtente L'utente che ha ricevuto il ban
     */
    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EUtente $utente;

    /**
     * @var EAmministratore L'amministratore che ha inflitto il ban
     */
    #[ORM\ManyToOne(targetEntity: EAmministratore::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EAmministratore $amministratore;

    /**
     * @var DateTime Data di inizio del ban
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTime $dataBan;

    /**
     * @var DateTime Data di fine del ban
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTime $dataFine;

    /**
     * @var string Motivo del ban
     */
    #[ORM\Column(type: Types::TEXT)]
    protected string $motivo;

    /**
     * Costruttore della classe EBan.
     * 
     * @param int $id Identificativo univoco del ban
     * @param EUtente $utente Utente che ha ricevuto il ban
     * @param EAmministratore $amministratore Amministratore che ha inflitto il ban
     * @param DateTime $dataBan Data di inizio del ban
     * @param DateTime $dataFine Data di fine del ban
     * @param string $motivo Motivo del ban
     */
    public function __construct(int $id, EUtente $utente, EAmministratore $amministratore, DateTime $dataBan, DateTime $dataFine, string $motivo)
    {
        $this->id = $id;
        $this->utente = $utente;
        $this->amministratore = $amministratore;
        $this->dataBan = $dataBan;
        $this->dataFine = $dataFine;
        $this->motivo = $motivo;
    }

    /**
     * Ottiene l'identificativo univoco del ban.
     * 
     * @return int Identificativo univoco del ban
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Imposta l'identificativo univoco del ban.
     * 
     * @param int $id Identificativo univoco del ban
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Ottiene l'utente che ha ricevuto il ban.
     * 
     * @return EUtente Utente che ha ricevuto il ban
     */
    public function getUtente(): EUtente
    {
        return $this->utente;
    }

    /**
     * Imposta l'utente che ha ricevuto il ban.
     * 
     * @param EUtente $utente Utente che ha ricevuto il ban
     */
    public function setUtente(EUtente $utente)
    {
        $this->utente = $utente;
    }

    /**
     * Ottiene l'amministratore che ha inflitto il ban.
     * 
     * @return EAmministratore Amministratore che ha inflitto il ban
     */
    public function getAmministratore(): EAmministratore
    {
        return $this->amministratore;
    }

    /**
     * Imposta l'amministratore che ha inflitto il ban.
     * 
     * @param EAmministratore $amministratore Amministratore che ha inflitto il ban
     */
    public function setAmministratore(EAmministratore $amministratore)
    {
        $this->amministratore = $amministratore;
    }

    /**
     * Ottiene la data di inizio del ban.
     * 
     * @return DateTime Data di inizio del ban
     */
    public function getDataBan(): DateTime
    {
        return $this->dataBan;
    }

    /**
     * Imposta la data di inizio del ban.
     * 
     * @param DateTime $dataBan Data di inizio del ban
     */
    public function setDataBan(DateTime $dataBan)
    {
        $this->dataBan = $dataBan;
    }

    /**
     * Ottiene la data di fine del ban.
     * 
     * @return DateTime Data di fine del ban
     */
    public function getDataFine(): DateTime
    {
        return $this->dataFine;
    }

    /**
     * Imposta la data di fine del ban.
     * 
     * @param DateTime $dataFine Data di fine del ban
     */
    public function setDataFine(DateTime $dataFine)
    {
        $this->dataFine = $dataFine;
    }

    /**
     * Ottiene il motivo del ban.
     * 
     * @return string Motivo del ban
     */
    public function getMotivo(): string
    {
        return $this->motivo;
    }

    /**
     * Imposta il motivo del ban.
     * 
     * @param string $motivo Motivo del ban
     */
    public function setMotivo(string $motivo)
    {
        $this->motivo = $motivo;
    }
}
