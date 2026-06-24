<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

/**
 * Classe EEpisodio
 * 
 * Rappresenta un episodio di una serie televisiva.
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
#[ORM\Table(name: 'episodi')]
class EEpisodio
{
    /**
     * @var int|null ID univoco dell'episodio su TMDB
     */
    #[ORM\Column(unique: true, nullable: true)]
    protected ?int $tmdbId = null;

    /**
     * @var int ID univoco dell'episodio nel database
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    /**
     * @var ESerie Serie di appartenenza
     */
    #[ORM\ManyToOne(targetEntity: ESerie::class, inversedBy: 'episodi')]
    #[ORM\JoinColumn(nullable: false)]
    protected ESerie $serie;

    /**
     * @var int Numero della stagione
     */
    #[ORM\Column]
    protected int $numeroStagione;

    /**
     * @var int Numero dell'episodio
     */
    #[ORM\Column]
    protected int $numeroEpisodio;

    /**
     * @var string Titolo dell'episodio
     */
    #[ORM\Column]
    protected string $titolo;

    /**
     * @var string Trama dell'episodio
     */
    #[ORM\Column(type: Types::TEXT)]
    protected string $trama;

    /**
     * @var int Durata dell'episodio in minuti
     */
    #[ORM\Column]
    protected int $durataMinuti;

    /**
     * @var float Valutazione media dell'episodio
     */
    #[ORM\Column(type: Types::FLOAT)]
    protected float $valutazioneMedia;

    /**
     * @var float|null Valutazione iniziale dell'episodio
     */
    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    protected ?float $valutazioneIniziale = null;

    /**
     * Costruttore della classe EEpisodio.
     * 
     * @param int|null $tmdbId ID univoco dell'episodio su The Movie Database
     * @param int $id ID univoco dell'episodio nel database
     * @param ESerie $serie Serie di appartenenza
     * @param int $numeroStagione Numero della stagione
     * @param int $numeroEpisodio Numero dell'episodio
     * @param string $titolo Titolo dell'episodio
     * @param string $trama Trama dell'episodio
     * @param int $durataMinuti Durata dell'episodio in minuti
     * @param float $valutazioneMedia Valutazione media dell'episodio
     */
    public function __construct(?int $tmdbId, int $id, ESerie $serie, int $numeroStagione, int $numeroEpisodio, string $titolo, string $trama, int $durataMinuti, float $valutazioneMedia)
    {
        $this->tmdbId = $tmdbId;
        $this->id = $id;
        $this->serie = $serie;
        $this->numeroStagione = $numeroStagione;
        $this->numeroEpisodio = $numeroEpisodio;
        $this->titolo = $titolo;
        $this->trama = $trama;
        $this->durataMinuti = $durataMinuti;
        $this->valutazioneMedia = $valutazioneMedia;
    }

    /**
     * Ottiene l'ID univoco dell'episodio su The Movie Database.
     * 
     * @return int|null ID univoco dell'episodio su The Movie Database
     */
    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    /**
     * Imposta l'ID univoco dell'episodio su The Movie Database.
     * 
     * @param int|null $tmdbId ID univoco dell'episodio su The Movie Database
     */
    public function setTmdbId(?int $tmdbId)
    {
        $this->tmdbId = $tmdbId;
    }

    /**
     * Ottiene l'ID univoco dell'episodio nel database.
     * 
     * @return int ID univoco dell'episodio nel database
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Imposta l'ID univoco dell'episodio nel database.
     * 
     * @param int $id ID univoco dell'episodio nel database
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Ottiene la serie di appartenenza dell'episodio.
     * 
     * @return ESerie Serie di appartenenza
     */
    /**
     * Ottiene la serie di appartenenza dell'episodio.
     * 
     * @return ESerie Serie di appartenenza
     */
    public function getSerie(): ESerie
    {
        return $this->serie;
    }

    /**
     * Imposta la serie di appartenenza dell'episodio.
     * 
     * @param ESerie $serie Serie di appartenenza
     */
    public function setSerie(ESerie $serie)
    {
        $this->serie = $serie;
    }

    /**
     * Ottiene il numero della stagione.
     * 
     * @return int Numero della stagione
     */
    public function getNumeroStagione(): int
    {
        return $this->numeroStagione;
    }

    /**
     * Imposta il numero della stagione.
     * 
     * @param int $numeroStagione Numero della stagione
     */
    public function setNumeroStagione(int $numeroStagione)
    {
        $this->numeroStagione = $numeroStagione;
    }


    /**
     * Ottiene il numero dell'episodio.
     * 
     * @return int Numero dell'episodio
     */
    public function getNumeroEpisodio(): int
    {
        return $this->numeroEpisodio;
    }

    /**
     * Imposta il numero dell'episodio.
     * 
     * @param int $numeroEpisodio Numero dell'episodio
     */
    public function setNumeroEpisodio(int $numeroEpisodio)
    {
        $this->numeroEpisodio = $numeroEpisodio;
    }

    /**
     * Ottiene il titolo dell'episodio.
     * 
     * @return string Titolo dell'episodio
     */
    public function getTitolo(): string
    {
        return $this->titolo;
    }

    /**
     * Imposta il titolo dell'episodio.
     * 
     * @param string $titolo Titolo dell'episodio
     */
    public function setTitolo(string $titolo)
    {
        $this->titolo = $titolo;
    }

    /**
     * Ottiene la trama dell'episodio.
     * 
     * @return string Trama dell'episodio
     */
    public function getTrama(): string
    {
        return $this->trama;
    }

    /**
     * Imposta la trama dell'episodio.
     * 
     * @param string $trama Trama dell'episodio
     */
    public function setTrama(string $trama)
    {
        $this->trama = $trama;
    }

    /**
     * Ottiene la durata dell'episodio in minuti.
     * 
     * @return int Durata dell'episodio in minuti
     */
    public function getDurata(): int
    {
        return $this->durataMinuti;
    }

    /**
     * Imposta la durata dell'episodio in minuti.
     * 
     * @param int $durataMinuti Durata dell'episodio in minuti
     */
    public function setDurata(int $durataMinuti)
    {
        $this->durataMinuti = $durataMinuti;
    }

    /**
     * Ottiene la valutazione media dell'episodio.
     * 
     * @return float Valutazione media dell'episodio
     */
    public function getValutazioneMedia(): float
    {
        return $this->valutazioneMedia;
    }

    /**
     * Imposta la valutazione media dell'episodio.
     * 
     * @param float $valutazioneMedia Valutazione media dell'episodio
     */
    public function setValutazioneMedia(float $valutazioneMedia)
    {
        $this->valutazioneMedia = $valutazioneMedia;
    }

    /**
     * Ottiene la locandina della serie di appartenenza.
     * 
     * @return string Locandina della serie di appartenenza
     */
    public function getLocandina(): string
    {
        return $this->serie->getLocandina();
    }

    /**
     * Ottiene l'anno di uscita della serie di appartenenza.
     * 
     * @return string Anno di uscita della serie di appartenenza
     */
    public function getAnno(): string
    {
        return $this->serie->getAnno();
    }

    /**
     * Ottiene il regista della serie di appartenenza.
     * 
     * @return string Regista della serie di appartenenza
     */
    public function getRegista(): string
    {
        return $this->serie->getRegista();
    }

    /**
     * Ottiene i generi della serie di appartenenza.
     * 
     * @return array Generi della serie di appartenenza
     */
    public function getGeneri(): array
    {
        return $this->serie->getGeneri();
    }

    /**
     * Ottiene la valutazione iniziale dell'episodio.
     * 
     * @return float|null Valutazione iniziale dell'episodio
     */
    public function getValutazioneIniziale(): ?float
    {
        return $this->valutazioneIniziale;
    }

    /**
     * Imposta la valutazione iniziale dell'episodio.
     * 
     * @param float|null $valutazioneIniziale Valutazione iniziale dell'episodio
     */
    public function setValutazioneIniziale(?float $valutazioneIniziale)
    {
        $this->valutazioneIniziale = $valutazioneIniziale;
    }
}
