<?php
//powered by chloroplast
namespace System\Classes;

use Marmot\Core;

class Response
{
    private $view;

    public function __construct()
    {
        $this->view = new \SmartyBC;
        $this->view->setTemplateDir(S_ROOT.'View/Smarty/Templates');
        $this->view->setCompileDir(S_ROOT.'View/Smarty/Compile');
        $this->view->setConfigDir(S_ROOT.'View/Smarty/Config');
        $this->view->setCacheDir(S_ROOT.'View/Smarty/Cache');
        $this->view->setPluginsDir(S_ROOT.'View/Smarty/Plugins');
    }

    public function view()
    {
        return $this->view;
    }

    public function jsonOut($data)
    {
        echo json_encode($data);
        exit();
    }
}
