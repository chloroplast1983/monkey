<?php
namespace Member\Controller;

use PHPUnit\Framework\TestCase;

use System\Classes\CommandBus;
use System\Classes\Request;
use System\Classes\Response;
use Prophecy\Argument;

use Member\Command\User\SignUpUserCommand;
use Member\Command\User\SignInUserCommand;
use Member\Command\User\SignOutUserCommand;

class UserSignControllerTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(UserSignController::class)
                ->setMethods([
                    'getRequest',
                    'getResponse',
                    'signUpView',
                    'signUpAction',
                    'isGetMethod',
                    'signInView',
                    'signInAction',
                    'validateSignInScenario',
                ])
                ->getMock();
        $this->childStub = new class extends UserSignController
        {
            public function signUpView() : bool
            {
                return parent::signUpView();
            }

            public function signUpAction() : bool
            {
                return parent::signUpAction();
            }
            public function signInView() : bool
            {
                return parent::signInView();
            }
            public function signInAction() : bool
            {
                return parent::signInAction();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testExtendsController()
    {
         $this->assertInstanceOf(
             'System\Classes\Controller',
             $this->stub
         );
    }
}
