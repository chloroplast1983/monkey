<?php
namespace Common\View;

use System\View\TemplateView;
use System\Interfaces\IView;

class MessageView extends TemplateView implements IView
{
    private $title;
    private $message;
    private $urlForward;

    public function __construct(string $title, string $message, string $urlForward)
    {
        $this->title = $title;
        $this->message = $message;
        $this->urlForward = $urlForward;

        parent::__construct();
    }

    protected function getTitle() : string
    {
        return $this->title;
    }

    protected function getMessage() : string
    {
        return $this->message;
    }

    protected function getUrlForward() : string
    {
        return $this->urlForward;
    }

    public function render() : void
    {
        $this->getView()->assign('title', $this->getTitle());
        $this->getView()->assign('message', $this->getMessage());
        $this->getView()->assign('urlForward', $this->getUrlForward());

        $this->getView()->display('Common/Message.tpl');
    }
}
