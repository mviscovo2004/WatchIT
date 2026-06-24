<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe EPersona
 * 
 * Rappresenta una persona che partecipa a un film o serie TV.
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
#[ORM\Table(name: 'persone')]
class EPersona
{
    /**
     * @var int|null ID univoco della persona da TMDB
     */
    #[ORM\Column(unique: true, nullable: true)]
    protected ?int $tmdbId = null;

    /**
     * @var int ID univoco della persona nel database
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    /**
     * @var string Nome della persona
     */
    #[ORM\Column]
    protected string $nome;

    /**
     * @var string Cognome della persona
     */
    #[ORM\Column]
    protected string $cognome;

    /**
     * @var string Foto della persona
     */
    #[ORM\Column(nullable: true)]
    protected string $foto;

    /**
     * Costruttore della classe EPersona.
     * 
     * @param int|null $tmdbId ID univoco della persona da TMDB
     * @param int $id ID univoco della persona nel database
     * @param string $nome Nome della persona
     * @param string $cognome Cognome della persona
     * @param string $foto Foto della persona
     */
    public function __construct(?int $tmdbId, int $id, string $nome, string $cognome, string $foto)
    {
        $this->tmdbId = $tmdbId;
        $this->id = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->foto = $foto;
    }

    /**
     * Ottiene l'ID univoco della persona da TMDB.
     * 
     * @return int|null ID univoco della persona da TMDB
     */
    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    /**
     * Imposta l'ID univoco della persona da TMDB.
     * 
     * @param int|null $tmdbId ID univoco della persona da TMDB
     */
    public function setTmdbId(?int $tmdbId)
    {
        $this->tmdbId = $tmdbId;
    }

    /**
     * Ottiene il nome della persona.
     * 
     * @return string Nome della persona
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Imposta il nome della persona.
     * 
     * @param string $nome Nome della persona
     */
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    /**
     * Ottiene il cognome della persona.
     * 
     * @return string Cognome della persona
     */
    public function getCognome(): string
    {
        return $this->cognome;
    }

    /**
     * Imposta il cognome della persona.
     * 
     * @param string $cognome Cognome della persona
     */
    public function setCognome(string $cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * Ottiene la foto della persona.
     * 
     * @return string Foto della persona
     */
    public function getFoto(): string
    {
        return $this->foto;
    }

    /**
     * Imposta la foto della persona.
     * 
     * @param string $foto Foto della persona
     */
    public function setFoto(string $foto)
    {
        $this->foto = $foto;
    }

    /**
     * Ottiene l'ID univoco della persona nel database.
     * 
     * @return int ID univoco della persona nel database
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Imposta l'ID univoco della persona nel database.
     * 
     * @param int $id ID univoco della persona nel database
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}
