<?php
class EUtente
{
    protected int $id;
    protected string $nome;
    protected string $cognome;
    protected string $foto;
    protected string $username;
    protected string $email;
    protected string $hashPassword;
    protected array $seguaci;
    protected array $seguiti;


    public function __construct(int $id, string $nome, string $cognome, string $foto, string $username, string $email, string $hashPassword)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->foto = $foto;
        $this->username = $username;
        $this->email = $email;
        $this->hashPassword = $hashPassword;
        $this->seguaci = [];
        $this->seguiti = [];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getHashPassword(): string
    {
        return $this->hashPassword;
    }

    public function setHashPassword(string $hashPassword)
    {
        $this->hashPassword = $hashPassword;
    }

    public function getSeguaci(): array
    {
        return $this->seguaci;
    }

    public function setSeguaci(array $seguaci)
    {
        $this->seguaci = $seguaci;
    }

    public function getSeguiti(): array
    {
        return $this->seguiti;
    }

    public function setSeguiti(array $seguiti)
    {
        $this->seguiti = $seguiti;
    }
}
