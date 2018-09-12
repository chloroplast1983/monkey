<?php
namespace Member\Controller;

use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new UserController();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testCorrectExtendsController()
    {
        $controller = new UserController();
        $this->assertInstanceof('System\Classes\Controller', $controller);
    }
}
