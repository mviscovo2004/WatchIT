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

        
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
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

    public function assign($key, $value)
    {
        $this->smarty->assign($key, $value);
    }

    public function display($templateName)
    {
        $this->smarty->display($templateName);
    }

    public function mostraErrore($errore)
    {
        $this->assign('errore', $errore);
        $this->display('errore.tpl');
    }
}
