<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandlerFactory;
use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use System\Classes\NullCommandHandler;

class UserCommandHandlerFactory implements ICommandHandlerFactory
{
    
    public function getHandler(ICommand $command) : ICommandHandler
    {
        $commandHandler = '';

        switch (get_class($command)) {
            case 'Member\Command\User\SignUpUserCommand':
                $commandHandler = new SignUpUserCommandHandler();
                break;
            case 'Member\Command\User\AuthUserCommand':
                $commandHandler = new AuthUserCommandHandler();
                break;
            case 'Member\Command\User\SignInUserCommand':
                $commandHandler = new SignInUserCommandHandler();
                break;
            case 'Member\Command\User\SignOutUserCommand':
                $commandHandler = new SignOutUserCommandHandler();
                break;
            default:
                $commandHandler = new NullCommandHandler();
                break;
        }
        return $commandHandler;
    }
}
