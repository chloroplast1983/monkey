<?php
namespace System\View;

use System\Interfaces\IView;
use Marmot\Core;

class ErrorJsonView extends JsonView implements IView
{
    public function render() : void
    {
        $error = Core::getLastError();
        $data = array(
            'id'=>$error->getId(),
            'title'=>$error->getTitle(),
            'code'=>$error->getCode(),
            'detail'=>$error->getDetail(),
            'source'=>$error->getSource()
        );

        $this->failure()->encode($data);
    }
}
