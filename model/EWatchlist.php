<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

enum Privacy
{
    case pubblico;
    case privato;
    case solo_amici;
}

#[ORM\Entity]
#[ORM\Table(name: 'watchlist')]
class EWatchlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column]
    protected string $nome;

    #[ORM\Column(type: Types::TEXT)]
    protected string $descrizione;

    #[ORM\ManyToMany(targetEntity: EContenuto::class)]
    #[ORM\JoinTable(name: 'watchlist_contenuti')]
    protected array $contenutiSalvati;

    #[ORM\Column(type: 'string', enumType: Privacy::class)]
    protected Privacy $visibilita;

    #[ORM\ManyToOne(targetEntity: EUtente::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EUtente $utente;

    public function __construct(int $id, string $nome, string $descrizione, array $contenutiSalvati, Privacy $visibilita, EUtente $utente)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->contenutiSalvati = $contenutiSalvati;
        $this->visibilita = $visibilita;
        $this->utente = $utente;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    public function getDescrizione(): string
    {
        return $this->descrizione;
    }

    public function setDescrizione(string $descrizione)
    {
        $this->descrizione = $descrizione;
    }

    public function getContenutiSalvati(): array
    {
        return $this->contenutiSalvati;
    }

    public function setContenutiSalvati(array $contenutiSalvati)
    {
        $this->contenutiSalvati = $contenutiSalvati;
    }

    public function getVisibilita(): Privacy
    {
        return $this->visibilita;
    }

    public function setVisibilita(Privacy $visibilita)
    {
        $this->visibilita = $visibilita;
    }
}
