<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use System\Interfaces\INull;
use System\Classes\Session;

use Member\Command\User\AuthUserCommand;
use Member\Repository\User\UserSessionRepository;
use Member\Repository\User\UserRepository;
use Member\Model\User;
use Marmot\Core;

class AuthUserCommandHandler implements ICommandHandler
{
    public function execute(ICommand $command)
    {
        if (!($command instanceof AuthUserCommand)) {
            throw new InvalidArgumentException;
        }

        $userSessionRepository = new UserSessionRepository();
        $user = $userSessionRepository->get($command->uid);
        if ($user instanceof INull) {
            $userRepositry = new UserRepository();
            $user = $userRepositry->fetchOne($command->uid);

            $userSessionRepository->add($user);
        }

        Core::$container->set('user', $user);
        return true;
    }
}
