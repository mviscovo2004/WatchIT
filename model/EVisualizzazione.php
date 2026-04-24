<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'visualizzazioni')]
class EVisualizzazione
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EUtente $utente;

    #[ORM\ManyToOne(targetEntity: EContenuto::class)]
    #[ORM\JoinColumn(nullable: true)]
    protected ?EContenuto $contenuto;

    #[ORM\ManyToOne(targetEntity: EEpisodio::class)]
    #[ORM\JoinColumn(nullable: true)]
    protected ?EEpisodio $episodio;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTime $dataVisualizzazione;

    #[ORM\Column]
    protected int $progressioneMinuti;


    public function __construct(int $id, EUtente $utente, ?EContenuto $contenuto, ?EEpisodio $episodio, DateTime $dataVisualizzazione, int $progressioneMinuti)
    {
        $this->id = $id;
        $this->utente = $utente;
        $this->contenuto = $contenuto;
        $this->episodio = $episodio;
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
