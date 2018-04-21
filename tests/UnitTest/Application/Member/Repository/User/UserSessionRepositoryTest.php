<?php
namespace Member\Repository\User;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Member\Adapter\User\UserSessionAdapter;
use Member\Model\User;

class UserSessionRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(UserSessionRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends UserSessionRepository {
            public function getAdapter() : UserSessionAdapter
            {
                return parent::getAdapter();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetAdapter()
    {
        $this->assertInstanceOf(
            'Member\Adapter\User\UserSessionAdapter',
            $this->childStub->getAdapter()
        );
    }

    public function testAdd()
    {
        $crew = new User();
        $adapter = $this->prophesize(UserSessionAdapter::class);
        $adapter->add(Argument::exact($crew))->shouldBeCalledTimes(1)->willReturn(true);
        
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->add($crew);
        $this->assertTrue($result);
    }

    public function testGet()
    {
        $id = 1;
        $crew = new User($id);
        $adapter = $this->prophesize(UserSessionAdapter::class);
        $adapter->get(Argument::exact($id))->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $this->assertEquals($crew, $this->stub->get($id));
    }
    
    public function testClear()
    {
        $id = 1;
        $adapter = $this->prophesize(UserSessionAdapter::class);
        $adapter->del(Argument::exact($id))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->clear($id);
        $this->assertTrue($result);
    }
}
