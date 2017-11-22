<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use System\Interfaces\INull;

use Member\Command\User\AuthUserCommand;
use Member\Repository\User\UserSessionRepository;
use Member\Repository\User\UserRepository;
use Member\Model\User;

use Marmot\Core;

class AuthUserCommandHandler implements ICommandHandler
{
    private $userSessionRepository;

    private $userRepository;

    public function __construct()
    {
        $this->userSessionRepository = new UserSessionRepository();
        $this->userRepository = new UserRepository();
    }

    public function __destruct()
    {
        unset($this->userSessionRepository);
        unset($this->userRepository);
    }

    protected function getUserSessionRepository() : UserSessionRepository
    {
        return $this->userSessionRepository;
    }

    protected function getUserRepository() : UserRepository
    {
        return $this->userRepository;
    }

    public function execute(ICommand $command)
    {
        if (!($command instanceof AuthUserCommand)) {
            throw new InvalidArgumentException;
        }

        $user = $this->getUserSessionRepository()->get($command->uid);
        if ($user instanceof INull) {
            $user = $this->getUserRepository()->fetchOne($command->uid);
            $this->getUserSessionRepository()->add($user);
        }
        
        return $this->registerGlobalUser($command->uid);
    }

    private function registerGlobalUser($id) : bool
    {
        $user = $this->getUserSessionRepository()->get($id);

        Core::$container->set('user', $user);
        return true;
    }
}
