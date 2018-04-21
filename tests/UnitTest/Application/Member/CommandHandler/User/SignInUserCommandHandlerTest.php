<?php
namespace Member\CommandHandler\User;

use Member\Utils\ObjectGenerate;

use PHPUnit\Framework\TestCase;

use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use System\Interfaces\INull;

use Member\Model\User;
use Member\Command\User\SignInUserCommand;

class SignInCrewCommandHandlerTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(SignInUserCommandHandler::class)
                           ->setMethods(['getUser'])
                           ->getMock();

        $this->childStub = new class extends SignInUserCommandHandler{
            public function getUser() : User
            {
                return parent::getUser();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testImplementsICommandHandler()
    {
        $this->assertInstanceOf(
            'System\Interfaces\ICommandHandler',
            $this->stub
        );
    }

    public function testGetUser()
    {
        $this->assertInstanceOf(
            'Member\Model\User',
            $this->childStub->getUser()
        );
    }
}
