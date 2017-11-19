<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;

use Member\Command\User\SignUpUserCommand;
use Member\Model\User;

class SignUpUserCommandHandler implements ICommandHandler
{
    public function execute(ICommand $command)
    {
        if (!($command instanceof SignUpUserCommand)) {
            throw new InvalidArgumentException;
        }

        $user = new User();

        $user->setCellPhone($command->cellPhone);
        $user->setPassword($command->password);
        
        if ($user->signUp()) {
            $command->uid = $user->getId();
            return true;
        }

        return false;
    }
}
