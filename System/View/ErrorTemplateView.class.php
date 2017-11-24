<?php
namespace System\View;

use System\Interfaces\IView;
use Marmot\Core;

class ErrorTemplateView extends TemplateView implements IView
{
    public function render() : void
    {
        $error = Core::getLastError();

        $this->getView()->assign('errorId', $error->getId());
        $this->getView()->display('System/Error.tpl');
    }
}
