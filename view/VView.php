<?php

class VView
{
    protected static $smartyInstance;
    protected $smarty;

    public function __construct()
    {
        if (!self::$smartyInstance) {
            $config = require __DIR__ . "/../foundation/bootstrap.php";
            self::$smartyInstance = $config['smarty'];
        }
        $this->smarty = self::$smartyInstance;

        // Calcola dinamicamente la cartella base del progetto (/WatchIT in locale, stringa vuota su Altervista)
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $dir = dirname($scriptName);
        $baseUrl = ($dir === DIRECTORY_SEPARATOR || $dir === '/' || $dir === '\\') ? '' : $dir;
        $this->smarty->assign("baseUrl", $baseUrl);

        // --- ASSOCIAZIONE GLOBALE DI SESSIONE A SMARTY ---
        if (Session::isLogged()) {
            $userId = Session::get('user_id');
            $utente = FUtente::findById($userId);

            if ($utente) {
                $this->smarty->assign("isLogged", true);
                $this->smarty->assign("currentUser", $utente);
                $ruoloSmarty = ($utente instanceof EAmministratore) ? 'ADMIN' : 'UTENTE';
                $this->smarty->assign("ruolo", $ruoloSmarty);
            } else {
                Session::remove('user_id');
                Session::remove('ruolo');
                $this->smarty->assign("isLogged", false);
                $this->smarty->assign("currentUser", null);
                $this->smarty->assign("ruolo", 'VISITATORE');
            }
        } else {
            $this->smarty->assign("isLogged", false);
            $this->smarty->assign("currentUser", null);
            $this->smarty->assign("ruolo", 'VISITATORE');
        }


        // Se c'è un errore di registrazione in sessione, lo passiamo a Smarty e lo cancelliamo
        if (Session::exists('register_error')) {
            $this->smarty->assign("registerError", Session::get('register_error'));
            Session::remove('register_error');
        }

        // Se c'è un errore di login in sessione, lo passiamo a Smarty e lo cancelliamo
        if (Session::exists('login_error')) {
            $this->smarty->assign("loginError", Session::get('login_error'));
            Session::remove('login_error');
        }
        // Forza l'apertura dei modali all'avvio se richiesto via sessione (es. redirect da GET)
        if (Session::exists('show_login_modal')) {
            $this->smarty->assign("showLogin", true);
            Session::remove('show_login_modal');
        }
        if (Session::exists('show_register_modal')) {
            $this->smarty->assign("showRegister", true);
            Session::remove('show_register_modal');
        }
    }

    public function assign($key, $value)
    {
        $this->smarty->assign($key, $value);
    }

    public function display($templateName)
    {
        $this->smarty->display($templateName);
    }
}
