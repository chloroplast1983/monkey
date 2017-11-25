<?php
namespace User\Model;

use Marmot\Core;
use PHPUnit\Framework\TestCase;

/**
 * User\Model\User.class.php 测试文件
 * @author chloroplast
 * @version 1.0.0:2016.04.19
 */

class UserTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder('User\Model\User')
                      ->getMockForAbstractClass();
    }

    /**
     * User 网店用户领域对象,测试构造函数
     */
    public function testUserConstructor()
    {
//        //测试初始化网店用户id
//        $idParameter = $this->getPrivateProperty('User\Model\User', 'id');
//        $this->assertEquals(0, $idParameter->getValue($this->stub));
//
//        //测试初始化用户手机号
//        $cellPhoneParameter = $this->getPrivateProperty('User\Model\User', 'cellPhone');
//        $this->assertEmpty($cellPhoneParameter->getValue($this->stub));
//
//        //测试初始化昵称
//        $nickNameParameter = $this->getPrivateProperty('User\Model\User', 'nickName');
//        $this->assertEmpty($nickNameParameter->getValue($this->stub));
//
//        //测试初始化用户名预留字段
//        $userNameParameter = $this->getPrivateProperty('User\Model\User', 'userName');
//        $this->assertEmpty($userNameParameter->getValue($this->stub));
//
//        //测试初始化用户密码
//        $passwordParameter = $this->getPrivateProperty('User\Model\User', 'password');
//        $this->assertEmpty($passwordParameter->getValue($this->stub));
//
//        //测试初始化注册时间
//        $createTimeParameter = $this->getPrivateProperty('User\Model\User', 'createTime');
//        $this->assertEquals(0, $createTimeParameter->getValue($this->stub));
//
//        //测试初始化更新时间
//        $updateTimeParameter = $this->getPrivateProperty('User\Model\User', 'updateTime');
//        $this->assertEquals(0, $updateTimeParameter->getValue($this->stub));
//
//        //测试初始化更新时间
//        $updateTimeParameter = $this->getPrivateProperty('User\Model\User', 'statusTime');
//        $this->assertEquals(0, $updateTimeParameter->getValue($this->stub));
    }

    //cellPhone 测试 --------------------------------------------------- start
    /**
     * 设置 User setCellPhone() 正确的传参类型,期望传值正确
     */
    public function testSetCellPhoneCorrectType()
    {
        $this->stub->setCellPhone('15202939435');
        $this->assertEquals('15202939435', $this->stub->getCellPhone());
    }

    /**
     * 设置 User setCellPhone() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCellPhoneWrongType()
    {
        $this->stub->setCellPhone(array(1,2,3));
    }

    /**
     * 设置 User setCellPhone() 正确的传参类型,但是不属于手机格式,期望返回空.
     */
    public function testSetCellPhoneCorrectTypeButNotEmail()
    {
        $this->stub->setCellPhone('15202939435'.'a');
        $this->assertEquals('', $this->stub->getCellPhone());
    }
    //cellPhone 测试 ---------------------------------------------------   end

    //nickName 测试 ---------------------------------------------------- start
    /**
     * 设置 User setNickName() 正确的传参类型,期望传值正确
     */
    public function testSetNickNameCorrectType()
    {
        $this->stub->setNickName('string');
        $this->assertEquals('string', $this->stub->getNickName());
    }

    /**
     * 设置 User setNickName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNickNameWrongType()
    {
        $this->stub->setNickName(array(1,2,3));
    }
    //nickName 测试 ----------------------------------------------------   end

    //userName 测试 ---------------------------------------------------- start
    /**
     * 设置 User setUserName() 正确的传参类型,期望传值正确
     */
    public function testSetUserNameCorrectType()
    {
        $this->stub->setUserName('string');
        $this->assertEquals('string', $this->stub->getUserName());
    }

    /**
     * 设置 User setUserName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetUserNameWrongType()
    {
        $this->stub->setUserName(array(1,2,3));
    }
    //userName 测试 ----------------------------------------------------   end

    //password 测试 ---------------------------------------------------- start
    /**
     * 设置 User setPassword() 正确的传参类型,期望传值正确
     */
    public function testSetPasswordCorrectType()
    {
        $this->stub->setPassword('string');
        $this->assertEquals('string', $this->stub->getPassword());
    }

    /**
     * 设置 User setPassword() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetPasswordWrongType()
    {
        $this->stub->setPassword(array(1,2,3));
    }
    //password 测试 ----------------------------------------------------   end
}
