<?php

/**
 * Classe CUtente
 * 
 * Controller per la gestione delle operazioni relative all'utente.
 * Gestisce i flussi di autenticazione (login, logout e registrazione), il recupero
 * della password smarrita, la visualizzazione del profilo pubblico e le relazioni di follow/unfollow tra utenti.
 * 
 * @package Controller
 * @author Marco Viscovo
 */
class CUtente
{
    /**
     * View associata al controller
     * 
     * @var VUtente
     */
    private VUtente $view;

    /**
     * Costruttore del controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->view = new VUtente();
    }

    /**
     * Attiva una modale e reindirizza l'utente
     * 
     * @param string $chiaveModale Chiave della modale da attivare
     * @return void
     */
    private function attivaModaleEReindirizza(string $chiaveModale)
    {
        Session::set($chiaveModale, true);
        $redirect = Session::get('previous_url') ?? Session::getServer('HTTP_REFERER') ?? 'index.php';
        header("Location: " . $redirect);
        exit();
    }

    /**
     * Reindirizza l'utente se è loggato
     * 
     * @return void
     */
    private function reindirizzaSeLoggato()
    {
        if (Session::isLogged()) {
            $redirect = Session::get('previous_url') ?? 'index.php';
            header("Location: " . $redirect);
            exit();
        }
    }

    /**
     * Imposta la sessione utente dopo il login
     * 
     * @param EUtente $utente Utente da impostare nella sessione
     * @return void
     */
    private function impostaSessioneUtente(EUtente $utente)
    {
        Session::set('user_id', $utente->getId());
        $ruolo = ($utente instanceof EAmministratore) ? 'admin' : 'utente';
        Session::set('ruolo', $ruolo);
    }

    /**
     * Gestisce il login dell'utente
     * 
     * @return void
     */
    public function login()
    {
        $this->reindirizzaSeLoggato();
        $error = null;
        if (Session::isPost()) {
            $identificativo = trim(Session::getPost('identificativo') ?? '');
            $password = trim(Session::getPost('password') ?? '');
            if (!empty($identificativo) && !empty($password)) {
                $utente = FUtente::login($identificativo, $password);
                if ($utente !== null) {

                    $ban = FBan::isBanned($utente->getId());
                    if ($ban !== null) {
                        $error = "Il tuo account è sospeso fino al " . $ban->getDataFine()->format('d/m/Y H:i') . " per il seguente motivo: " . $ban->getMotivo();
                        Session::set('login_error', $error);
                        $referer = Session::get('previous_url') ?? 'index.php';
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
            $referer = Session::get('previous_url') ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }
        $this->attivaModaleEReindirizza('show_login_modal');
    }

    /**
     * Gestisce la registrazione dell'utente
     * 
     * @return void
     */
    public function registrazione()
    {
        $this->reindirizzaSeLoggato();
        $error = null;
        if (Session::isPost()) {
            $nome = trim(Session::getPost('nome') ?? '');
            $cognome = trim(Session::getPost('cognome') ?? '');
            $username = trim(Session::getPost('username') ?? '');
            $email = trim(Session::getPost('email') ?? '');
            $password = trim(Session::getPost('password') ?? '');
            $password_confirm = trim(Session::getPost('password_confirm') ?? '');
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
            $referer = Session::getServer('HTTP_REFERER') ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }
        $this->attivaModaleEReindirizza('show_register_modal');
    }

    /**
     * Gestisce il logout dell'utente
     * 
     * @return void
     */
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
        header("Location: " . $redirect);
        exit();
    }

    /**
     * Mostra il profilo dell'utente
     * 
     * @return void
     */
    public function mostraProfilo()
    {
        $id = Session::getGet('id') ?? null;
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

    /**
     * Gestisce la richiesta di reset password
     * 
     * @return void
     */
    public function forgotPassword()
    {
        $error = null;
        if (Session::isPost()) {
            $email = trim(Session::getPost('email') ?? '');
            if (!empty($email)) {
                FUtente::forgotPassword($email);
                $error = "Se l'indirizzo email inserito è registrato nei nostri sistemi, riceverai a breve un link per impostare una nuova password.";
            } else {
                $error = "Inserisci un indirizzo email valido.";
            }
            Session::set('forgot_password_error', $error);
            $referer = Session::getServer('HTTP_REFERER') ?? 'index.php';
            header("Location: " . $referer);
            exit();
        }
        $this->attivaModaleEReindirizza('show_forgot_password_modal');
    }

    /**
     * Gestisce il reset della password
     * 
     * @return void
     */
    public function resetPassword()
    {
        $token = Session::getGet('token') ?? null;
        $error = null;
        if (Session::isPost()) {
            $password = trim(Session::getPost('password') ?? '');
            $password_confirm = trim(Session::getPost('password_confirm') ?? '');
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

    /**
     * Gestisce il follow dell'utente
     * 
     * @return void
     */
    public function follow()
    {
        $idUtenteLoggato = Session::get('user_id');
        if (!$idUtenteLoggato) {
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }
        $idUtenteSeguito = Session::getGet('id') ?? null;
        if ($idUtenteSeguito && (int)$idUtenteSeguito !== $idUtenteLoggato) {
            FUtente::follow($idUtenteLoggato, (int)$idUtenteSeguito);
        }
        $referer = Session::getServer('HTTP_REFERER') ?? 'index.php';
        header("Location: " . $referer);
        exit();
    }

    /**
     * Gestisce l'unfollow dell'utente
     * 
     * @return void
     */
    public function unfollow()
    {
        $idUtenteLoggato = Session::get('user_id');
        if (!$idUtenteLoggato) {
            header("Location: index.php?controller=Utente&action=login");
            exit();
        }
        $idUtenteSeguito = Session::getGet('id') ?? null;
        if ($idUtenteSeguito && (int)$idUtenteSeguito !== $idUtenteLoggato) {
            FUtente::unfollow($idUtenteLoggato, (int)$idUtenteSeguito);
        }
        $referer = Session::getServer('HTTP_REFERER') ?? 'index.php';
        header("Location: " . $referer);
        exit();
    }
}
