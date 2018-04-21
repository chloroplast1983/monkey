<?php
namespace Member\CommandHandler\User;

use PHPUnit\Framework\TestCase;

use Member\Repository\User\UserSessionRepository;
use Member\Repository\User\UserRepository;
use Member\Model\User;

class AuthUserCommandHandlerTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(AuthUserCommandHandler::class)
                           ->setMethods(['getUserSessionRepository','getUserRepository'])
                           ->getMock();

        $this->childStub = new class extends AuthUserCommandHandler{
            public function getUserSessionRepository() : UserSessionRepository
            {
                return parent::getUserSessionRepository();
            }
            public function getUserRepository() : UserRepository
            {
                return parent::getUserRepository();
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

    public function testGetUserSessionRepository()
    {
        $this->assertInstanceOf(
            'Member\Repository\User\UserSessionRepository',
            $this->childStub->getUserSessionRepository()
        );
    }

    public function testGetUserRepository()
    {
        $this->assertInstanceOf(
            'Member\Repository\User\UserRepository',
            $this->childStub->getUserRepository()
        );
    }
}
