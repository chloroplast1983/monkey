<?php
namespace Member\Repository\User;

use System\Interfaces\IRepository;

use Common\Repository\AsyncRepositoryTrait;

use Member\Adapter\User\UserRestfulAdapter;
use Member\Adapter\User\IUserAdapter;
use Member\Model\User;
use Marmot\Core;

/**
 * 用户仓库
 *
 * @author chloroplast
 * @version 1.0:20160227
 */
class UserRepository implements IRepository
{
    use AsyncRepositoryTrait;

    private $adapter;
    
    public const LIST_MODEL_UN = 'USERNAME';

    public function __construct()
    {
        $this->adapter = new UserRestfulAdapter();
    }

    public function setAdapter(IUserAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }

    public function add(User $user) : bool
    {
        $lastUser = $this->getAdapter()->signUp($user);
        $user->setId($lastUser->getId());
        return true;
    }

    public function updatePassword(User $user) : bool
    {
        return $this->getAdapter()->update($user);
    }

    /**
     * 获取用户
     * @param integer $id 用户id
     */
    public function fetchOne($id) : User
    {
        return $this->getAdapter()->fetchOne($id);
    }

    /**
     * 批量获取用户
     * @param array $ids 商户申请表id数组
     */
    public function fetchList(array $ids) : array
    {
        return $this->getAdapter()->fetchList($ids);
    }

    /**
     * 根据条件查询用户
     */
    public function search(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) : array {
        return $this->getAdapter()->search($filter, $sort, $offset, $size);
    }
}
