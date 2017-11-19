<?php
namespace Member\Model;

use Marmot\Core;
use User\Model\User as AbstractUser;

/**
 * 用户领域对象
 * @author chloroplast
 * @version 1.0.0: 20160222
 */

class User extends AbstractUser
{
    const STATUS_NORMAL = 0;
    const STATUS_DELETE = -2;

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
