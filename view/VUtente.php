<?php

class VUtente extends VView
{
    public function mostraLogin($error = null)
    {
        if ($error) {
            $this->assign("error", $error);
        }
        $this->display("login.tpl");
    }

    public function mostraRegistrazione($error = null)
    {
        if ($error) {
            $this->assign("error", $error);
        }
        $this->display("register.tpl");
    }

    public function mostraProfilo($utente)
    {
        $this->assign("utente", $utente);
        $this->display("utente.tpl");
    }

    public function mostraResetPassword($token, $error = null)
    {
        if ($error) {
            $this->assign("error", $error);
        }
        $this->assign("token", $token);
        $this->display("resetPassword.tpl");
    }

    public function mostraRecuperaPassword($error = null)
    {
        if ($error) {
            $this->assign("error", $error);
        }
        $this->display("recuperaPassword.tpl");
    }
}
