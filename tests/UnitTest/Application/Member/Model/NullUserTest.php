<?php
namespace Member\Model;

use Marmot\Core;
use PHPUnit\Framework\TestCase;

use Member\Model\User;

class NullUserTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new NullUser();
    }

    public function testImplementINull()
    {
        $this->assertInstanceOf(
            'System\Interfaces\INull',
            $this->stub
        );
    }

    public function testSignUp()
    {
        $this->assertFalse($this->stub->signUp());
    }

    public function testSignOut()
    {
        $this->assertFalse($this->stub->signOut());
    }

    public function testUpdatePassword()
    {
        $this->assertFalse($this->stub->UpdatePassword());
    }
}
