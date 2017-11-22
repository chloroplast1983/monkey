<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use System\Interfaces\INull;

use Member\Command\User\SignOutUserCommand;
use Member\Model\User;
use Marmot\Core;

class SignOutUserCommandHandler implements ICommandHandler
{
    
    public function execute(ICommand $command)
    {
        $user = Core::$container->get('user');
        return $user->signOut();
    }
}
