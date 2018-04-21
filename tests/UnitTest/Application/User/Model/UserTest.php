<?php
namespace User\Model;

use Marmot\Core;
use PHPUnit\Framework\TestCase;

use Member\Model\User;

/**
 * User\Model\User.class.php 测试文件
 * @author chloroplast
 * @version 1.0.0:2016.04.19
 */

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        $this->user = $this->getMockBuilder('User\Model\User')
                      ->getMockForAbstractClass();
    }

    public function tearDown()
    {
        unset($this->user);
    }

    /**
     * User 网店用户领域对象,测试构造函数
     */
    public function testUserConstructor()
    {
        $this->assertEquals(0, $this->user->getId());

        //测试初始化用户手机号
        $this->assertEmpty($this->user->getCellphone());

        //测试初始化昵称
        $this->assertEmpty($this->user->getNickName());

        //测试初始化用户名预留字段
        $this->assertEmpty($this->user->getUserName());

        //测试初始化用户密码
        $this->assertEmpty($this->user->getPassword());

        //测试初始化更新时间
        $this->assertEquals(0, $this->user->getUpdateTime());

        //测试初始化更新时间
        $this->assertEquals(0, $this->user->getStatusTime());

        //测试初始化status
        $this->assertEquals(0, $this->user->getStatus());
    }

    public function testSetId()
    {
        $this->user->setId(1);
        $this->assertEquals(1, $this->user->getId());
    }
    //cellphone 测试 --------------------------------------------------- start
    /**
     * 设置 User setCellphone() 正确的传参类型,期望传值正确
     */
    public function testSetCellphoneCorrectType()
    {
        $this->user->setCellphone('15202939435');
        $this->assertEquals('15202939435', $this->user->getCellphone());
    }
    
    /**
     * 设置 User setCellphone() 正确的传参类型,但是不属于手机格式,期望返回空.
     */
    public function testSetCellphoneCorrectTypeButNotEmail()
    {
        $this->user->setCellphone('15202939435'.'a');
        $this->assertEquals('', $this->user->getCellphone());
    }
    //cellphone 测试 ---------------------------------------------------   end

    //nickName 测试 ---------------------------------------------------- start
    /**
     * 设置 User setNickName() 正确的传参类型,期望传值正确
     */
    public function testSetNickNameCorrectType()
    {
        $this->user->setNickName('string');
        $this->assertEquals('string', $this->user->getNickName());
    }

    /**
     * 设置 User setNickName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNickNameWrongType()
    {
        $this->user->setNickName(array(1,2,3));
    }
    //nickName 测试 ----------------------------------------------------   end

    //userName 测试 ---------------------------------------------------- start
    /**
     * 设置 User setUserName() 正确的传参类型,期望传值正确
     */
    public function testSetUserNameCorrectType()
    {
        $this->user->setUserName('string');
        $this->assertEquals('string', $this->user->getUserName());
    }

    /**
     * 设置 User setUserName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetUserNameWrongType()
    {
        $this->user->setUserName(array(1,2,3));
    }
    //userName 测试 ----------------------------------------------------   end

    //password 测试 ---------------------------------------------------- start
    /**
     * 设置 User setPassword() 正确的传参类型,期望传值正确
     */
    public function testSetPasswordCorrectType()
    {
        $this->user->setPassword('string');
        $this->assertEquals('string', $this->user->getPassword());
    }

    /**
     * 设置 User setPassword() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetPasswordWrongType()
    {
        $this->user->setPassword(array(1,2,3));
    }
    //password 测试 ----------------------------------------------------   end
}
