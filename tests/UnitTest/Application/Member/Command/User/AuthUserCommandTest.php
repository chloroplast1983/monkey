<?php
namespace Member\Command\User;

use PHPUnit\Framework\TestCase;

class AuthUserCommandTest extends TestCase
{
    private $stub;

    private $fakerData = array();

    public function setUp()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $this->fakerData = array(
            'uid' => $faker->randomNumber(1),
        );

        $this->stub = new AuthUserCommand(
            $this->fakerData['uid']
        );
    }

    public function tearDown()
    {
        unset($this->fakerData);
        unset($this->stub);
    }

    public function testCorrectInstanceImplementsCommand()
    {
        $this->assertInstanceof('System\Interfaces\ICommand', $this->stub);
    }

    public function testUidParameter()
    {
        $this->assertEquals($this->fakerData['uid'], $this->stub->uid);
    }
}
