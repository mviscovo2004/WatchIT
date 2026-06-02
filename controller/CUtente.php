<?php

class CUtente
{
    //login
    public function login()
    {
        if (Session::isLogged()) {
            header("Location: index.php");
            exit();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identificativo = trim($_POST['identificativo'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($identificativo) && !empty($password)) {
                $utente = FUtente::login($identificativo, $password);
                if ($utente !== null) {
                    Session::set('user_id', $utente->getId());
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Credenziali non valide. Riprova.";
                }
            } else {
                $error = "Compila tutti i campi obbligatori.";
            }
        }

        $view = new VUtente();
        $view->mostraLogin($error);
    }

    //registrazione
    public function registrazione()
    {
        if (Session::isLogged()) {
            header("Location: index.php");
            exit();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $cognome = trim($_POST['cognome'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $foto = 'default.jpg';

            if (!empty($nome) && !empty($cognome) && !empty($username) && !empty($email) && !empty($password)) {
                $esisteEmail = FUtente::findByEmail($email);
                $esisteUsername = FUtente::findByUsername($username);

                if ($esisteEmail !== null) {
                    $error = "L'indirizzo email inserito è già registrato.";
                } else if ($esisteUsername !== null) {
                    $error = "Il nome utente scelto è già occupato.";
                } else {
                    $utente = FUtente::register($nome, $cognome, $foto, $username, $email, $password);
                    if ($utente !== null) {
                        Session::set('user_id', $utente->getId());
                        header("Location: index.php");
                        exit();
                    } else {
                        $error = "Si è verificato un errore imprevisto durante la registrazione.";
                    }
                }
            } else {
                $error = "Tutti i campi sono obbligatori.";
            }
        }

        $view = new VUtente();
        $view->mostraRegistrazione($error);
    }

    //logout
    public function logout()
    {
        Session::destroy();
        header("Location: index.php");
        exit();
    }
}
