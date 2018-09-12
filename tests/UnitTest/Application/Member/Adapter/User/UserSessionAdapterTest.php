<?php
namespace Member\Adapter\User;

use PHPUnit\Framework\TestCase;

use Member\Model\User;
use Member\Model\NullUser;
use Member\Adapter\User\Query\UserSessionDataCacheQuery;
use Member\Translator\UserSessionTranslator;

use Prophecy\Argument;

class UserSessionAdapterTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(UserSessionAdapter::class)
            ->setMethods(
                [
                    'fetchOneAction',
                    'isSuccess',
                    'post',
                    'patch',
                    'arrayToObject',
                    'objectToArray',
                    'getTranslator',
                    'getSession'
                ]
            )->getMock();

        $this->childStub = new class extends UserSessionAdapter
        {
            public function getSession() : UserSessionDataCacheQuery
            {
                return parent::getSession();
            }

            public function getTranslator() : UserSessionTranslator
            {
                return parent::getTranslator();
            }

            public function getTTL() : int
            {
                return parent::getTTL();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Member\Translator\UserSessionTranslator',
            $this->childStub->getTranslator()
        );
    }

    public function testGetSession()
    {
        $this->assertInstanceOf(
            'Member\Adapter\User\Query\UserSessionDataCacheQuery',
            $this->childStub->getSession()
        );
    }

    public function testGet()
    {
        $infoArray = \Member\Utils\ArrayGenerate::generateCrew();
        $info = $this->prophesize(UserSessionDataCacheQuery::class);
        $info->get(Argument::exact($infoArray['data']['id']))->shouldBeCalledTimes(1)->willReturn($infoArray);
        $this->stub->expects($this->exactly(1))
            ->method('getSession')
            ->willReturn($info->reveal());

        $crew = \Member\Utils\ObjectGenerate::generateCrew($infoArray['data']['id'], 0, $infoArray);

        $translator = $this->prophesize(UserSessionTranslator::class);
        $translator->arrayToObject(Argument::exact($infoArray))->shouldBeCalledTimes(1)->willReturn($crew);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());

        $result = $this->stub->get($infoArray['data']['id']);

        $this->assertEquals($crew, $result);
    }

    public function testSaveTrue()
    {
        $infoArray = \Member\Utils\ArrayGenerate::generateCrew();
        $crew = \Member\Utils\ObjectGenerate::generateCrew($infoArray['data']['id'], 0, $infoArray);

        $translator = $this->prophesize(UserSessionTranslator::class);
        $translator->objectToArray(Argument::exact($crew))->shouldBeCalledTimes(1)->willReturn($infoArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());

        $session = $this->prophesize(UserSessionDataCacheQuery::class);
        $session->save(
            Argument::exact($crew->getId()),
            Argument::exact($infoArray),
            Argument::exact($this->childStub->getTTL())
        )->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getSession')
            ->willReturn($session->reveal());

        $result = $this->stub->add($crew);

        $this->assertTrue($result);
    }

    public function testSaveFalse()
    {
        $infoArray = \Member\Utils\ArrayGenerate::generateCrew();
        $crew = \Member\Utils\ObjectGenerate::generateCrew($infoArray['data']['id'], 0, $infoArray);

        $translator = $this->prophesize(UserSessionTranslator::class);
        $translator->objectToArray(Argument::exact($crew))->shouldBeCalledTimes(1)->willReturn($infoArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());

        $session = $this->prophesize(UserSessionDataCacheQuery::class);
        $session->save(
            Argument::exact($crew->getId()),
            Argument::exact($infoArray),
            Argument::exact($this->childStub->getTTL())
        )->shouldBeCalledTimes(1)->willReturn(false);

        $this->stub->expects($this->exactly(1))
            ->method('getSession')
            ->willReturn($session->reveal());

        $result = $this->stub->add($crew);

        $this->assertFalse($result);
    }

    public function testDelTrue()
    {
        $infoArray = \Member\Utils\ArrayGenerate::generateCrew();
        $info = $this->prophesize(UserSessionDataCacheQuery::class);
        $info->del(Argument::exact($infoArray['data']['id']))->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getSession')
            ->willReturn($info->reveal());

        $result = $this->stub->del($infoArray['data']['id']);

        $this->assertTrue($result);
    }

    public function testDelFalse()
    {
        $infoArray = \Member\Utils\ArrayGenerate::generateCrew();
        $info = $this->prophesize(UserSessionDataCacheQuery::class);
        $info->del(Argument::exact($infoArray['data']['id']))->shouldBeCalledTimes(1)->willReturn(false);
        $this->stub->expects($this->exactly(1))
            ->method('getSession')
            ->willReturn($info->reveal());

        $result = $this->stub->del($infoArray['data']['id']);

        $this->assertFalse($result);
    }
}
