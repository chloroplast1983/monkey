<?php
namespace Member\CommandHandler\User;

use PHPUnit\Framework\TestCase;
use System\Interfaces\ICommand;

use Member\Model\User;
use Member\Command\User\SignUpUserCommand;

use Prophecy\Argument;

class SignUpUserCommandHandlerTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(SignUpUserCommandHandler::class)
            ->setMethods(['getCrew','getUserGroupRepository'])
            ->getMock();

        $this->childStub = new class extends SignUpUserCommandHandler{
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

    public function testGetUser()
    {
        $this->assertInstanceOf(
            'Member\Model\User',
            $this->childStub->getUser()
        );
    }

    /**
     * 1. 声明一个SignUpUserCommand命令
     * 2. 预测一个用户对象
     *  2.1 给他设置手机号,且手机号= SignUpUserCommand->cellPhone
     *  2.1 给他设置密码, 且密码 = SignUpUserCommand->password
     * 3. 模拟$user->signUp() 返回 false
     * 4. $command->uid = 0
     * 5. $user->getId() 因为注册失败, 所以不应该调用
     */
    public function testUserSignUpFailure()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed(1);

        $phoneNumber = $faker->phoneNumber;
        $password = $faker->password;

        $command = new SignUpUserCommand(
            $phoneNumber,
            $password
        );

        $user = $this->prophesize(User::class);
        $user->setCellPhone(
            Argument::exact($phoneNumber)
        )->shouldBeCalledTimes(1);
        $user->setPassword(
            Argument::exact($password)
        )->shouldBeCalledTimes(1);
        $user->getId()->shouldNotBeCalled();

        $user->signUp()->shouldBeCalledTimes(1)->willReturn(false);

        $this->commandHandler = $this->getMockBuilder(SignUpUserCommandHandler::class)
                                     ->setMethods(['getUser'])
                                     ->getMock();

        $this->commandHandler->expects($this->once())
                             ->method('getUser')
                             ->willReturn($user->reveal());

        $result = $this->commandHandler->execute($command);
        
        $this->assertEquals(0, $command->uid);
        $this->assertFalse($result);
    }
}
