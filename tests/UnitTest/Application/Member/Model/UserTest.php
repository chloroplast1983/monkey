<?php
namespace Member\Model;

use Marmot\Core;
use PHPUnit\Framework\TestCase;

use Member\Repository\User\UserRepository;
use Member\Repository\User\UserSessionRepository;

use Member\Model\User;

use Prophecy\Argument;

class UserTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder('Member\Model\User')
                ->setMethods(['getUserRepository','getUserSessionRepository'])
                      ->getMockForAbstractClass();
        $this->childStub = new class extends User
        {
            public function getUserRepository(): UserRepository
            {
                return parent::getUserRepository();
            }
            public function getUserSessionRepository() : UserSessionRepository
            {
                return parent::getUserSessionRepository();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testGetUserRepository()
    {
        $this->assertInstanceOf(
            'Member\Repository\User\UserRepository',
            $this->childStub->getUserRepository()
        );
    }

    public function testGetCrewSessionRepository()
    {
        $this->assertInstanceOf(
            'Member\Repository\User\UserSessionRepository',
            $this->childStub->getUserSessionRepository()
        );
    }
  
    public function testSignUp()
    {
        $repository = $this->prophesize(UserRepository::class);
        $repository->add(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getUserRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->signUp();
        $this->assertTrue($result);
    }

    public function testSignUpFailure()
    {
        $repository = $this->prophesize(UserRepository::class);
        $repository->add(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(false);

        $this->stub->expects($this->exactly(1))
            ->method('getUserRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->signUp();
        $this->assertFalse($result);
    }

    public function testSignInFailure()
    {
        $repository = $this->prophesize(UserRepository::class);
        $repository->signIn(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(false);

        $this->stub->expects($this->exactly(1))
            ->method('getUserRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->signIn();
        $this->assertFalse($result);
    }
}
