<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;

/**
 * Enum Genere
 * 
 * Rappresenta i generi dei contenuti
 * 
 * @package Model
 * @author Marco Viscovo
 */
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

/**
 * Classe EContenuto
 * 
 * Rappresenta un contenuto di tipo film o serie all'interno del sistema.
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
#[ORM\Table(name: 'contenuti')]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'tipo_contenuto', type: 'string')]
#[ORM\DiscriminatorMap(['film' => EFilm::class, 'serie' => ESerie::class])]
class EContenuto
{

    /**
     * @var int|null Identificativo univoco del contenuto
     */
    #[ORM\Column(unique: true, nullable: true)]
    protected ?int $tmdbId = null;

    /**
     * @var int Identificativo univoco del contenuto
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    /**
     * @var string Titolo del contenuto
     */
    #[ORM\Column]
    protected string $titolo;

    /**
     * @var string Anno di uscita del contenuto
     */
    #[ORM\Column]
    protected string $anno;

    /**
     * @var string Trama del contenuto
     */
    #[ORM\Column(type: Types::TEXT)]
    protected string $trama;

    /**
     * @var float Valutazione media del contenuto
     */
    #[ORM\Column(type: Types::FLOAT)]
    protected float $valutazioneMedia;

    /**
     * @var Collection|array Partecipazioni del contenuto
     */
    #[ORM\OneToMany(targetEntity: EPartecipazione::class, mappedBy: 'contenuto')]
    protected Collection|array $partecipazioni;

    /**
     * @var string Locandina del contenuto
     */
    #[ORM\Column(nullable: true)]
    protected string $locandina;

    /**
     * @var array Generi del contenuto
     */
    #[ORM\Column(type: Types::JSON)]
    protected array $generi;

    /**
     * @var array Trailer e clip del contenuto
     */
    #[ORM\Column(type: Types::JSON, nullable: true)]
    protected array $video = [];

    /**
     * @var float Valutazione iniziale del contenuto
     */
    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    protected ?float $valutazioneIniziale = null;

    /**
     * Costruttore della classe EContenuto.
     * 
     * @param int|null $tmdbId Identificativo univoco del contenuto
     * @param int $id Identificativo univoco del contenuto
     * @param string $titolo Titolo del contenuto
     * @param string $anno Anno di uscita del contenuto
     * @param string $trama Trama del contenuto
     * @param float $valutazioneMedia Valutazione media del contenuto
     * @param Collection|array $partecipazioni Partecipazioni del contenuto
     * @param string $locandina Locandina del contenuto
     * @param array $generi Generi del contenuto
     * @param array $video Trailer e clip del contenuto
     */
    public function __construct(?int $tmdbId, int $id, string $titolo, string $anno, string $trama, float $valutazioneMedia, Collection|array $partecipazioni, string $locandina, array $generi, array $video = [])
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

    /**
     * Ottiene il regista del contenuto.
     * 
     * @return string Regista del contenuto
     */
    public function getRegista(): string
    {
        foreach ($this->partecipazioni as $partecipazione) {
            if ($partecipazione->getRuolo() === 'Regista') {
                return $partecipazione->getPersona()->getNome() . ' ' . $partecipazione->getPersona()->getCognome();
            }
        }
        return 'Non disponibile';
    }

    /**
     * Ottiene gli attori del contenuto.
     * 
     * @return string Attori del contenuto
     */
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

    /**
     * Ottiene l'identificativo univoco del contenuto da TMDB.
     * 
     * @return int|null Identificativo univoco del contenuto da TMDB
     */
    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    /**
     * Imposta l'identificativo univoco del contenuto da TMDB.
     * 
     * @param int|null $tmdbId Identificativo univoco del contenuto da TMDB
     */
    public function setTmdbId(?int $tmdbId)
    {
        $this->tmdbId = $tmdbId;
    }

    /**
     * Ottiene l'identificativo univoco del contenuto.
     * 
     * @return int Identificativo univoco del contenuto
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Imposta l'identificativo univoco del contenuto.
     * 
     * @param int $id Identificativo univoco del contenuto
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Ottiene il titolo del contenuto.
     * 
     * @return string Titolo del contenuto
     */
    public function getTitolo(): string
    {
        return $this->titolo;
    }

    /**
     * Imposta il titolo del contenuto.
     * 
     * @param string $titolo Titolo del contenuto
     */
    public function setTitolo(string $titolo)
    {
        $this->titolo = $titolo;
    }

    /**
     * Ottiene l'anno di uscita del contenuto.
     * 
     * @return string Anno di uscita del contenuto
     */
    public function getAnno(): string
    {
        return $this->anno;
    }

    /**
     * Imposta l'anno di uscita del contenuto.
     * 
     * @param string $anno Anno di uscita del contenuto
     */
    public function setAnno(string $anno)
    {
        $this->anno = $anno;
    }

    /**
     * Ottiene la trama del contenuto.
     * 
     * @return string Trama del contenuto
     */
    public function getTrama(): string
    {
        return $this->trama;
    }

    /**
     * Imposta la trama del contenuto.
     * 
     * @param string $trama Trama del contenuto
     */
    public function setTrama(string $trama)
    {
        $this->trama = $trama;
    }

    /**
     * Ottiene la valutazione media del contenuto.
     * 
     * @return float Valutazione media del contenuto
     */
    public function getValutazioneMedia(): float
    {
        return $this->valutazioneMedia;
    }

    /**
     * Imposta la valutazione media del contenuto.
     * 
     * @param float $valutazioneMedia Valutazione media del contenuto
     */
    public function setValutazioneMedia(float $valutazioneMedia)
    {
        $this->valutazioneMedia = $valutazioneMedia;
    }

    /**
     * Ottiene le partecipazioni del contenuto.
     * 
     * @return Collection|array Partecipazioni del contenuto
     */
    public function getPartecipazioni(): Collection|array
    {
        return $this->partecipazioni;
    }

    /**
     * Imposta le partecipazioni del contenuto.
     * 
     * @param Collection|array $partecipazioni Partecipazioni del contenuto
     */
    public function setPartecipazioni(Collection|array $partecipazioni)
    {
        $this->partecipazioni = $partecipazioni;
    }

    /**
     * Ottiene il path della locandina del contenuto.
     * 
     * @return string Path della locandina del contenuto
     */
    public function getLocandina(): string
    {
        if ($this->locandina !== '' && strpos($this->locandina, '/') === 0) {
            return "https://image.tmdb.org/t/p/w500" . $this->locandina;
        }
        return $this->locandina;
    }

    /**
     * Imposta il path della locandina del contenuto.
     * 
     * @param string $locandina Path della locandina del contenuto
     */
    public function setLocandina(string $locandina)
    {
        $this->locandina = $locandina;
    }

    /**
     * Ottiene i generi del contenuto.
     * 
     * @return array Generi del contenuto
     */
    public function getGeneri(): array
    {
        if (!empty($this->generi) && is_array($this->generi[0]) && isset($this->generi[0]['name'])) {
            return array_map(function ($genere) {
                return $genere['name'];
            }, $this->generi);
        }

        return $this->generi;
    }

    /**
     * Imposta i generi del contenuto.
     * 
     * @param array $generi Generi del contenuto
     */
    public function setGeneri(array $generi)
    {
        $this->generi = $generi;
    }

    /**
     * Ottiene i trailer e le clip del contenuto.
     * 
     * @return array Trailer e clip del contenuto
     */
    public function getVideo(): array
    {
        return $this->video;
    }

    /**
     * Imposta i trailer e le clip del contenuto.
     * 
     * @param array $video Trailer e clip del contenuto
     */
    public function setVideo(array $video)
    {
        $this->video = $video;
    }

    /**
     * Ottiene la valutazione media iniziale del contenuto (inserita dall'admin).
     * 
     * @return float|null Valutazione iniziale del contenuto
     */
    public function getValutazioneIniziale(): ?float
    {
        return $this->valutazioneIniziale;
    }

    /**
     * Imposta la valutazione media iniziale del contenuto (inserita dall'admin).
     * 
     * @param float|null $valutazioneIniziale Valutazione iniziale del contenuto
     */
    public function setValutazioneIniziale(?float $valutazioneIniziale)
    {
        $this->valutazioneIniziale = $valutazioneIniziale;
    }
}
