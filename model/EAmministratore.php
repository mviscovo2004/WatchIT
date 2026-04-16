<?php

class EAmministratore extends EUtente
{
    public function __construct(int $id, string $nome, string $cognome, string $foto, string $username, string $email, string $hashPassword)
    {

        parent::__construct($id, $nome, $cognome, $foto, $username, $email, $hashPassword);
    }
}
