<?php
namespace Member\Model;

use tests\GenericTestCase;

use Marmot\Core;

/**
 * Member\Model\User.class.php 测试文件
 * @author chloroplast
 * @version 1.0.0:2017.11.25
 */

class UserTest extends GenericTestCase
{
	private $stub;

	public function setUp()
	{
		$this->stub = new User();
	}

	/**
	 * User 用户领域对象,测试构造函数
	 */
	public function testUserConstructor(){
		//测试初始化用户id
		$this->assertEquals(0,$this->stub->getId());

		//测试初始化用户名字
		$this->assertEmpty($this->stub->getName());

		//测试初始化用户手机号
		$this->assertEmpty($this->stub->getCellphone());

		//测试初始化用户qq
		$this->assertEmpty($this->stub->getQq());

		//测试初始化用户邮箱
		$this->assertEmpty($this->stub->getEmail());

		//测试初始化用户注册时间
		$this->assertEquals(Core::$container->get('time'),$this->stub->getCreateTime());

		//测试初始化用户状态
		$this->assertEquals(User::STATUS_ENABLE,$this->stub->getStatus());

	}


	//id 测试 ---------------------------------------------------------- start
	/**
	 * 设置 User setId() 正确的传参类型,期望传值正确
	 */
	public function testSetIdCorrectType()
	{
		$this->stub->setId(1);
		$this->assertEquals(1,$this->stub->getId());
	}

	/**
	 * 设置 User setId() 错误的传参类型,期望期望抛出TypeError exception
	 *
	 * @expectedException TypeError 
	 */
	public function testSetIdWrongType()
	{
		$this->stub->setId('string');
	}

	/**
	 * 设置 User setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
	 */
	public function testSetIdWrongTypeButNumeric()
	{
		$this->stub->setId('1');
		$this->assertTrue(is_int($this->stub->getId()));
		$this->assertEquals(1,$this->stub->getId());
	}
	//id 测试 ----------------------------------------------------------   end

	//name 测试 -------------------------------------------------------- start
	/**
	 * 设置 User setName() 正确的传参类型,期望传值正确
	 */
	public function testSetNameCorrectType()
	{
		$this->stub->setName('string');
		$this->assertEquals('string',$this->stub->getName());
	}

	/**
	 * 设置 User setName() 错误的传参类型,期望期望抛出TypeError exception
	 *
	 * @expectedException TypeError 
	 */
	public function testSetNameWrongType()
	{
		$this->stub->setName(array(1,2,3));
	}
	//name 测试 --------------------------------------------------------   end

	//cellphone 测试 --------------------------------------------------- start
	/**
	 * 设置 User setCellphone() 正确的传参类型,期望传值正确
	 */
	public function testSetCellphoneCorrectType()
	{
		$this->stub->setCellphone('15202939435');
		$this->assertEquals('15202939435',$this->stub->getCellphone());
	}

	/**
	 * 设置 User setCellphone() 错误的传参类型,期望期望抛出TypeError exception
	 *
	 * @expectedException TypeError 
	 */
	public function testSetCellphoneWrongType()
	{
		$this->stub->setCellphone(array(1,2,3));
	}

	/**
	 * 设置 User setCellphone() 正确的传参类型,但是不属于手机格式,期望返回空.
	 */
	public function testSetCellphoneCorrectTypeButNotCellphone()
	{
		$this->stub->setCellphone('15202939435'.'a');
		$this->assertEquals('',$this->stub->getCellphone());
	}
	//cellphone 测试 ---------------------------------------------------   end

	//qq 测试 ---------------------------------------------------------- start
	/**
	 * 设置 User setQq() 正确的传参类型,期望传值正确
	 */
	public function testSetQqCorrectType()
	{
		$this->stub->setQq('41893204');
		$this->assertEquals('41893204',$this->stub->getQq());
	}

	/**
	 * 设置 User setQq() 错误的传参类型,期望期望抛出TypeError exception
	 *
	 * @expectedException TypeError 
	 */
	public function testSetQqWrongType()
	{
		$this->stub->setQq(array(1,2,3));
	}

	/**
	 * 设置 User setQq() 正确的传参类型,但是不属于QQ格式,期望返回空.
	 */
	public function testSetQqCorrectTypeButNotQq()
	{
		$this->stub->setQq('string');
		$this->assertEquals('',$this->stub->getQq());
	}
	//qq 测试 ----------------------------------------------------------   end

	//email 测试 ------------------------------------------------------- start
	/**
	 * 设置 User setEmail() 正确的传参类型,期望传值正确
	 */
	public function testSetEmailCorrectType()
	{
		$this->stub->setEmail('41893204@qq.com');
		$this->assertEquals('41893204@qq.com',$this->stub->getEmail());
	}

	/**
	 * 设置 User setEmail() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
	 */
	public function testSetEmailCorrectTypeButNotEmail()
	{
		$this->stub->setEmail('string');
		$this->assertEquals('',$this->stub->getEmail());
	}
	//email 测试 -------------------------------------------------------   end

	//createTime 测试 -------------------------------------------------- start
	/**
	 * 设置 User setCreateTime() 正确的传参类型,期望传值正确
	 */
	public function testSetCreateTimeCorrectType()
	{
		$this->stub->setCreateTime(1511595820);
		$this->assertEquals(1511595820,$this->stub->getCreateTime());
	}

	/**
	 * 设置 User setCreateTime() 错误的传参类型,期望期望抛出TypeError exception
	 *
	 * @expectedException TypeError 
	 */
	public function testSetCreateTimeWrongType()
	{
		$this->stub->setCreateTime('string');
	}

	/**
	 * 设置 User setCreateTime() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
	 */
	public function testSetCreateTimeWrongTypeButNumeric()
	{
		$this->stub->setCreateTime('1511595820');
		$this->assertTrue(is_int($this->stub->getCreateTime()));
		$this->assertEquals(1511595820,$this->stub->getCreateTime());
	}
	//createTime 测试 --------------------------------------------------   end

	//status 测试 ------------------------------------------------------ start
	/**
	 * 循环测试 User setStatus() 是否符合预定范围
	 *
	 * @dataProvider statusProvider
	 */
	public function testSetStatus($actual,$expected)
	{
		$this->stub->setStatus($actual);
		$this->assertEquals($expected,$this->stub->getStatus());
	}

	/**
	 * 循环测试 User setStatus() 数据构建器
	 */
	public function statusProvider()
	{
		return array(
			array(User::STATUS_ENABLE,User::STATUS_ENABLE),
			array(User::STATUS_DISABLE,User::STATUS_DISABLE),
			array(9999,User::STATUS_ENABLE),
		);
	}

	/**
	 * 设置 User setStatus() 错误的传参类型,期望期望抛出TypeError exception
	 *
	 * @expectedException TypeError 
	 */
	public function testSetStatusWrongType()
	{
		$this->stub->setStatus('string');
	}
	//status 测试 ------------------------------------------------------   end
}