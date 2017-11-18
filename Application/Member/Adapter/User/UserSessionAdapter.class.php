<?php
namespace Member\Adapter\User;

use Marmot\Core;

use Member\Model\User;
use Member\Model\NullUser;
use Member\Adapter\User\Query\UserSessionDataCacheQuery;

class UserSessionAdapter
{
    private $session;

    public function __construct()
    {
        $this->session = new UserSessionDataCacheQuery();
    }

    protected function getSession()
    {
        return $this->session;
    }

    public function get(int $id) : User
    {
        $user = $this->getSession()->get($id);
        return $user instanceof User ? $user : new NullUser();
    }

    public function add(User $user) : bool
    {
        return $this->getSession()->save($user->getId(), $user);
    }

    public function del(int $id) : bool
    {
        return $this->getSession()->del($id);
    }
}
