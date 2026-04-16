<?php
class EFilm extends EContenuto
{
    protected int $durataMinuti;

    public function __construct(int $id, string $titolo, int $anno, string $trama, float $valutazioneMedia, array $partecipazioni, string $locandina, array $generi, int $durataMinuti)
    {
        parent::__construct($id, $titolo, $anno, $trama, $valutazioneMedia, $partecipazioni, $locandina, $generi);
        $this->durataMinuti = $durataMinuti;
    }

    public function getDurata(): int
    {
        return $this->durataMinuti;
    }

    public function setDurata(int $durataMinuti)
    {
        $this->durataMinuti = $durataMinuti;
    }
}
