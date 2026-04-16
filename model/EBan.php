<?php
class EBan
{
    protected int $id;
    protected EUtente $utente;
    protected EAmministratore $amministratore;
    protected DateTime $dataBan;
    protected DateTime $dataScadenza;
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
