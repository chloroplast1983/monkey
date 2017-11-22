<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;

use Member\Command\User\SignUpUserCommand;
use Member\Model\User;

class SignUpUserCommandHandler implements ICommandHandler
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
        if (!($command instanceof SignUpUserCommand)) {
            throw new InvalidArgumentException;
        }

        $user = $this->getUser();

        $user->setCellphone($command->cellphone);
        $user->setPassword($command->password);
        
        if ($user->signUp()) {
            $command->uid = $user->getId();
            return true;
        }
        return false;
    }
}
