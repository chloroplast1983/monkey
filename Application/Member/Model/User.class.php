<?php
namespace Member\Model;

use Marmot\Core;
use User\Model\User as AbstractUser;
use Member\Repository\User\UserRepository;

/**
 * 用户领域对象
 * @author chloroplast
 * @version 1.0.0: 20160222
 */

class User extends AbstractUser
{
    const STATUS_NORMAL = 0;
    const STATUS_DELETE = -2;
    
    private $userRepository;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
        $this->status = self::STATUS_NORMAL;
        $this->userRepository = Core::$container->get('Member\Repository\User\UserRepository');
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->status);
        unset($this->userRepository);
    }

    protected function getUserRepository() : UserRepository
    {
        return $this->userRepository;
    }

    /**
     * 设置用户状态
     * @param int $status 用户状态
     */
    public function setStatus(int $status) : void
    {
        $this->status= in_array(
            $status,
            array(
                self::STATUS_NORMAL,
                self::STATUS_DELETE
            )
        ) ? $status : self::STATUS_NORMAL;
    }

    /**
     * 注册
     * @return bool 是否注册成功
     */
    public function signUp() : bool
    {
        if (!$this->getUserRepository()->add($this)) {
            return false;
        }
        return true;
    }

    /**
     * 更新密码
     * @return bool 是否登陆成功
     */
    public function updatePassword() : bool
    {
        //oldpassword
        //password
    }
}
