<?php

use Doctrine\ORM\Mapping as ORM;

/** 
 * Classe EAmministratore
 * 
 * Rappresenta un utente coon privilegi amministrativi all'interno del sistema.
 * Eredita dalla classe EUtente tutte le sue proprietà e metodi. 
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
class EAmministratore extends EUtente
{
    /**
     * Costruttore della classe EAmministratore.
     * 
     * @param int $id Identificativo univoco dell'amministratore
     * @param string $nome Nome dell'amministratore
     * @param string $cognome Cognome dell'amministratore
     * @param string $foto Foto del profilo dell'amministratore
     * @param string $username Username univoco per l'autenticazione dell'amministratore
     * @param string $email Email per l'autenticazione e il recupero password dell'amministratore
     * @param string $hashPassword Hash della password dell'amministratore
     */
    public function __construct(int $id, string $nome, string $cognome, string $foto, string $username, string $email, string $hashPassword)
    {

        parent::__construct($id, $nome, $cognome, $foto, $username, $email, $hashPassword);
    }
}
