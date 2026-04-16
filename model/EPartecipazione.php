<?php
    class EPartecipazione{
        protected int $id;
        protected EPersona $persona;
        protected EContenuto $contenuto;
        protected string $ruolo;

        public function __construct(int $id,EPersona $persona,EContenuto $contenuto,string $ruolo){
            $this->id=$id;
            $this->persona=$persona;
            $this->contenuto=$contenuto;
            $this->ruolo=$ruolo;
        }

        public function getId():int{
            return $this->id;
        }

        public function setId(int $id){
            $this->id=$id;
        }

        public function getPersona():EPersona{
            return $this->persona;
        }

        public function setPersona(EPersona $persona){
            $this->persona=$persona;
        }

        public function getContenuto():EContenuto{
            return $this->contenuto;
        }

        public function setContenuto(EContenuto $contenuto){
            $this->contenuto=$contenuto;
        }

        public function getRuolo():string{
            return $this->ruolo;
        }

        public function setRuolo(string $ruolo){
            $this->ruolo=$ruolo;
        }
    }
?>