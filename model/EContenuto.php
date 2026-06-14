<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;

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

    #[ORM\Column(unique: true, nullable: true)]
    protected ?int $tmdbId = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column]
    protected string $titolo;

    #[ORM\Column]
    protected string $anno;

    #[ORM\Column(type: Types::TEXT)]
    protected string $trama;

    #[ORM\Column(type: Types::FLOAT)]
    protected float $valutazioneMedia;

    #[ORM\OneToMany(targetEntity: EPartecipazione::class, mappedBy: 'contenuto')]
    protected Collection|array $partecipazioni;

    #[ORM\Column(nullable: true)]
    protected string $locandina;

    #[ORM\Column(type: Types::JSON)]
    protected array $generi;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    protected array $video = [];

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    protected ?float $valutazioneIniziale = null;



    public function __construct(?int $tmdbId, int $id, string $titolo, string $anno, string $trama, float $valutazioneMedia, array $partecipazioni, string $locandina, array $generi, array $video = [])
    {
        $this->tmdbId = $tmdbId;
        $this->id = $id;
        $this->titolo = $titolo;
        $this->anno = $anno;
        $this->trama = $trama;
        $this->valutazioneMedia = $valutazioneMedia;
        $this->partecipazioni = $partecipazioni;
        $this->locandina = $locandina;
        $this->generi = $generi;
        $this->video = $video;
    }

    public function getRegista(): string
    {
        foreach ($this->partecipazioni as $partecipazione) {
            if ($partecipazione->getRuolo() === 'Regista') {
                return $partecipazione->getPersona()->getNome() . ' ' . $partecipazione->getPersona()->getCognome();
            }
        }
        return 'Non disponibile';
    }

    public function getAttori(): string
    {
        $attori = [];
        foreach ($this->partecipazioni as $partecipazione) {
            if ($partecipazione->getRuolo() === 'Attore') {
                $attori[] = $partecipazione->getPersona()->getNome() . ' ' . $partecipazione->getPersona()->getCognome();
            }
        }
        return implode(', ', $attori);
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(?int $tmdbId)
    {
        $this->tmdbId = $tmdbId;
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

    public function getAnno(): string
    {
        return $this->anno;
    }

    public function setAnno(string $anno)
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

    public function getPartecipazioni(): Collection|array
    {
        return $this->partecipazioni;
    }

    public function setPartecipazioni(Collection|array $partecipazioni)
    {
        $this->partecipazioni = $partecipazioni;
    }

    public function getLocandina(): string
    {
        if ($this->locandina !== '' && strpos($this->locandina, '/') === 0) {
            return "https://image.tmdb.org/t/p/w500" . $this->locandina;
        }
        return $this->locandina;
    }


    public function setLocandina(string $locandina)
    {
        $this->locandina = $locandina;
    }

    public function getGeneri(): array
    {
        if (!empty($this->generi) && is_array($this->generi[0]) && isset($this->generi[0]['name'])) {
            return array_map(function ($genere) {
                return $genere['name'];
            }, $this->generi);
        }

        return $this->generi;
    }


    public function setGeneri(array $generi)
    {
        $this->generi = $generi;
    }

    public function getVideo(): array
    {
        return $this->video;
    }

    public function setVideo(array $video)
    {
        $this->video = $video;
    }

    public function getValutazioneIniziale(): ?float
    {
        return $this->valutazioneIniziale;
    }

    public function setValutazioneIniziale(?float $valutazioneIniziale)
    {
        $this->valutazioneIniziale = $valutazioneIniziale;
    }
}
