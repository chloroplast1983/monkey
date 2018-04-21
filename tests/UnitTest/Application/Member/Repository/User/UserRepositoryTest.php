<?php
namespace Member\Repository\User;

use Member\Adapter\User\UserRestfulAdapter;
use Member\Model\User;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class UserRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(UserRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends UserRepository {
            public function getAdapter() : UserRestfulAdapter
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
            'Member\Adapter\User\UserRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }

    public function testScenario()
    {
        $adapter = $this->prophesize(UserRestfulAdapter::class);
        $adapter->scenario(Argument::exact(UserRepository::LIST_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(UserRepository::LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }


    public function testAdd()
    {
        $id = 1;
        $crew = new User($id);

        $adapter = $this->prophesize(UserRestfulAdapter::class);
        $adapter->signUp(Argument::exact($crew))->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->add($crew);
        $this->assertTrue($result);
    }

    public function testSignIn()
    {
        $id = 1;
        $crew = new User($id);

        $adapter = $this->prophesize(UserRestfulAdapter::class);
        $adapter->signIn(Argument::exact($crew))->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->signIn($crew);
        $this->assertTrue($result);
    }

    public function testFetchOne()
    {
        $id = 1;
        $crew = new User($id);

        $adapter = $this->prophesize(UserRestfulAdapter::class);
        $adapter->fetchOne(Argument::exact($id))->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->fetchOne($id);
        $this->assertInstanceOf('Member\Model\User', $result);
    }

    public function testFetchList()
    {
        $ids = [1,2,3,4,5,6,7,8,9,10];
        $includeList = array();

        $adapter = $this->prophesize(UserRestfulAdapter::class);
        $adapter->fetchList(Argument::exact($ids))->shouldBeCalledTimes(1)->willReturn($includeList);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $this->stub->setAdapter($adapter->reveal());

        $this->stub->fetchList($ids, $includeList);
    }

      /**
     * 测试仓库根据检索条件获取数据
     */
    // public function testSearch()
    // {
    //     $filter = array('name'=>'test');
    //     $sort = array();
    //     $offset = 10;
    //     $size = 10;

    //     $adapter = $this->prophesize(UserRestfulAdapter::class);
    //     $adapter->search(
    //         Argument::exact($filter),
    //         Argument::exact($sort),
    //         Argument::exact($offset),
    //         Argument::exact($size)
    //     )->shouldBeCalledTimes(1);

    //     $this->stub->setAdapter($adapter->reveal());

    //     $this->stub->search(array('name'=>'test'), array(), 10,10);
    // }
}
