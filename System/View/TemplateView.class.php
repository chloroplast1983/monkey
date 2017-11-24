<?php
namespace System\View;

abstract class TemplateView
{
    private $view;
    private $data;

    public function __construct($data = '')
    {
        $this->view = Smarty::getInstance();
        $this->data = $data;
    }

    public function __destruct()
    {
        unset($this->view);
    }

    protected function getView()
    {
        return $this->view;
    }

    protected function getData()
    {
        return $this->data;
    }
}
