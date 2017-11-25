<?php
namespace Member\Model;

use Marmot\Core;

/**
 * User 用户领域对象
 * @author chloroplast
 * @version 1.0.0:2017.11.25
 */

class User
{
	/**
	 * @var int $id 用户id
	 */
	private $id;
	/**
	 * @var string $name 用户名字
	 */
	private $name;
	/**
	 * @var string $cellphone 用户手机号
	 */
	private $cellphone;
	/**
	 * @var string $qq 用户qq
	 */
	private $qq;
	/**
	 * @var string $email 用户邮箱
	 */
	private $email;
	/**
	 * @var int $createTime 用户注册时间
	 */
	private $createTime;
	/**
	 * @var int $status 用户状态
	 */
	private $status;

	/**
	 * User 用户领域对象 构造函数
	 */
	public function __construct(){
		$this->id = 0;
		$this->name = '';
		$this->cellphone = '';
		$this->qq = '';
		$this->email = '';
		$this->createTime = Core::$container->get('time');
		$this->status = User::STATUS_ENABLE;
	}

	/**
	 * User 用户领域对象 析构函数
	 */
	public function __destruct(){
		unset($this->id);
		unset($this->name);
		unset($this->cellphone);
		unset($this->qq);
		unset($this->email);
		unset($this->createTime);
		unset($this->status);
	}

	/**
	 * 设置用户id
	 * @param int $id 用户id
	 */
	public function setId(int $id)
	{
		$this->id = $id;
	}

	/**
	 * 获取用户id
	 * @return int $id 用户id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * 设置用户名字
	 * @param string $name 用户名字
	 */
	public function setName(string $name)
	{
		$this->name = $name;
	}

	/**
	 * 获取用户名字
	 * @return string $name 用户名字
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * 设置用户手机号
	 * @param string $cellphone 用户手机号
	 */
	public function setCellphone(string $cellphone)
	{
		$this->cellphone = is_numeric($cellphone) ? $cellphone : '';
	}

	/**
	 * 获取用户手机号
	 * @return string $cellphone 用户手机号
	 */
	public function getCellphone()
	{
		return $this->cellphone;
	}

	/**
	 * 设置用户qq
	 * @param string $qq 用户qq
	 */
	public function setQq(string $qq)
	{
		$this->qq = is_numeric($qq) ? $qq : '';
	}

	/**
	 * 获取用户qq
	 * @return string $qq 用户qq
	 */
	public function getQq()
	{
		return $this->qq;
	}

	/**
	 * 设置用户邮箱
	 * @param string $email 用户邮箱
	 */
	public function setEmail(string $email)
	{
		$this->email= filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
	}

	/**
	 * 获取用户邮箱
	 * @return string $email 用户邮箱
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * 设置用户注册时间
	 * @param int $createTime 用户注册时间
	 */
	public function setCreateTime(int $createTime)
	{
		$this->createTime = $createTime;
	}

	/**
	 * 获取用户注册时间
	 * @return int $createTime 用户注册时间
	 */
	public function getCreateTime()
	{
		return $this->createTime;
	}

	/**
	 * 设置用户状态
	 * @param int $status 用户状态
	 */
	public function setStatus(int $status)
	{
		$this->status= in_array($status,array(User::STATUS_ENABLE,User::STATUS_DISABLE)) ? $status : User::STATUS_ENABLE;
	}

	/**
	 * 获取用户状态
	 * @return int $status 用户状态
	 */
	public function getStatus()
	{
		return $this->status;
	}

}