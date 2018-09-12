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
        $this->getResponse()->view(new UserListView())->render();
        return true;
    }
}
