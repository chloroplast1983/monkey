<?php
namespace System\View;

class Smarty extends \SmartyBC
{
    private static $instance;

    public function __construct()
    {
        parent::__construct();

        $this->setTemplateDir(S_ROOT.'View/Smarty/Templates');
        $this->setCompileDir(S_ROOT.'View/Smarty/Compile');
        $this->setConfigDir(S_ROOT.'View/Smarty/Config');
        $this->setCacheDir(S_ROOT.'View/Smarty/Cache');
        $this->setPluginsDir(S_ROOT.'View/Smarty/Plugins');
    }

    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
