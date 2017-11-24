<?php
namespace Common\Controller;

use Common\View\MessageView;

trait MessageTrait
{
    public function message(string $title, string $message, string $urlForward) : bool
    {
        if (!empty($urlForward)) {
            $second = 5 * 1000;
            $message .= "<script>setTimeout(\"window.location.href ='{$urlForward}';\", $second);</script>";
        }
        
        $this->getResponse()->view(new MessageView($title, $message, $urlForward))->render();
        return true;
    }
}
