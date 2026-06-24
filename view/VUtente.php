<?php

/**
 * Classe VUtente
 * 
 * Gestisce la presentazione delle pagine relative all'account dell'utente.
 * Rendering delle schermate di login, registrazione, visualizzazione del profilo pubblico
 * (con le relative watchlist e recensioni) e le pagine di recupero/reset della password.
 * 
 * @package View
 * @author Marco Viscovo
 */
class VUtente extends VView
{
    /**
     * Mostra la pagina di login
     * 
     * @param string|null $error Messaggio di errore
     * @return void
     */
    public function mostraLogin($error = null)
    {
        if ($error) {
            $this->assign("error", $error);
        }
        $this->display("login.tpl");
    }

    /**
     * Mostra la pagina di registrazione
     * 
     * @param string|null $error Messaggio di errore
     * @return void
     */
    public function mostraRegistrazione($error = null)
    {
        if ($error) {
            $this->assign("error", $error);
        }
        $this->display("register.tpl");
    }

    /**
     * Mostra la pagina del profilo utente
     * 
     * @param EUtente $utente Utente da mostrare
     * @param array $watchlists Lista di watchlist
     * @param array $recensioni Lista di recensioni
     * @return void
     */
    public function mostraProfilo($utente, $watchlists = [], $recensioni = [])
    {
        $this->assign("utente", $utente);
        $this->assign("watchlists", $watchlists);
        $this->assign("recensioni", $recensioni);
        $this->display("utente.tpl");
    }

    /**
     * Mostra la pagina di reset della password
     * 
     * @param string $token Token di reset
     * @param string|null $error Messaggio di errore
     * @return void
     */
    public function mostraResetPassword($token, $error = null)
    {
        if ($error) {
            $this->assign("error", $error);
        }
        $this->assign("token", $token);
        $this->display("resetPassword.tpl");
    }

    /**
     * Mostra la pagina di recupero della password
     * 
     * @param string|null $error Messaggio di errore
     * @return void
     */
    public function mostraRecuperaPassword($error = null)
    {
        if ($error) {
            $this->assign("error", $error);
        }
        $this->display("recuperaPassword.tpl");
    }
}
