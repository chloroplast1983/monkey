<?php
namespace Member\View\Template;

use System\View\TemplateView;
use System\Interfaces\IView;

class SignInView extends TemplateView implements IView
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render() : void
    {
        $this->getView()->display('User/SignIn.tpl');
    }
}
