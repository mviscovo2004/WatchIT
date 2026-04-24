<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'ban')]
class EBan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EUtente $utente;

    #[ORM\ManyToOne(targetEntity: EAmministratore::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EAmministratore $amministratore;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTime $dataBan;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTime $dataScadenza;

    #[ORM\Column(type: Types::TEXT)]
    protected string $motivo;

    public function __construct(int $id, EUtente $utente, EAmministratore $amministratore, DateTime $dataBan, DateTime $dataScadenza, string $motivo)
    {
        $this->id = $id;
        $this->utente = $utente;
        $this->amministratore = $amministratore;
        $this->dataBan = $dataBan;
        $this->dataScadenza = $dataScadenza;
        $this->motivo = $motivo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getUtente(): EUtente
    {
        return $this->utente;
    }

    public function setUtente(EUtente $utente)
    {
        $this->utente = $utente;
    }

    public function getAmministratore(): EAmministratore
    {
        return $this->amministratore;
    }

    public function setAmministratore(EAmministratore $amministratore)
    {
        $this->amministratore = $amministratore;
    }

    public function getDataBan(): DateTime
    {
        return $this->dataBan;
    }

    public function setDataBan(DateTime $dataBan)
    {
        $this->dataBan = $dataBan;
    }

    public function getDataScadenza(): DateTime
    {
        return $this->dataScadenza;
    }

    public function setDataScadenza(DateTime $dataScadenza)
    {
        $this->dataScadenza = $dataScadenza;
    }

    public function getMotivo(): string
    {
        return $this->motivo;
    }

    public function setMotivo(string $motivo)
    {
        $this->motivo = $motivo;
    }
}
