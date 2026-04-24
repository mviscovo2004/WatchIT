<?php

use Doctrine\ORM\Mapping as ORM;

enum Stato
{
    case in_corso;
    case conclusa;
    case cancellata;
}

#[ORM\Entity]
#[ORM\Table(name: 'serie')]
class ESerie extends EContenuto
{
    #[ORM\Column]
    protected int $numeroStagioni;

    #[ORM\OneToMany(targetEntity: EEpisodio::class, mappedBy: 'serie')]
    protected array $episodi;

    #[ORM\Column(type: 'string', enumType: Stato::class)]
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

    public function addEpisodio(EEpisodio $episodio)
    {
        $this->episodi[] = $episodio;
    }

    public function removeEpisodio(EEpisodio $episodio)
    {
        $this->episodi = array_values(array_filter($this->episodi, fn($e) => $e->getId() !== $episodio->getId()));
    }
}
