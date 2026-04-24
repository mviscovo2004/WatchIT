<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

enum Genere
{
    case azione;
    case commedia;
    case drammatico;
    case horror;
    case fantascienza;
    case fantasy;
    case thriller;
    case giallo;
    case romantico;
    case storico;
    case biografico;
    case musicale;
    case animazione;
    case documentario;
    case cortometraggio;
}

#[ORM\Entity]
#[ORM\Table(name: 'contenuti')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'tipo_contenuto', type: 'string')]
#[ORM\DiscriminatorMap(['film' => EFilm::class, 'serie' => ESerie::class])]
class EContenuto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column]
    protected string $titolo;

    #[ORM\Column]
    protected int $anno;

    #[ORM\Column(type: Types::TEXT)]
    protected string $trama;

    #[ORM\Column(type: Types::FLOAT)]
    protected float $valutazioneMedia;

    #[ORM\OneToMany(targetEntity: EPartecipazione::class, mappedBy: 'contenuto')]
    protected array $partecipazioni;

    #[ORM\Column(nullable: true)]
    protected string $locandina;

    #[ORM\Column(type: Types::JSON)]
    protected array $generi;


    public function __construct(int $id, string $titolo, int $anno, string $trama, float $valutazioneMedia, array $partecipazioni, string $locandina, array $generi)
    {
        $this->id = $id;
        $this->titolo = $titolo;
        $this->anno = $anno;
        $this->trama = $trama;
        $this->valutazioneMedia = $valutazioneMedia;
        $this->partecipazioni = $partecipazioni;
        $this->locandina = $locandina;
        $this->generi = $generi;
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

    public function getAnno(): int
    {
        return $this->anno;
    }

    public function setAnno(int $anno)
    {
        $this->anno = $anno;
    }

    public function getTrama(): string
    {
        return $this->trama;
    }

    public function setTrama(string $trama)
    {
        $this->trama = $trama;
    }

    public function getValutazioneMedia(): float
    {
        return $this->valutazioneMedia;
    }

    public function setValutazioneMedia(float $valutazioneMedia)
    {
        $this->valutazioneMedia = $valutazioneMedia;
    }

    public function getPartecipazioni(): array
    {
        return $this->partecipazioni;
    }

    public function setPartecipazioni(array $partecipazioni)
    {
        $this->partecipazioni = $partecipazioni;
    }

    public function getLocandina(): string
    {
        return $this->locandina;
    }

    public function setLocandina(string $locandina)
    {
        $this->locandina = $locandina;
    }

    public function getGeneri(): array
    {
        return $this->generi;
    }

    public function setGeneri(array $generi)
    {
        $this->generi = $generi;
    }
}
