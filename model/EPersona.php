<?php
    class EPersona{
        protected int $id;
        protected string $nome;
        protected string $cognome;
        protected string $foto;
        

        public function __construct(int $id,string $nome,string $cognome,string $foto)
        {
            $this->id=$id;
            $this->nome=$nome;
            $this->cognome=$cognome;
            $this->foto=$foto;
        }

        public function getNome():string{
            return $this->nome;
        }

        public function setNome(string $nome) {
            $this->nome=$nome;   
        }

        public function getCognome():string{
            return $this->cognome;
        }

        public function setCognome(string $cognome){
            $this->cognome=$cognome;
        }

        public function getFoto(): string{
            return $this->foto;
        }

        public function setFoto(string $foto){
            $this->foto=$foto;
        }

        public function getId(): int{
            return $this->id;
        }

        public function setId(int $id){
            $this->id=$id;
        }

    }

?>