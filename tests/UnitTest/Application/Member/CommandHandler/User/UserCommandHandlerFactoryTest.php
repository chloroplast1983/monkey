<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandlerFactory;
use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use System\Classes\NullCommandHandler;

use Member\Command\User\SignUpUserCommand;
use Member\Command\User\AuthUserCommand;
use Member\Command\User\SignInUserCommand;
use Member\Command\User\SignOutUserCommand;

use PHPUnit\Framework\TestCase;

class UserCommandHandlerFactoryTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new UserCommandHandlerFactory();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testImplementsICommandHandlerFactory()
    {
        $this->assertInstanceof(
            'System\Interfaces\ICommandHandlerFactory',
            $this->stub
        );
    }

    /**
     * @dataProvider commandHandlerProvider
     */
    public function testGetCommandHandler($command, $commandHandlerClass)
    {
        $commandHandler = $this->stub->getHandler(
            $command
        );

        $this->assertInstanceof(
            $commandHandlerClass,
            $commandHandler
        );
    }
    
    public function commandHandlerProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $defaultCommand = new class implements ICommand {
        };

        return [
            [
                new SignUpUserCommand(
                    $faker->phoneNumber,
                    $faker->password,
                    $faker->randomNumber(1)
                ),
                'Member\CommandHandler\User\SignUpUserCommandHandler'
            ],
            [
                new AuthUserCommand(
                    $faker->randomNumber(1)
                ),
                'Member\CommandHandler\User\AuthUserCommandHandler'
            ],
            [
                new SignInUserCommand(
                    $faker->phoneNumber,
                    $faker->password
                ),
                'Member\CommandHandler\User\SignInUserCommandHandler'
            ],
            [
                new SignOutUserCommand(
                    $faker->phoneNumber,
                    $faker->password
                ),
                'Member\CommandHandler\User\SignOutUserCommandHandler'
            ],
            [
                $defaultCommand,
                'System\Classes\NullCommandHandler'
            ]
        ];
    }
}
