<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'persone')]
class EPersona
{

    #[ORM\Column(unique: true, nullable: true)]
    protected ?int $tmdbId = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column]
    protected string $nome;

    #[ORM\Column]
    protected string $cognome;

    #[ORM\Column(nullable: true)]
    protected string $foto;


    public function __construct(?int $tmdbId, int $id, string $nome, string $cognome, string $foto)
    {
        $this->tmdbId = $tmdbId;
        $this->id = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->foto = $foto;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(?int $tmdbId)
    {
        $this->tmdbId = $tmdbId;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    public function getCognome(): string
    {
        return $this->cognome;
    }

    public function setCognome(string $cognome)
    {
        $this->cognome = $cognome;
    }

    public function getFoto(): string
    {
        return $this->foto;
    }

    public function setFoto(string $foto)
    {
        $this->foto = $foto;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}
