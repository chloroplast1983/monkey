<?php
//powered by chloroplast
namespace System\Classes;

use System\Interfaces\IView;

use Marmot\Core;

class Response
{
    //这里预留输出response的header

    private $view;

    protected function getView() : IView
    {
        return $this->view;
    }

    public function view(IView $view) : self
    {
        $this->view = $view;
        return $this;
    }

    public function render() : void
    {
        //其他输出
        $this->getView()->render();
    }
}
