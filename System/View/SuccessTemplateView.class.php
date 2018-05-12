<?php
namespace System\View;

use System\Interfaces\IView;
use Marmot\Core;

class SuccessTemplateView extends TemplateView implements IView
{
    public function render() : void
    {
        $this->getView()->display('System/Success.tpl');
    }
}
