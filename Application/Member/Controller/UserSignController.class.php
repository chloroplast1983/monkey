<?php
namespace Member\Controller;

use System\Classes\Controller;
use System\Classes\CommandBus;

use Common\Controller\CsrfTokenTrait;
use Common\Controller\CaptchaTrait;
use Common\Controller\MessageTrait;

use Member\Command\User\SignUpUserCommand;
use Member\Command\User\SignInUserCommand;
use Member\Command\User\SignOutUserCommand;

use Member\CommandHandler\User\UserCommandHandlerFactory;
use Member\Model\User;

use Member\View\Template\SignUpView;
use Member\View\Template\SignInView;

use WidgetRules\Common\InputWidgetRules;

use Marmot\Core;

class UserSignController extends Controller
{
    use CsrfTokenTrait;
    use CaptchaTrait;
    use MessageTrait;

    public function signUp()
    {
        if ($this->getRequest()->isGetMethod()) {
            return $this->signUpView();
        }

        return $this->signUpAction();
    }

    protected function signUpView() : bool
    {
        $this->getResponse()->view(new SignUpView())->render();
        return true;
    }

    protected function signUpAction() : bool
    {
        $cellphone = $this->getRequest()->post('cellphone', '');
        $password = $this->getRequest()->post('password', '');
        $phrase = $this->getRequest()->post('phrase', '');

        if ($this->validateSignUpScenario(
            $cellphone,
            $password,
            $phrase
        )) {
            $commandBus = new CommandBus(new UserCommandHandlerFactory());
            $command = new SignUpUserCommand(
                $cellphone,
                $password
            );
            if ($commandBus->send($command)) {
                $this->message('sign up success', 'sign up success');
            }
        }

        $this->displayError();
        return false;
    }

    private function validateSignUpScenario(
        string $cellphone,
        string $password,
        string $phrase
    ) {
        return $this->validateCsrfToken()
            && $this->validateCaptcha($phrase)
            && InputWidgetRules::cellphone($cellphone)
            && InputWidgetRules::password($password);
    }

    public function signIn()
    {
        if ($this->getRequest()->isGetMethod()) {
            return $this->signInView();
        }

        return $this->signInAction();
    }

    protected function signInView() : bool
    {
        $this->getResponse()->view(new SignInView())->render();
        return true;
    }

    protected function signInAction() : bool
    {
        $cellphone = $this->getRequest()->post('cellphone', '');
        $password = $this->getRequest()->post('password', '');
        $phrase = $this->getRequest()->post('phrase', '');

        if ($this->validateSignInScenario(
            $cellphone,
            $password,
            $phrase
        )) {
            $commandBus = new CommandBus(new UserCommandHandlerFactory());
            $command = new SignInUserCommand(
                $cellphone,
                $password
            );
            if ($commandBus->send($command)) {
                var_dump(Core::$container->get('user'));
                return true;
            }
        }

        $this->displayError();
        return false;
    }

    private function validateSignInScenario(
        string $cellphone,
        string $password,
        string $phrase
    ) {
        return true;
        return $this->validateCsrfToken()
            && $this->validateCaptcha($phrase)
            && InputWidgetRules::cellphone($cellphone)
            && InputWidgetRules::password($password);
    }

    public function signOut()
    {
        $commandBus = new CommandBus(new UserCommandHandlerFactory());
        if ($commandBus->send(new SignOutUserCommand())) {
            var_dump('logout');
            return true;
        }
    }
}
