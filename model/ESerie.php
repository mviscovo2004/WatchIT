<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/** 
 * Enum Stato 
 * 
 * Rappresenta lo stato in cui si trova una serie TV.
 * 
 * @package Model
 * @author Marco Viscovo
 */
enum Stato: string
{
    case in_corso = 'in_corso';
    case conclusa = 'conclusa';
    case cancellata = 'cancellata';
}

/**
 * ESerie
 * 
 * Classe che rappresenta una serie TV.
 * Eredita da EContenuto tutte le proprietà e definisce una lista di episodi e lo stato di avanzamento della serie.
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
#[ORM\Table(name: 'serie')]
class ESerie extends EContenuto
{
    /**
     * @var int Numero di stagioni della serie
     */
    #[ORM\Column]
    protected int $numeroStagioni;

    /**
     * @var Collection|array Lista di episodi della serie
     */
    #[ORM\OneToMany(targetEntity: EEpisodio::class, mappedBy: 'serie')]
    protected Collection|array $episodi;

    /**
     * @var Stato Stato in cui si trova la serie
     */
    #[ORM\Column(type: 'string', enumType: Stato::class)]
    protected Stato $stato;

    /**
     * Costruttore della classe ESerie.
     * 
     * @param int|null $tmdbId ID univoco della serie da TMDB
     * @param int $id ID univoco della serie nel database
     * @param string $titolo Titolo della serie
     * @param string $anno Anno di uscita della serie
     * @param string $trama Trama della serie
     * @param float $valutazioneMedia Valutazione media della serie
     * @param array $partecipazioni Lista di partecipazioni della serie
     * @param string $locandina Locandina della serie
     * @param array $generi Lista di generi della serie
     * @param array $video Lista di video della serie
     * @param int $numeroStagioni Numero di stagioni della serie
     * @param Collection|array $episodi Lista di episodi della serie
     * @param Stato $stato Stato in cui si trova la serie
     */
    public function __construct(?int $tmdbId, int $id, string $titolo, string $anno, string $trama, float $valutazioneMedia, array $partecipazioni, string $locandina, array $generi, array $video = [], int $numeroStagioni, Collection|array $episodi, Stato $stato)
    {
        parent::__construct($tmdbId, $id, $titolo, $anno, $trama, $valutazioneMedia, $partecipazioni, $locandina, $generi, $video);
        $this->numeroStagioni = $numeroStagioni;
        $this->episodi = $episodi;
        $this->stato = $stato;
    }

    /**
     * Ottiene il numero di stagioni della serie.
     * 
     * @return int Numero di stagioni della serie
     */
    public function getNumeroStagioni(): int
    {
        return $this->numeroStagioni;
    }

    /**
     * Imposta il numero di stagioni della serie.
     * 
     * @param int $numeroStagioni Numero di stagioni della serie
     */
    public function setNumeroStagioni(int $numeroStagioni)
    {
        $this->numeroStagioni = $numeroStagioni;
    }

    /**
     * Ottiene la lista di episodi della serie.
     * 
     * @return Collection|array Lista di episodi della serie
     */
    public function getEpisodi(): Collection|array
    {
        return $this->episodi;
    }

    /**
     * Imposta la lista di episodi della serie.
     * 
     * @param Collection|array $episodi Lista di episodi della serie
     */
    public function setEpisodi(Collection|array $episodi)
    {
        $this->episodi = $episodi;
    }

    /**
     * Ottiene lo stato in cui si trova la serie.
     * 
     * @return Stato Stato in cui si trova la serie
     */
    public function getStato(): Stato
    {
        return $this->stato;
    }

    /**
     * Imposta lo stato in cui si trova la serie.
     * 
     * @param Stato $stato Stato in cui si trova la serie
     */
    public function setStato(Stato $stato)
    {
        $this->stato = $stato;
    }

    /**
     * Aggiunge un episodio alla serie.
     * 
     * @param EEpisodio $episodio Episodio da aggiungere
     */
    public function addEpisodio(EEpisodio $episodio)
    {
        $this->episodi[] = $episodio;
    }

    /**
     * Rimuove un episodio dalla serie.
     * 
     * @param EEpisodio $episodio Episodio da rimuovere
     */
    public function removeEpisodio(EEpisodio $episodio)
    {
        $this->episodi = array_values(array_filter($this->episodi, fn($e) => $e->getId() !== $episodio->getId()));
    }
}
