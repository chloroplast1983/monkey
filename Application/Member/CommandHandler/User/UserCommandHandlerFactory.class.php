<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandlerFactory;
use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use Marmot\Core;

class UserCommandHandlerFactory implements ICommandHandlerFactory
{
    
    public function getHandler(ICommand $command) : ICommandHandler
    {
        $commandHandler = '';

        switch (get_class($command)) {
            //注册
            case 'Member\Command\User\SignUpUserCommand':
                $commandHandler = new SignUpUserCommandHandler();
                break;
            case 'Member\Command\User\AuthUserCommand':
                $commandHandler = new AuthUserCommandHandler();
                break;
        }
        return $commandHandler;
    }
}
