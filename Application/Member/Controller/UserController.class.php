<?php
namespace Member\Controller;

use System\Classes\Controller;
use System\Classes\CommandBus;

use Member\Command\User\SignUpUserCommand;
use Member\CommandHandler\User\UserCommandHandlerFactory;
use Member\Adapter\User\UserSessionAdapter;
use Member\Repository\User\UserRepository;
use Member\Model\User;

use Marmot\Core;

class UserController extends Controller
{
    public function index()
    {
        $cookie = new \System\Classes\Cookie();

        $cookie->name = Core::$container->get('cookie.name');
        $cookie->value = 1;
        $cookie->expire = Core::$container->get('cookie.duration');

        if ($cookie->add()) {
            //$userSessionRepository = new UserRepository();
            //$userSessionRepository->setAdapter(new UserSessionAdapter());
            //$userSessionRepository->add($user);
            //Core::$container->set('user', $user);
        }
    }
}
