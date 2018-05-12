<?php
namespace System\View;

use System\Interfaces\IView;
use Marmot\Core;

class SuccessJsonView extends JsonView implements IView
{
    public function render() : void
    {
        $this->success()->encode();
    }
}
