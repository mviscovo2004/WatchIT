<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;

/**
 * Enum Privacy
 * 
 * Rappresenta la privacy della watchlist
 * 
 * @package Model
 * @author Marco Viscovo
 */
enum Privacy: string
{
    case pubblico = 'pubblico';
    case privato = 'privato';
    case solo_amici = 'solo_amici';
}

/**
 * Classe EWatchlist
 * 
 * Rappresenta una watchlist dell'utente
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
#[ORM\Table(name: 'watchlist')]
class EWatchlist
{
    /**
     * @var int Identificativo univoco della watchlist
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    /**
     * @var string Nome della watchlist
     */
    #[ORM\Column]
    protected string $nome;

    /**
     * @var string Descrizione della watchlist
     */
    #[ORM\Column(type: Types::TEXT)]
    protected string $descrizione;

    /**
     * @var Collection|array Contenuti salvati nella watchlist
     */
    #[ORM\ManyToMany(targetEntity: EContenuto::class)]
    #[ORM\JoinTable(name: 'watchlist_contenuti')]
    protected Collection|array $contenutiSalvati;

    /**
     * @var Privacy Visibilita della watchlist
     */
    #[ORM\Column(type: 'string', enumType: Privacy::class)]
    protected Privacy $visibilita;

    /**
     * @var EUtente Utente proprietario della watchlist
     */
    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EUtente $utente;

    /**
     * Costruttore della classe EWatchlist
     * 
     * @param int $id Identificativo univoco della watchlist
     * @param string $nome Nome della watchlist
     * @param string $descrizione Descrizione della watchlist
     * @param Collection|array $contenutiSalvati Contenuti salvati nella watchlist
     * @param Privacy $visibilita Visibilita della watchlist
     * @param EUtente $utente Utente proprietario della watchlist
     */
    public function __construct(int $id, string $nome, string $descrizione, Collection|array $contenutiSalvati, Privacy $visibilita, EUtente $utente)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->contenutiSalvati = $contenutiSalvati;
        $this->visibilita = $visibilita;
        $this->utente = $utente;
    }

    /**
     * Ottiene l'identificativo univoco della watchlist
     * 
     * @return int Identificativo univoco della watchlist
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Imposta l'identificativo univoco della watchlist
     * 
     * @param int $id Identificativo univoco della watchlist
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Ottiene l'utente proprietario della watchlist
     * 
     * @return EUtente Utente proprietario della watchlist
     */
    public function getUtente(): EUtente
    {
        return $this->utente;
    }

    /**
     * Imposta l'utente proprietario della watchlist
     * 
     * @param EUtente $utente Utente proprietario della watchlist
     */
    public function setUtente(EUtente $utente)
    {
        $this->utente = $utente;
    }

    /**
     * Ottiene il nome della watchlist
     * 
     * @return string Nome della watchlist
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Imposta il nome della watchlist
     * 
     * @param string $nome Nome della watchlist
     */
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    /**
     * Ottiene la descrizione della watchlist
     * 
     * @return string Descrizione della watchlist
     */
    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    /**
     * Imposta la descrizione della watchlist
     * 
     * @param string $descrizione Descrizione della watchlist
     */
    public function setDescrizione(string $descrizione)
    {
        $this->descrizione = $descrizione;
    }

    /**
     * Ottiene i contenuti salvati nella watchlist
     * 
     * @return Collection|array Contenuti salvati nella watchlist
     */
    public function getContenutiSalvati(): Collection|array
    {
        return $this->contenutiSalvati;
    }

    /**
     * Imposta i contenuti salvati nella watchlist
     * 
     * @param Collection|array $contenutiSalvati Contenuti salvati nella watchlist
     */
    public function setContenutiSalvati(Collection|array $contenutiSalvati)
    {
        $this->contenutiSalvati = $contenutiSalvati;
    }

    /**
     * Ottiene la visibilita della watchlist
     * 
     * @return Privacy Visibilita della watchlist
     */
    public function getVisibilita(): Privacy
    {
        return $this->visibilita;
    }

    /**
     * Imposta la visibilita della watchlist
     * 
     * @param Privacy $visibilita Visibilita della watchlist
     */
    public function setVisibilita(Privacy $visibilita)
    {
        $this->visibilita = $visibilita;
    }
}
