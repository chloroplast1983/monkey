<?php
namespace Common\Controller;

trait MessageTrait
{
    public function message(string $title, string $message, string $urlForward) : bool
    {
        if (!empty($urlForward)) {
            $second = 5 * 1000;
            $message .= "<script>setTimeout(\"window.location.href ='{$urlForward}';\", $second);</script>";
        }
        $this->getResponse()->view()->assign('title', $title);
        $this->getResponse()->view()->assign('message', $message);
        $this->getResponse()->view()->assign('urlForward', $urlForward);
        $this->getResponse()->view()->display('Common/message.tpl');
        
        return true;
    }
}
