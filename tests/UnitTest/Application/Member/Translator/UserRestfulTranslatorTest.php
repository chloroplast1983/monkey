<?php
namespace Member\Translator;

use Member\Model\User;
use Member\Model\NullUser;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use UserGroup\Model\UserGroup;
use UserGroup\Translator\UserGroupRestfulTranslator;

class UserRestfulTranslatorTest extends TestCase
{
    private $translator;
    private $childTranslator;

    public function setUp()
    {
        $this->translator = $this->getMockBuilder(UserRestfulTranslator::class)
            ->setMethods(['getUserGroupRestfulTranslator'])
            ->getMock();
        parent::setUp();
    }

    public function testArrayToObjectCorrectObject()
    {
        $crew = \Member\Utils\ArrayGenerate::generateCrew();

        $data =  $crew['data'];
        $relationships = $data['relationships'];

        $actual = $this->translator->arrayToObject($crew);

        $expectObject = new User();
        $expectObject->setId($data['id']);

        $attributes = $data['attributes'];

        if (isset($attributes['cellphone'])) {
            $expectObject->setCellphone($attributes['cellphone']);
        }
        if (isset($attributes['nickName'])) {
            $expectObject->setNickName($attributes['nickName']);
        }
        if (isset($attributes['userName'])) {
            $expectObject->setUserName($attributes['userName']);
        }
        if (isset($attributes['password'])) {
            $expectObject->setPassword($attributes['password']);
        }
        if (isset($attributes['avatar'])) {
            $expectObject->setAvatar($attributes['avatar']);
        }
        if (isset($attributes['createTime'])) {
            $expectObject->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $expectObject->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $expectObject->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $expectObject->setStatusTime($attributes['statusTime']);
        }

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $crew = \Member\Utils\ArrayGenerate::generateCrew();
        $data =  $crew['data'];
        $relationships = $data['relationships'];

        $actual = $this->translator->arrayToObjects($crew);
        $expectArray = array();


        $expectObject = new User();
        $expectObject->setId($data['id']);

        $attributes = $data['attributes'];
    
        if (isset($attributes['cellphone'])) {
            $expectObject->setCellphone($attributes['cellphone']);
        }
        if (isset($attributes['nickName'])) {
            $expectObject->setNickName($attributes['nickName']);
        }
        if (isset($attributes['userName'])) {
            $expectObject->setUserName($attributes['userName']);
        }
        if (isset($attributes['password'])) {
            $expectObject->setPassword($attributes['password']);
        }
        if (isset($attributes['avatar'])) {
            $expectObject->setAvatar($attributes['avatar']);
        }
        if (isset($attributes['createTime'])) {
            $expectObject->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $expectObject->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $expectObject->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $expectObject->setStatusTime($attributes['statusTime']);
        }

        $expectArray = [1, [$data['id']=>$expectObject]];

        $this->assertEquals($expectArray, $actual);
    }

    public function testArrayToObjectsCorrectObject()
    {
        $crew[] = \Member\Utils\ArrayGenerate::generateCrew(1);
        $crew[] = \Member\Utils\ArrayGenerate::generateCrew(2);

        $crewArray= array('data'=>array(
            $crew[0]['data'],
            $crew[1]['data']
        ));

        $expectArray = array();
        $results = array();

        foreach ($crewArray['data'] as $each) {
            $data =  $each;
            $relationships = $data['relationships'];

            $expectObject = new User();
            $expectObject->setId($data['id']);

            $attributes = $data['attributes'];

            if (isset($attributes['cellphone'])) {
                $expectObject->setCellphone($attributes['cellphone']);
            }
            if (isset($attributes['nickName'])) {
                $expectObject->setNickName($attributes['nickName']);
            }
            if (isset($attributes['userName'])) {
                $expectObject->setUserName($attributes['userName']);
            }
            if (isset($attributes['password'])) {
                $expectObject->setPassword($attributes['password']);
            }
            if (isset($attributes['avatar'])) {
                $expectObject->setAvatar($attributes['avatar']);
            }
            if (isset($attributes['createTime'])) {
                $expectObject->setCreateTime($attributes['createTime']);
            }
            if (isset($attributes['updateTime'])) {
                $expectObject->setUpdateTime($attributes['updateTime']);
            }
            if (isset($attributes['status'])) {
                $expectObject->setStatus($attributes['status']);
            }
            if (isset($attributes['statusTime'])) {
                $expectObject->setStatusTime($attributes['statusTime']);
            }

            $results[$data['id']] = $expectObject;
        }
 
        $actual = $this->translator->arrayToObjects($crewArray);

        $expectArray = [2, $results];

        $this->assertEquals($expectArray, $actual);
    }
    /**
     * 如果传参错误对象, 期望返回空数组
     */
    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->translator->objectToArray(null);
        $this->assertEquals(array(), $result);
    }
    /**
     * 传参正确对象, 返回对应数组
     */
    public function testObjectToArrayCorrectObject()
    {
        $crew = \Member\Utils\ObjectGenerate::generateCrew(1, 1);

        $actual = $this->translator->objectToArray($crew);

        $expectedArray = array(
            'data'=>array(
                'type'=>'users',
                'id'=>$crew->getId()
            )
        );

        $expectedArray['data']['attributes'] = array(
            'userName'=>$crew->getUserName(),
            'cellphone'=>$crew->getCellphone(),
            'nickName'=>$crew->getNickName(),
            'password'=>$crew->getPassword(),
        );

        $role = array();

        $this->assertEquals($expectedArray, $actual);
    }
}
