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

        // --- ASSOCIAZIONE GLOBALE DI SESSIONE A SMARTY ---
        if (Session::isLogged()) {
            $userId = Session::get('user_id');
            $utente = FUtente::findById($userId);

            if ($utente) {
                $this->smarty->assign("isLogged", true);
                $this->smarty->assign("currentUser", $utente);
            } else {
                // Se l'utente non esiste più nel DB (es. dopo reset del database), 
                // distruggiamo la sessione orfana ed evitiamo il crash
                Session::destroy();
                $this->smarty->assign("isLogged", false);
                $this->smarty->assign("currentUser", null);
            }
        } else {
            $this->smarty->assign("isLogged", false);
            $this->smarty->assign("currentUser", null);
        }


        // Se c'è un errore di login in sessione, lo passiamo a Smarty e lo cancelliamo
        if (Session::exists('login_error')) {
            $this->smarty->assign("loginError", Session::get('login_error'));
            Session::remove('login_error');
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
