<?php
namespace Member\Model;

use Marmot\Core;
use User\Model\User as AbstractUser;
use Member\Model\UserAdapter;

/**
 * 用户领域对象
 * @author chloroplast
 * @version 1.0.0: 20160222
 */

class User extends AbstractUser
{

    /**
     * 设置用户状态
     * @param int $status 用户状态
     */
    public function setStatus(int $status)
    {
        $this->status= in_array($status, array(
            STATUS_NORMAL,
            STATUS_DELETE)) ? $status : STATUS_NORMAL;
    }

    /**
     * 注册
     * @return bool 是否注册成功
     */
    public function signUp() : bool
    {   
        $adapter = new UserAdapter();
        return $adapter->signUp($this, array(
                    'cellPhone',
                    'password',
                    'userName'
                ));
    }

    /**
     * 更新密码
     * @return bool 是否登陆成功
     */
    public function updatePassword() : bool
    {
    }
}
