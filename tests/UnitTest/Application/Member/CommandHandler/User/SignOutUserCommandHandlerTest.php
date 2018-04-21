<?php
namespace Member\CommandHandler\User;

use System\Interfaces\ICommandHandler;
use System\Interfaces\ICommand;
use System\Interfaces\INull;

use Member\Command\User\SignOutUserCommand;
use Member\Model\User;

use PHPUnit\Framework\TestCase;

class SignOutUserCommandHandlerTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new SignOutUserCommandHandler();
    }

    public function testImplementsICommandHandler()
    {
        $this->assertInstanceOf(
            'System\Interfaces\ICommandHandler',
            $this->stub
        );
    }
}
