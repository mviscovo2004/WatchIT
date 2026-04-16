<?php
class EVisualizzazione
{
    protected int $id;
    protected EUtente $utente;
    protected EContenuto|EEpisodio $contenuto;
    protected DateTime $dataVisualizzazione;
    protected int $progressioneMinuti;

    public function __construct(int $id, EUtente $utente, EContenuto|EEpisodio $contenuto, DateTime $dataVisualizzazione, int $progressioneMinuti)
    {
        $this->id = $id;
        $this->utente = $utente;
        $this->contenuto = $contenuto;
        $this->dataVisualizzazione = $dataVisualizzazione;
        $this->progressioneMinuti = $progressioneMinuti;
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

    public function getContenuto(): EContenuto|EEpisodio
    {
        return $this->contenuto;
    }

    public function setContenuto(EContenuto|EEpisodio $contenuto)
    {
        $this->contenuto = $contenuto;
    }

    public function getDataVisualizzazione(): DateTime
    {
        return $this->dataVisualizzazione;
    }

    public function setDataVisualizzazione(DateTime $dataVisualizzazione)
    {
        $this->dataVisualizzazione = $dataVisualizzazione;
    }

    public function getProgressioneMinuti(): int
    {
        return $this->progressioneMinuti;
    }

    public function setProgressioneMinuti(int $progressioneMinuti)
    {
        $this->progressioneMinuti = $progressioneMinuti;
    }
}
