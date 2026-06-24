<?php

/**
 * Classe VView
 * 
 * Classe base per tutte le viste dell'applicazione.
 * Inizializza l'istanza condivisa di Smarty (Singleton), rileva lo stato di sessione dell'utente,
 * assegna le variabili di errore comuni e definisce i metodi helper `assign` e `display`.
 * 
 * @package View
 * @author Marco Viscovo
 */
class VView
{
    /**
     * Istanza statica condivisa di Smarty (Singleton)
     * 
     * @var \Smarty\Smarty|null
     */
    protected static $smartyInstance;

    /**
     * Istanza di Smarty per la vista corrente
     * 
     * @var \Smarty\Smarty|null
     */
    protected $smarty;

    /**
     * Costruttore della classe VView
     * 
     * Inizializza l'istanza condivisa di Smarty (Singleton), rileva lo stato di sessione dell'utente,
     * assegna le variabili di errore comuni e definisce i metodi helper `assign` e `display`.
     * 
     * @return void
     */
    public function __construct()
    {
        if (!self::$smartyInstance) {
            $config = require __DIR__ . "/../foundation/bootstrap.php";
            self::$smartyInstance = $config['smarty'];
        }
        $this->smarty = self::$smartyInstance;


        $scriptName = Session::getServer('SCRIPT_NAME', '');
        $dir = dirname($scriptName);
        $baseUrl = ($dir === DIRECTORY_SEPARATOR || $dir === '/' || $dir === '\\') ? '' : $dir;
        $this->smarty->assign("baseUrl", $baseUrl);


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



        if (Session::exists('register_error')) {
            $this->smarty->assign("registerError", Session::get('register_error'));
            Session::remove('register_error');
        }


        if (Session::exists('login_error')) {
            $this->smarty->assign("loginError", Session::get('login_error'));
            Session::remove('login_error');
        }

        if (Session::exists('import_error')) {
            $this->smarty->assign("importError", Session::get('import_error'));
            Session::remove('import_error');
        }

        if (Session::exists('import_success')) {
            $this->smarty->assign("importSuccess", Session::get('import_success'));
            Session::remove('import_success');
        }



        if (Session::exists('show_login_modal')) {
            $this->smarty->assign("showLogin", true);
            Session::remove('show_login_modal');
        }
        if (Session::exists('show_register_modal')) {
            $this->smarty->assign("showRegister", true);
            Session::remove('show_register_modal');
        }
    }

    /**
     * Assegna una variabile alla vista
     * 
     * @param string $key Chiave della variabile
     * @param mixed $value Valore della variabile
     * 
     * @return void
     */
    public function assign($key, $value)
    {
        $this->smarty->assign($key, $value);
    }

    /**
     * Mostra una vista
     * 
     * @param string $templateName Nome del template
     * 
     * @return void
     */
    public function display($templateName)
    {
        $this->smarty->display($templateName);
    }

    /**
     * Mostra un errore
     * 
     * @param string $errore Messaggio di errore
     * 
     * @return void
     */
    public function mostraErrore($errore)
    {
        $this->assign('errore', $errore);
        $this->display('errore.tpl');
    }
}
