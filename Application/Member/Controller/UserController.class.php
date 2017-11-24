<?php
namespace Member\Controller;

use System\Classes\Controller;
use System\Classes\CommandBus;

use Common\Controller\MessageTrait;

use Member\CommandHandler\User\UserCommandHandlerFactory;
use Member\Repository\User\UserRepository;
use Member\Model\User;

use Member\View\Json\UserListView;

use Marmot\Core;

class UserController extends Controller
{
    use MessageTrait;

    public function index()
    {
//        if (Core::$container->has('user')) {
//            var_dump(Core::$container->get('user'));
//        }
//
//        var_dump('no user');
        $repository = new UserRepository();
        $users = $repository->fetchList(array(1,2,3));
        $this->getResponse()->view(new UserListView($users))->render();
        return true;
    }
}
