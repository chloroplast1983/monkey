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
        $this->view->setCacheDir(S_ROOT.'View/Smarty/Cache');
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
