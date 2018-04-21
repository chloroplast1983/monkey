<?php
namespace Member\Command\User;

use PHPUnit\Framework\TestCase;

class SignInUserCommandTest extends TestCase
{
    private $stub;

    private $fakerData = array();

    public function setUp()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $this->fakerData = array(
            'cellphone' => $faker->phoneNumber,
            'password' => $faker->password
        );

        $this->stub = new SignInUserCommand(
            $this->fakerData['cellphone'],
            $this->fakerData['password']
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

    public function testCellphoneParameter()
    {
        $this->assertEquals($this->fakerData['cellphone'], $this->stub->cellphone);
    }

    public function testPasswordParameter()
    {
        $this->assertEquals($this->fakerData['password'], $this->stub->password);
    }
}
