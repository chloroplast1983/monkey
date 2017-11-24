<?php
namespace Member\View\Template;

use System\View\TemplateView;
use System\Interfaces\IView;

class SignUpView extends TemplateView implements IView
{
    public function __construct()
    {
        parent::__construct();
    }

    public function render() : void
    {
        $this->getView()->display('User/SignUp.tpl');
    }
}
