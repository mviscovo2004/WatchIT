<?php

class CUtente
{
    private VUtente $view;

    public function __construct()
    {
        $this->view = new VUtente();
    }

    private function attivaModaleEReindirizza(string $chiaveModale)
    {
        Session::set($chiaveModale, true);
        $redirect = Session::get('previous_url') ?? $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header("Location: " . $redirect);
        exit();
    }


    private function reindirizzaSeLoggato()
    {
        if (Session::isLogged()) {
            $redirect = Session::get('previous_url') ?? 'index.php';
            header("Location: " . $redirect);
            exit();
        }
    }

    private function impostaSessioneUtente(EUtente $utente)
    {
        Session::set('user_id', $utente->getId());
        $ruolo = ($utente instanceof EAmministratore) ? 'admin' : 'utente';
        Session::set('ruolo', $ruolo);
    }



    
    public function login()
    {
        $this->reindirizzaSeLoggato();

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identificativo = trim($_POST['identificativo'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($identificativo) && !empty($password)) {
                $utente = FUtente::login($identificativo, $password);
                if ($utente !== null) {
                    
                    $ban = FBan::isBanned($utente->getId());
                    if ($ban !== null) {
                        $error = "Il tuo account è sospeso fino al " . $ban->getDataFine()->format('d/m/Y H:i') . " per il seguente motivo: " . $ban->getMotivo();
                        Session::set('login_error', $error);
                        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
                        header("Location: " . $referer);
                        exit();
                    }

                    $this->impostaSessioneUtente($utente);

                    $redirect = Session::get('previous_url') ?? 'index.php';
                    header("Location: " . $redirect);
                    exit();
                } else {
                    $error = "Credenziali non valide. Riprova.";
                }
            } else {
                $error = "Compila tutti i campi obbligatori.";
            }

            
            Session::set('login_error', $error);
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }

        $this->attivaModaleEReindirizza('show_login_modal');
    }


    
    public function registrazione()
    {
        $this->reindirizzaSeLoggato();

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
                            $this->impostaSessioneUtente($utente);
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

            
            Session::set('register_error', $error);
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }

        $this->attivaModaleEReindirizza('show_register_modal');
    }



    
    public function logout()
    {
        $redirect = Session::get('previous_url') ?? 'index.php';

        
        
        if (
            strpos($redirect, 'controller=Admin') !== false ||
            strpos($redirect, 'controller=Watchlist') !== false
        ) {
            $redirect = 'index.php';
        }

        
        Session::destroy();
        if (isset($_SESSION)) {
            $_SESSION = [];
        }

        header("Location: " . $redirect);
        exit();
    }


    public function mostraProfilo()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->view->mostraErrore('ID utente non valido.');
            return;
        }

        $utente = FUtente::findById($id);
        if (!$utente) {
            $this->view->mostraErrore('Utente non trovato.');
            return;
        }

        $idUtenteLoggato = Session::get('user_id');
        $isFollowing = false;
        $isAmico = false;

        if ($idUtenteLoggato !== null && $idUtenteLoggato !== (int)$id) {
            $isFollowing = FUtente::isFollowing($idUtenteLoggato, (int)$id);
            $isAmico = $isFollowing && FUtente::isFollowing((int)$id, $idUtenteLoggato);
        }

        
        $tutteWatchlist = FWatchlist::findByUtente((int)$id);
        $watchlists = [];
        foreach ($tutteWatchlist as $w) {
            $vis = $w->getVisibilita();
            if ($vis === Privacy::pubblico) {
                $watchlists[] = $w;
            } elseif ($vis === Privacy::solo_amici) {
                if ($idUtenteLoggato === (int)$id || $isAmico) {
                    $watchlists[] = $w;
                }
            } elseif ($vis === Privacy::privato) {
                if ($idUtenteLoggato === (int)$id) {
                    $watchlists[] = $w;
                }
            }
        }

        $recensioni = FRecensione::findByUtente($id);

        $view = new VUtente();
        
        $view->assign('isFollowing', $isFollowing);
        $view->assign('isAmico', $isAmico);

        $view->mostraProfilo($utente, $watchlists, $recensioni);
    }



    public function forgotPassword()
    {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            if (!empty($email)) {
                FUtente::forgotPassword($email);
                $error = "Se l'indirizzo email inserito è registrato nei nostri sistemi, riceverai a breve un link per impostare una nuova password.";
            } else {
                $error = "Inserisci un indirizzo email valido.";
            }
            Session::set('forgot_password_error', $error);
            $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }
        $this->attivaModaleEReindirizza('show_forgot_password_modal');
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
        $this->view->mostraResetPassword($token, $error);
    }

    public function follow()
    {
        $idUtenteLoggato = Session::get('user_id');
        if (!$idUtenteLoggato) {
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }

        $idUtenteSeguito = $_GET['id'] ?? null;
        if ($idUtenteSeguito && (int)$idUtenteSeguito !== $idUtenteLoggato) {
            FUtente::follow($idUtenteLoggato, (int)$idUtenteSeguito);
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header("Location: " . $referer);
        exit();
    }

    public function unfollow()
    {
        $idUtenteLoggato = Session::get('user_id');
        if (!$idUtenteLoggato) {
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }

        $idUtenteSeguito = $_GET['id'] ?? null;
        if ($idUtenteSeguito && (int)$idUtenteSeguito !== $idUtenteLoggato) {
            FUtente::unfollow($idUtenteLoggato, (int)$idUtenteSeguito);
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        header("Location: " . $referer);
        exit();
    }
}
