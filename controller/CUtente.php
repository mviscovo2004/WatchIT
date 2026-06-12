<?php

class CUtente
{
    //login
    public function login()
    {
        if (Session::isLogged()) {
            $redirect = Session::get('previous_url') ?? 'index.php';
            header("Location: " . $redirect);
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
                    $ruolo = ($utente instanceof EAmministratore) ? 'admin' : 'utente';
                    Session::set('ruolo', $ruolo);

                    $redirect = Session::get('previous_url') ?? 'index.php';
                    header("Location: " . $redirect);
                    exit();
                } else {
                    $error = "Credenziali non valide. Riprova.";
                }
            } else {
                $error = "Compila tutti i campi obbligatori.";
            }

            // Salva l'errore in sessione e torna alla pagina precedente (senza cambiare sfondo)
            Session::set('login_error', $error);
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }

        Session::set('show_login_modal', true);
        $redirect = Session::get('previous_url') ?? 'index.php';
        header("Location: " . $redirect);
        exit();
    }


    //registrazione
    public function registrazione()
    {
        if (Session::isLogged()) {
            $redirect = Session::get('previous_url') ?? 'index.php';
            header("Location: " . $redirect);
            exit();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $cognome = trim($_POST['cognome'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $password_confirm = trim($_POST['password_confirm'] ?? '');
            $foto = 'default.png';

            if (!empty($nome) && !empty($cognome) && !empty($username) && !empty($email) && !empty($password) && !empty($password_confirm)) {

                if ($password !== $password_confirm) {
                    $error = "Le password inserite non coincidono.";
                } else {
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
                            $ruolo = ($utente instanceof EAmministratore) ? 'admin' : 'utente';
                            Session::set('ruolo', $ruolo);
                            $redirect = Session::get('previous_url') ?? 'index.php';
                            header("Location: " . $redirect);
                            exit();
                        } else {
                            $error = "Si è verificato un errore imprevisto durante la registrazione.";
                        }
                    }
                }
            } else {
                $error = "Tutti i campi sono obbligatori.";
            }

            // Salva l'errore in sessione e torna alla pagina precedente (senza cambiare sfondo)
            Session::set('register_error', $error);
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }

        Session::set('show_register_modal', true);
        $redirect = Session::get('previous_url') ?? 'index.php';
        header("Location: " . $redirect);
        exit();
    }



    //logout
    public function logout()
    {
        Session::destroy();
        $redirect = Session::get('previous_url') ?? 'index.php';
        header("Location: " . $redirect);
        exit();
    }

    public function mostraProfilo()
    {
        $id = $_GET['id'];

        $utente = FUtente::findById($id);
        $watchlists = FWatchlist::findPubblicheByUtente($id);
        $recensioni = FRecensione::findByUtente($id);

        $view = new VUtente();
        $view->mostraProfilo($utente, $watchlists, $recensioni);
    }


    public function forgotPassword()
    {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            if (!empty($email)) {
                if (FUtente::findByEmail($email) != null) {
                    FUtente::forgotPassword($email);
                    $error = "Email inviata con successo.";
                } else {
                    $error = "Email non trovata.";
                }
            } else {
                $error = "Email non trovata.";
            }
            Session::set('forgot_password_error', $error);
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }
        Session::set('show_forgot_password_modal', true);
        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header("Location: " . $referer);
        exit();
    }

    public function resetPassword()
    {
        $token = $_GET['token'] ?? null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim($_POST['password'] ?? '');
            $password_confirm = trim($_POST['password_confirm'] ?? '');
            if (!empty($password) && !empty($password_confirm)) {
                if ($password !== $password_confirm) {
                    $error = "Le password inserite non coincidono.";
                } else {
                    if (FUtente::resetPassword($token, $password)) {
                        $error = "Password reimpostata con successo.";
                    } else {
                        $error = "Token non valido o scaduto.";
                    }
                }
            } else {
                $error = "Tutti i campi sono obbligatori.";
            }
        }

        $view = new VUtente();
        $view->mostraResetPassword($token, $error);
    }
}
