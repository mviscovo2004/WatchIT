<?php
enum Privacy
{
    case pubblico;
    case privato;
    case solo_amici;
}

class EWatchlist
{
    protected int $id;
    protected string $nome;
    protected string $descrizione;
    protected array $contenutiSalvati;
    protected Privacy $visibilita;
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
