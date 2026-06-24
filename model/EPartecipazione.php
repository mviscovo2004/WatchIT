<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe EPartecipazione
 * 
 * Rappresenta una partecipazione di un attore a un film o serie TV.
 * 
 * @package Model
 * @author Marco Viscovo
 */
#[ORM\Entity]
#[ORM\Table(name: 'partecipazioni')]
class EPartecipazione
{
    /**
     * @var int ID univoco della partecipazione nel database
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    /**
     * @var EPersona Persona che partecipa
     */
    #[ORM\ManyToOne(targetEntity: EPersona::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected EPersona $persona;

    /**
     * @var EContenuto Contenuto a cui la persona partecipa
     */
    #[ORM\ManyToOne(targetEntity: EContenuto::class, inversedBy: 'partecipazioni')]
    #[ORM\JoinColumn(nullable: false)]
    protected EContenuto $contenuto;

    /**
     * @var string Ruolo interpretato dalla persona (nel cast/crew)
     */
    #[ORM\Column]
    protected string $ruolo;

    /**
     * @var string Personaggio interpretato dalla persona
     */
    #[ORM\Column]
    protected string $personaggio;

    /**
     * Costruttore della classe EPartecipazione.
     * 
     * @param int $id ID univoco della partecipazione nel database
     * @param EPersona $persona Persona che partecipa
     * @param EContenuto $contenuto Contenuto a cui la persona partecipa
     * @param string $ruolo Ruolo interpretato dalla persona
     * @param string $personaggio Personaggio interpretato dalla persona
     */
    public function __construct(int $id, EPersona $persona, EContenuto $contenuto, string $ruolo, string $personaggio)
    {
        $this->id = $id;
        $this->persona = $persona;
        $this->contenuto = $contenuto;
        $this->ruolo = $ruolo;
        $this->personaggio = $personaggio;
    }

    /**
     * Ottiene l'ID univoco della partecipazione nel database.
     * 
     * @return int ID univoco della partecipazione nel database
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Imposta l'ID univoco della partecipazione nel database.
     * 
     * @param int $id ID univoco della partecipazione nel database
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Ottiene la persona che partecipa.
     * 
     * @return EPersona Persona che partecipa
     */
    public function getPersona(): EPersona
    {
        return $this->persona;
    }

    /**
     * Imposta la persona che partecipa.
     * 
     * @param EPersona $persona Persona che partecipa
     */
    public function setPersona(EPersona $persona)
    {
        $this->persona = $persona;
    }

    /**
     * Ottiene il contenuto a cui la persona partecipa.
     * 
     * @return EContenuto Contenuto a cui la persona partecipa
     */
    public function getContenuto(): EContenuto
    {
        return $this->contenuto;
    }

    /**
     * Imposta il contenuto a cui la persona partecipa.
     * 
     * @param EContenuto $contenuto Contenuto a cui la persona partecipa
     */
    public function setContenuto(EContenuto $contenuto)
    {
        $this->contenuto = $contenuto;
    }

    /**
     * Ottiene il ruolo interpretato dalla persona.
     * 
     * @return string Ruolo interpretato dalla persona
     */
    public function getRuolo(): string
    {
        return $this->ruolo;
    }

    /**
     * Imposta il ruolo interpretato dalla persona.
     * 
     * @param string $ruolo Ruolo interpretato dalla persona
     */
    public function setRuolo(string $ruolo)
    {
        $this->ruolo = $ruolo;
    }

    /**
     * Ottiene il personaggio interpretato dalla persona.
     * 
     * @return string Personaggio interpretato dalla persona
     */
    public function getPersonaggio(): string
    {
        return $this->personaggio;
    }

    /**
     * Imposta il personaggio interpretato dalla persona.
     * 
     * @param string $personaggio Personaggio interpretato dalla persona
     */
    public function setPersonaggio(string $personaggio)
    {
        $this->personaggio = $personaggio;
    }
}
