<?php
class ERecensione
{
    protected int $id;
    protected string $titolo;
    protected int $voto;
    protected string $descrizione;
    protected EContenuto|EEpisodio $contenuto;
    protected EUtente $utente;
    protected DateTime $dataPubblicazione;

    public function __construct(int $id, string $titolo, int $voto, string $descrizione, EContenuto|EEpisodio $contenuto, EUtente $utente, DateTime $dataPubblicazione)
    {
        $this->id = $id;
        $this->titolo = $titolo;
        $this->voto = $voto;
        $this->descrizione = $descrizione;
        $this->contenuto = $contenuto;
        $this->utente = $utente;
        $this->dataPubblicazione = $dataPubblicazione;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getTitolo(): string
    {
        return $this->titolo;
    }

    public function setTitolo(string $titolo)
    {
        $this->titolo = $titolo;
    }

    public function getVoto(): int
    {
        return $this->voto;
    }

    public function setVoto(int $voto)
    {
        $this->voto = $voto;
    }

    public function getdescrizione(): string
    {
        return $this->descrizione;
    }

    public function setdescrizione(string $descrizione)
    {
        $this->descrizione = $descrizione;
    }

    public function getContenuto(): EContenuto|EEpisodio
    {
        return $this->contenuto;
    }

    public function setContenuto(EContenuto|EEpisodio $contenuto)
    {
        $this->contenuto = $contenuto;
    }

    public function getUtente(): EUtente
    {
        return $this->utente;
    }

    public function setUtente(EUtente $utente)
    {
        $this->utente = $utente;
    }

    public function getDataPubblicazione(): DateTime
    {
        return $this->dataPubblicazione;
    }

    public function setDataPubblicazione(DateTime $dataPubblicazione)
    {
        $this->dataPubblicazione = $dataPubblicazione;
    }
}
