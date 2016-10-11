<?php
namespace Member\Controller;

use System\Classes\Controller;
use System\Classes\CommandBus;

use Member\Command\User\SignUpUserCommand;
use Member\CommandHandler\User\UserCommandHandlerFactory;
use Member\Model\User;

class UserController extends Controller
{
    public function index()
    {
    	//这里尝试创建一个模板,显示user列表和user对象
    }

    public function signUp(int $id = 0)
    {	
    	//如果是post提交
    	if($this->getRequest()->getIsPost()) {
    		$data = $this->getRequest()->post();

    		$commandBus = new CommandBus(new UserCommandHandlerFactory());

    		$command = new SignUpUserCommand(
                $cellPhone = $data['cellPhone'],
                $userName = $data['userName'],
                $password = $data['password']
            );

            if ($commandBus->send($command)) {
            	var_dump($command->uid);
            	exit();
            }
    	}
    	$this->getResponse()->view()->display('User/SignUp.tpl');
    	//$this->getReuqest()->isAjax();//如果是ajax提交
    }
}
