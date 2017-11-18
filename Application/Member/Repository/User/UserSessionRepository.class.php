<?php
namespace Member\Repository\User;

use System\Interfaces\IRepository;

use Member\Adapter\User\UserSessionAdapter;

use Member\Model\User;

/**
 * 用户仓库
 *
 * @author chloroplast
 * @version 1.0:20160227
 */
class UserSessionRepository implements IRepository
{
    private $adapter;
    
    public function __construct()
    {
        $this->adapter = new UserSessionAdapter();
    }

    public function setAdapter(IUserAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function add(User $user) : bool
    {
        return $this->getAdapter()->add($user);
    }
    
    public function get(int $id) : User
    {
        return $this->getAdapter()->get($id);
    }

    public function clear(int $id) : bool
    {
        return $this->getAdapter()->del($id);
    }
}
