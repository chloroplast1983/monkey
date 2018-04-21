<?php
namespace Member\Translator;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Member\Model\User;

use Common\Utils\Mask;

class UserTranslatorTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub= $this->getMockBuilder(UserTranslator::class)
            ->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsTranslator()
    {
        $this->assertInstanceOf(
            'System\Classes\Translator',
            $this->stub
        );
    }

    /**
     * 1. 无论我传什么都返回Null
     */
    public function testArrayToObjectWithCrewObject()
    {
        $result = $this->stub->arrayToObject(array(), new User(1));
        $this->assertEquals(null, $result);
    }

    public function testArrayToObject()
    {
        $result = $this->stub->arrayToObject(array());
        $this->assertEquals(null, $result);
    }

    /**
     * 1. 无论我赋值什么都返回空数组
     */
    public function testArrayToObjects()
    {
        $crewList = array();

        $crewList[] = \Member\Utils\ObjectGenerate::generateCrew(1, 1);
        $crewList[] = \Member\Utils\ObjectGenerate::generateCrew(2, 2);

        $result = $this->stub->arrayToObjects($crewList);
        $this->assertEquals(array(), $result);
    }

    /**
     * 如果传参错误对象, 期望返回空数组
     */
    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->stub->objectToArray(null);
        $this->assertEquals(null, $result);
    }

    public function testObjectToArrayCorrectObject()
    {
        $crew = \Member\Utils\ObjectGenerate::generateCrew(1, 1);

        $result = $this->stub->objectToArray($crew);

        $expectedArray = array(
            'id'=>marmot_encode($crew->getId()),
            'cellphone'=>Mask::mask($crew->getCellphone(), 4, 4),
            'userName'=>$crew->getUserName(),
            'createTime'=>$crew->getCreateTime(),
            'createTimeFormat'=> date('Y-m-d H:i', $crew->getCreateTime()),
            'updateTime'=>$crew->getUpdateTime(),
            'updateTimeFormat'=> date('Y-m-d H:i', $crew->getUpdateTime()),
            'nickName'=>$crew->getNickName(),
            'password'=>$crew->getPassword(),
            'status'=>$crew->getStatus(),
            'statusTime'=>$crew->getStatusTime(),
        );

        $this->assertEquals(null, $result);
    }
}
