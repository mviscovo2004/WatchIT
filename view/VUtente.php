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
}
