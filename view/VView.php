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
