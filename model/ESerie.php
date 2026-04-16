<?php
enum Stato
{
    case in_corso;
    case conclusa;
    case cancellata;
}

class ESerie extends EContenuto
{
    protected int $numeroStagioni;
    protected array $episodi;
    protected Stato $stato;

    public function __construct(int $id, string $titolo, int $anno, string $trama, float $valutazioneMedia, array $partecipazioni, string $locandina, array $generi, int $numeroStagioni, array $episodi, Stato $stato)
    {
        parent::__construct($id, $titolo, $anno, $trama, $valutazioneMedia, $partecipazioni, $locandina, $generi);
        $this->numeroStagioni = $numeroStagioni;
        $this->episodi = $episodi;
        $this->stato = $stato;
    }

    public function getNumeroStagioni(): int
    {
        return $this->numeroStagioni;
    }

    public function setNumeroStagioni(int $numeroStagioni)
    {
        $this->numeroStagioni = $numeroStagioni;
    }

    public function getEpisodi(): array
    {
        return $this->episodi;
    }

    public function setEpisodi(array $episodi)
    {
        $this->episodi = $episodi;
    }

    public function getStato(): Stato
    {
        return $this->stato;
    }

    public function setStato(Stato $stato)
    {
        $this->stato = $stato;
    }
}
