<?php
namespace Member\Model;

use Marmot\Core;
use User\Model\User as AbstractUser;
use Member\Repository\User\UserRepository;
use Member\Repository\User\UserSessionRepository;

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
    private $userSessionRepository;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
        $this->status = self::STATUS_NORMAL;
        $this->userRepository = Core::$container->get('Member\Repository\User\UserRepository');
        $this->userSessionRepository = Core::$container->get('Member\Repository\User\UserSessionRepository');
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

    protected function getUserSessionRepository() : UserSessionRepository
    {
        return $this->userSessionRepository;
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

    public function signIn() : bool
    {
        if (!$this->getUserRepository()->signIn($this)) {
            return false;
        }
        return $this->saveCookie() && $this->saveSession();
    }

    private function saveCookie() : bool
    {
        $cookie = new \System\Classes\Cookie();

        $cookie->name = Core::$container->get('cookie.name');
        $cookie->value = $this->getId();
        $cookie->expire = Core::$container->get('cookie.duration');

        return $cookie->add();
    }

    private function saveSession() : bool
    {
        if ($this->getUserSessionRepository()->add($this)) {
            Core::$container->set('user', $this->getUserSessionRepository()->get($this->getId()));
            return true;
        }
        return false;
    }

    public function signOut() : bool
    {
        return $this->clearCookie() && $this->clearSession();
    }

    private function clearCookie() : bool
    {
        $cookie = new \System\Classes\Cookie();

        $cookie->name = Core::$container->get('cookie.name');
        $cookie->value = 0;
        $cookie->expire = -1;

        return $cookie->add();
    }

    private function clearSession() : bool
    {
        return $this->getUserSessionRepository()->clear($this->getId());
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
