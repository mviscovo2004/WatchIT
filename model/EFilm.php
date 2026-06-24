<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe EFilm
 * 
 * Rappresenta un film.
 * Eredita da EContenuto tutte le proprietà e i metodi. Aggiunge solo la durata del film.
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
#[ORM\Table(name: 'film')]
class EFilm extends EContenuto
{
    /**
     * @var int Durata del film in minuti
     */
    #[ORM\Column]
    protected int $durataMinuti;

    /**
     * Costruttore della classe EFilm.
     * 
     * @param int|null $tmdbId ID univoco del film su The Movie Database
     * @param int $id ID univoco del film nel database
     * @param string $titolo Titolo del film
     * @param string $anno Anno di uscita del film
     * @param string $trama Trama del film
     * @param float $valutazioneMedia Valutazione media del film
     * @param array $partecipazioni Partecipazioni del film
     * @param string $locandina Locandina del film
     * @param array $generi Generi del film
     * @param array $video Video del film
     * @param int $durataMinuti Durata del film in minuti
     */
    public function __construct(?int $tmdbId, int $id, string $titolo, string $anno, string $trama, float $valutazioneMedia, array $partecipazioni, string $locandina, array $generi, array $video = [], int $durataMinuti)
    {
        parent::__construct($tmdbId, $id, $titolo, $anno, $trama, $valutazioneMedia, $partecipazioni, $locandina, $generi, $video);
        $this->durataMinuti = $durataMinuti;
    }

    /**
     * Ottiene la durata del film in minuti.
     * 
     * @return int Durata del film in minuti
     */
    public function getDurata(): int
    {
        return $this->durataMinuti;
    }

    /**
     * Imposta la durata del film in minuti.
     * 
     * @param int $durataMinuti Durata del film in minuti
     */
    public function setDurata(int $durataMinuti)
    {
        $this->durataMinuti = $durataMinuti;
    }
}
