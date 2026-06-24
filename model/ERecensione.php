<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

/**
 * Classe ERecensione
 * 
 * Rappresenta una recensione lasciata da un utente a un contenuto.
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
#[ORM\Table(name: 'recensioni')]
class ERecensione
{
    /**
     * @var int ID univoco della recensione
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    /**
     * @var string Titolo della recensione
     */
    #[ORM\Column]
    protected string $titolo;

    /**
     * @var int Voto dato alla recensione
     */
    #[ORM\Column]
    protected int $voto;

    /**
     * @var string Descrizione della recensione
     */
    #[ORM\Column(type: Types::TEXT)]
    protected string $descrizione;

    /**
     * @var EContenuto Contenuto recensito
     */
    #[ORM\ManyToOne(targetEntity: EContenuto::class)]
    #[ORM\JoinColumn(nullable: true)]
    protected ?EContenuto $contenuto;

    /**
     * @var EEpisodio Episodio recensito
     */
    #[ORM\ManyToOne(targetEntity: EEpisodio::class)]
    #[ORM\JoinColumn(nullable: true)]
    protected ?EEpisodio $episodio;

    /**
     * @var EUtente Utente che ha lasciato la recensione
     */
    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EUtente $utente;

    /**
     * @var DateTime Data di pubblicazione della recensione
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTime $dataPubblicazione;

    /**
     * Costruttore della classe ERecensione.
     * 
     * @param int $id ID univoco della recensione
     * @param string $titolo Titolo della recensione
     * @param int $voto Voto dato alla recensione
     * @param string $descrizione Descrizione della recensione
     * @param EContenuto $contenuto Contenuto recensito
     * @param EEpisodio $episodio Episodio recensito
     * @param EUtente $utente Utente che ha lasciato la recensione
     * @param DateTime $dataPubblicazione Data di pubblicazione della recensione
     */
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

    /**
     * Ottiene l'ID univoco della recensione.
     * 
     * @return int ID univoco della recensione
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Imposta l'ID univoco della recensione.
     * 
     * @param int $id ID univoco della recensione
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Ottiene il titolo della recensione.
     * 
     * @return string Titolo della recensione
     */
    public function getTitolo(): string
    {
        return $this->titolo;
    }

    /**
     * Imposta il titolo della recensione.
     * 
     * @param string $titolo Titolo della recensione
     */
    public function setTitolo(string $titolo)
    {
        $this->titolo = $titolo;
    }

    /**
     * Ottiene il voto dato alla recensione.
     * 
     * @return int Voto dato alla recensione
     */
    public function getVoto(): int
    {
        return $this->voto;
    }

    /**
     * Imposta il voto dato alla recensione.
     * 
     * @param int $voto Voto dato alla recensione
     */
    public function setVoto(int $voto)
    {
        $this->voto = $voto;
    }

    /**
     * Ottiene la descrizione della recensione.
     * 
     * @return string Descrizione della recensione
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * Imposta la descrizione della recensione.
     * 
     * @param string $descrizione Descrizione della recensione
     */
    public function setDescrizione(string $descrizione)
    {
        $this->descrizione = $descrizione;
    }

    /**
     * Ottiene il contenuto recensito.
     * 
     * @return EContenuto Contenuto recensito
     */
    public function getContenuto(): ?EContenuto
    {
        return $this->contenuto;
    }

    /**
     * Imposta il contenuto recensito.
     * 
     * @param EContenuto $contenuto Contenuto recensito
     */
    public function setContenuto(?EContenuto $contenuto)
    {
        $this->contenuto = $contenuto;
    }

    /**
     * Ottiene l'episodio recensito.
     * 
     * @return EEpisodio Episodio recensito
     */
    public function getEpisodio(): ?EEpisodio
    {
        return $this->episodio;
    }

    /**
     * Imposta l'episodio recensito.
     * 
     * @param EEpisodio $episodio Episodio recensito
     */
    public function setEpisodio(?EEpisodio $episodio)
    {
        $this->episodio = $episodio;
    }

    /**
     * Ottiene l'utente che ha lasciato la recensione.
     * 
     * @return EUtente Utente che ha lasciato la recensione
     */
    public function getUtente(): EUtente
    {
        return $this->utente;
    }

    /**
     * Imposta l'utente che ha lasciato la recensione.
     * 
     * @param EUtente $utente Utente che ha lasciato la recensione
     */
    public function setUtente(EUtente $utente)
    {
        $this->utente = $utente;
    }

    /**
     * Ottiene la data di pubblicazione della recensione.
     * 
     * @return DateTime Data di pubblicazione della recensione
     */
    public function getDataPubblicazione(): DateTime
    {
        return $this->dataPubblicazione;
    }

    /**
     * Imposta la data di pubblicazione della recensione.
     * 
     * @param DateTime $dataPubblicazione Data di pubblicazione della recensione
     */
    public function setDataPubblicazione(DateTime $dataPubblicazione)
    {
        $this->dataPubblicazione = $dataPubblicazione;
    }
}
