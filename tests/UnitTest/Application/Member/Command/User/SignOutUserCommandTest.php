<?php
namespace Member\Command\User;

use PHPUnit\Framework\TestCase;

class SignOutUserCommandTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new SignOutUserCommand();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testCorrectInstanceImplementsCommand()
    {
        $this->assertInstanceof('System\Interfaces\ICommand', $this->stub);
    }
}
