<?php
namespace User\Model;

use Marmot\Common\Model\Object;

/**
 * 用户领域对象
 * @author chloroplast
 * @version 1.0.0: 20160222
 */

abstract class User
{
    /**
     * @var Object 对象性状
     */
    use Object;
    /**
     * @var int $id 用户uid
     */
    protected $id;
    /**
     * @var string $cellPhone 用户手机号
     */
    protected $cellPhone;
    /**
     * @var string $nickName 昵称
     */
    protected $nickName;
    /**
     * @var string $userName 用户名预留字段
     */
    protected $userName;
    /**
     * @var string $password 用户密码
     */
    protected $password;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->cellPhone = '';
        $this->nickName = '';
        $this->userName = '';
        $this->password = '';
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = 0;
        $this->statusTime = 0;
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->cellPhone);
        unset($this->nickName);
        unset($this->userName);
        unset($this->password);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->statusTime);
    }
    
    /**
     * 设置用户id
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * 获取 id.
     *
     * @return int $id 用户uid
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * 设置用户手机号码
     * @param string $cellPhone
     */
    public function setCellPhone(string $cellPhone)
    {
        $this->cellPhone = is_numeric($cellPhone) ? $cellPhone : '';
    }

    /**
     * Gets the value of cellPhone.
     *
     * @return string $cellPhone 用户名,现在用手机号
     */
    public function getCellPhone() : string
    {
        return $this->cellPhone;
    }
    
    /**
     * 设置昵称
     * @param string $nickName 昵称
     */
    public function setNickName(string $nickName)
    {
        $this->nickName = $nickName;
    }

    /**
     * 获取昵称
     * @return string $nickName 昵称
     */
    public function getNickName() : string
    {
        return $this->nickName;
    }

    /**
     * 设置用户名预留字段
     * @param string $userName 用户名预留字段
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * 获取用户名预留字段
     * @return string $userName 用户名预留字段
     */
    public function getUserName() : string
    {
        return $this->userName;
    }

    /**
     * 设置用户密码
     *
     * @param string $password 用户密码
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Gets the value of password.
     *
     * @return string $password 用户密码
     */
    public function getPassword() : string
    {
        return $this->password;
    }
    
    /**
     * 注册
     */
    abstract public function signUp() : bool;

    /**
     * 修改密码
     */
    abstract public function updatePassword() : bool;
}
