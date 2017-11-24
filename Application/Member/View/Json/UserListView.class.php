<?php
namespace Member\View\Json;

use System\View\JsonView;
use System\Interfaces\IView;

use Member\Translator\UserTranslator;

class UserListView extends JsonView implements IView
{
    private $users;

    private $translator;

    public function __construct(array $users = array())
    {
        $this->users = $users;
        $this->translator = new UserTranslator();
        parent::__construct();
    }

    protected function getUsers() : array
    {
        return $this->users;
    }

    protected function getTranslator() : UserTranslator
    {
        return $this->translator;
    }

    public function render() : void
    {
        $data = array();

        foreach ($this->getUsers() as $user) {
            $data[] = $this->getTranslator()->objectToArray($user);
        }
        $this->encode($data);
    }
}
