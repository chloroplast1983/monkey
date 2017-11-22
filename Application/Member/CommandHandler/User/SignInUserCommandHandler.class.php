<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use System\Interfaces\INull;

use Member\Command\User\SignInUserCommand;
use Member\Model\User;

class SignInUserCommandHandler implements ICommandHandler
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function __destruct()
    {
        unset($this->user);
    }

    protected function getUser() : User
    {
        return $this->user;
    }

    public function execute(ICommand $command)
    {
        if (!($command instanceof SignInUserCommand)) {
            throw new InvalidArgumentException;
        }

        $user = $this->getUser();

        $user->setCellphone($command->cellphone);
        $user->setPassword($command->password);

        return $user->signIn();
    }
}
