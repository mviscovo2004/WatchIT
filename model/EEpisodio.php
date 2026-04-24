<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'episodi')]
class EEpisodio{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: ESerie::class, inversedBy: 'episodi')]
    #[ORM\JoinColumn(nullable: false)]
    protected ESerie $serie;

    #[ORM\Column]
    protected int $numeroStagione;

    #[ORM\Column]
    protected int $numeroEpisodio;

    #[ORM\Column]
    protected string $titolo;

    #[ORM\Column(type: Types::TEXT)]
    protected string $trama;

    #[ORM\Column]
    protected int $durataMinuti;

    #[ORM\Column(type: Types::FLOAT)]
    protected float $valutazioneMedia;

        public function __construct(int $id,ESerie $serie,int $numeroStagione,int $numeroEpisodio,string $titolo,string $trama,int $durataMinuti,float $valutazioneMedia){
            $this->id=$id;
            $this->serie=$serie;
            $this->numeroStagione=$numeroStagione;
            $this->numeroEpisodio=$numeroEpisodio;
            $this->titolo=$titolo;
            $this->trama=$trama;
            $this->durataMinuti=$durataMinuti;
            $this->valutazioneMedia=$valutazioneMedia;  
        }

        public function getId():int{
            return $this->id;
        }

        public function setId(int $id){
            $this->id=$id;
        }

        public function getSerie():ESerie{
            return $this->serie;
        }

        public function setSerie(ESerie $serie){
            $this->serie=$serie;
        }

        public function getNumeroStagione():int{
            return $this->numeroStagione;
        }

        public function setNumeroStagione(int $numeroStagione){
            $this->numeroStagione=$numeroStagione;
        }

        public function getNumeroEpisodio():int{
            return $this->numeroEpisodio;
        }

        public function setNumeroEpisodio(int $numeroEpisodio){
            $this->numeroEpisodio=$numeroEpisodio;
        }

        public function getTitolo():string{
            return $this->titolo;
        }

        public function setTitolo(string $titolo){
            $this->titolo=$titolo;
        }

        public function getTrama():string{
            return $this->trama;
        }

        public function setTrama(string $trama){
            $this->trama=$trama;
        }

        public function getDurata():int{
            return $this->durataMinuti;
        }

        public function setDurata(int $durataMinuti){
            $this->durataMinuti=$durataMinuti;
        }

        public function getValutazioneMedia():float{
            return $this->valutazioneMedia;
        }

        public function setValutazioneMedia(float $valutazioneMedia){
            $this->valutazioneMedia=$valutazioneMedia;
        }
    }
?>