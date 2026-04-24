<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'recensioni')]
class ERecensione
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column]
    protected string $titolo;

    #[ORM\Column]
    protected int $voto;

    #[ORM\Column(type: Types::TEXT)]
    protected string $descrizione;

    #[ORM\ManyToOne(targetEntity: EContenuto::class)]
    #[ORM\JoinColumn(nullable: true)]
    protected ?EContenuto $contenuto;

    #[ORM\ManyToOne(targetEntity: EEpisodio::class)]
    #[ORM\JoinColumn(nullable: true)]
    protected ?EEpisodio $episodio;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EUtente $utente;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTime $dataPubblicazione;

    public function __construct(int $id, string $titolo, int $voto, string $descrizione, ?EContenuto $contenuto, ?EEpisodio $episodio, EUtente $utente, DateTime $dataPubblicazione)
    {
        $this->id = $id;
        $this->titolo = $titolo;
        $this->voto = $voto;
        $this->descrizione = $descrizione;
        $this->contenuto = $contenuto;
        $this->episodio = $episodio;
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

    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    public function setDescrizione(string $descrizione)
    {
        $this->descrizione = $descrizione;
    }

    public function getContenuto(): ?EContenuto
    {
        return $this->contenuto;
    }

    public function setContenuto(?EContenuto $contenuto)
    {
        $this->contenuto = $contenuto;
    }

    public function getEpisodio(): ?EEpisodio
    {
        return $this->episodio;
    }

    public function setEpisodio(?EEpisodio $episodio)
    {
        $this->episodio = $episodio;
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
