<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Classe EUtente
 *
 * Rappresenta l'entità Utente registrato nel sistema. 
 * Gestisce l'ereditarietà a singola tabella (Single Table Inheritance) discriminando tra utente standard e admin.
 *
 * @package model
 * @author WatchIT Team
 */
#[ORM\Entity]
#[ORM\Table(name: 'utenti')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'tipo', type: 'string')]
#[ORM\DiscriminatorMap(['utente' => EUtente::class, 'admin' => EAmministratore::class])]
class EUtente
{
    /**
     * @var int ID univoco dell'utente
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    /**
     * @var string Nome dell'utente
     */
    #[ORM\Column]
    protected string $nome;

    /**
     * @var string Cognome dell'utente
     */
    #[ORM\Column]
    protected string $cognome;

    /**
     * @var string|null URL del profilo social o percorso file immagine profilo
     */
    #[ORM\Column(nullable: true)]
    protected ?string $foto;

    /**
     * @var string Nome utente univoco
     */
    #[ORM\Column(unique: true)]
    protected string $username;

    /**
     * @var string Email univoca dell'utente
     */
    #[ORM\Column(unique: true)]
    protected string $email;

    /**
     * @var string Password hash dell'utente
     */
    #[ORM\Column]
    protected string $hashPassword;

    /**
     * @var Collection|array Lista degli utenti che seguono questo utente
     */
    #[ORM\ManyToMany(targetEntity: EUtente::class, mappedBy: 'seguiti')]
    protected Collection|array $seguaci;

    /**
     * @var Collection|array Lista degli utenti seguiti da questo utente
     */
    #[ORM\ManyToMany(targetEntity: EUtente::class, inversedBy: 'seguaci')]
    #[ORM\JoinTable(name: 'utenti_seguiti')]
    protected Collection|array $seguiti;

    /**
     * @var string|null Token univoco per il recupero password
     */
    #[ORM\Column(nullable: true)]
    protected ?string $tokenRecupero;

    /**
     * @var DateTime|null Data e ora di scadenza del token di recupero
     */
    #[ORM\Column(nullable: true)]
    protected ?DateTime $dataScadenzaToken;

    /**
     * Costruttore dell'entità EUtente
     *
     * @param int $id ID univoco dell'utente
     * @param string $nome Nome dell'utente
     * @param string $cognome Cognome dell'utente
     * @param string $foto URL del profilo social o percorso file immagine profilo
     * @param string $username Nome utente univoco
     * @param string $email Email univoca dell'utente
     * @param string $hashPassword Password hash dell'utente
     */
    public function __construct(int $id, string $nome, string $cognome, ?string $foto, string $username, string $email, string $hashPassword)
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
        $this->tokenRecupero = null;
        $this->dataScadenzaToken = null;
    }

    /**
     * Ottiene l'ID dell'utente
     * 
     * @return int ID dell'utente
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Imposta l'ID dell'utente
     * 
     * @param int $id ID dell'utente
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Ottiene il nome dell'utente
     * 
     * @return string Nome dell'utente
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Imposta il nome dell'utente
     * 
     * @param string $nome Nome dell'utente
     */
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    /**
     * Ottiene il cognome dell'utente
     * 
     * @return string Cognome dell'utente
     */
    public function getCognome(): string
    {
        return $this->cognome;
    }

    /**
     * Imposta il cognome dell'utente
     * 
     * @param string $cognome Cognome dell'utente
     */
    public function setCognome(string $cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * Ottiene l'URL del profilo social o il percorso del file immagine del profilo dell'utente
     * 
     * @return string|null URL del profilo social o percorso del file immagine del profilo dell'utente
     */
    public function getFoto(): ?string
    {
        return $this->foto;
    }

    /**
     * Imposta l'URL del profilo social o il percorso del file immagine del profilo dell'utente
     * 
     * @param string|null $foto URL del profilo social o percorso del file immagine del profilo dell'utente
     */
    public function setFoto(?string $foto)
    {
        $this->foto = $foto;
    }

    /**
     * Ottiene il nome utente dell'utente
     * 
     * @return string Nome utente dell'utente
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Imposta il nome utente dell'utente
     * 
     * @param string $username Nome utente dell'utente
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * Ottiene l'indirizzo email dell'utente
     * 
     * @return string Indirizzo email dell'utente
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Imposta l'indirizzo email dell'utente
     * 
     * @param string $email Indirizzo email dell'utente
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Ottiene l'hash della password dell'utente
     * 
     * @return string Hash della password dell'utente
     */
    public function getHashPassword(): string
    {
        return $this->hashPassword;
    }

    /**
     * Imposta l'hash della password dell'utente
     * 
     * @param string $hashPassword Hash della password dell'utente
     */
    public function setHashPassword(string $hashPassword)
    {
        $this->hashPassword = $hashPassword;
    }

    /**
     * Ottiene gli utenti che seguono questo utente
     * 
     * @return Collection|array Utenti che seguono questo utente
     */
    public function getSeguaci(): Collection|array
    {
        return $this->seguaci;
    }

    /**
     * Imposta gli utenti che seguono questo utente
     * 
     * @param Collection|array $seguaci Utenti che seguono questo utente
     */
    public function setSeguaci(Collection|array $seguaci)
    {
        $this->seguaci = $seguaci;
    }

    /**
     * Ottiene gli utenti seguiti da questo utente
     * 
     * @return Collection|array Utenti seguiti da questo utente
     */
    public function getSeguiti(): Collection|array
    {
        return $this->seguiti;
    }

    /**
     * Imposta gli utenti seguiti da questo utente
     * 
     * @param Collection|array $seguiti Utenti seguiti da questo utente
     */
    public function setSeguiti(Collection|array $seguiti)
    {
        $this->seguiti = $seguiti;
    }

    /**
     * Ottiene il token di recupero password dell'utente
     * 
     * @return string|null Token di recupero password dell'utente
     */
    public function getTokenRecupero(): ?string
    {
        return $this->tokenRecupero;
    }

    /**
     * Imposta il token di recupero password dell'utente
     * 
     * @param string|null $tokenRecupero Token di recupero password dell'utente
     */
    public function setTokenRecupero(?string $tokenRecupero)
    {
        $this->tokenRecupero = $tokenRecupero;
    }

    /**
     * Ottiene la data di scadenza del token di recupero password
     * 
     * @return DateTime|null Data di scadenza del token di recupero password
     */
    public function getDataScadenzaToken(): ?DateTime
    {
        return $this->dataScadenzaToken;
    }

    /**
     * Imposta la data di scadenza del token di recupero password
     * 
     * @param DateTime|null $dataScadenzaToken Data di scadenza del token di recupero password
     */
    public function setDataScadenzaToken(?DateTime $dataScadenzaToken)
    {
        $this->dataScadenzaToken = $dataScadenzaToken;
    }

    /**
     * Verifica se il token di recupero password è valido
     * 
     * @return bool Vero se il token di recupero password è valido, falso altrimenti
     */
    public function isTokenValido(): bool
    {
        return $this->tokenRecupero !== null && $this->dataScadenzaToken > new DateTime();
    }

    /**
     * Verifica se il token di recupero password è scaduto
     * 
     * @return bool Vero se il token di recupero password è scaduto, falso altrimenti
     */
    public function isTokenScaduto(): bool
    {
        return $this->tokenRecupero !== null && $this->dataScadenzaToken < new DateTime();
    }

    /**
     * Aggiunge un utente seguito da questo utente
     * 
     * @param EUtente $utente Utente da aggiungere
     */
    public function addSeguito(EUtente $utente)
    {
        if (!$this->isFollowing($utente)) {
            $this->seguiti[] = $utente;
        }
    }

    /**
     * Rimuove un utente seguito da questo utente
     * 
     * @param EUtente $utente Utente da rimuovere
     */
    public function removeSeguito(EUtente $utente)
    {
        foreach ($this->seguiti as $key => $seguito) {
            if ($seguito->getId() === $utente->getId()) {
                unset($this->seguiti[$key]);
                break;
            }
        }
    }

    /**
     * Verifica se questo utente segue un altro utente
     * 
     * @param EUtente $utente Utente da verificare
     * @return bool Vero se questo utente segue l'altro utente, falso altrimenti
     */
    public function isFollowing(EUtente $utente): bool
    {

        if (empty($this->seguiti)) {
            return false;
        }

        foreach ($this->seguiti as $seguito) {
            if ($seguito->getId() === $utente->getId()) {
                return true;
            }
        }
        return false;
    }
}
