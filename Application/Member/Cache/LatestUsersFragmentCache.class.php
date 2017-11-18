<?php
namespace Member\Cache;

use System\Query\FragmentCacheQuery;
use System\Adapter\Restful\GuzzleConcurrentAdapter;

use Member\Cache\Persistence\UserCache;

class LatestUsersFragmentCache extends FragmentCacheQuery
{
    public function __construct()
    {
        parent::__construct('latestUsers', new UserCache());
    }

    public function refresh()
    {
        $respository = new \Member\Repository\User\UserRepository();

        $concurrentAdapter = new \System\Adapter\ConcurrentAdapter();
        $concurrentAdapter->addPromise(
            'user1',
            $respository->fetchOneAsync(1),
            $respository->getAdapter()
        );
        $concurrentAdapter->addPromise(
            'user123',
            $respository->fetchListAsync(array(1,2,3)),
            $respository->getAdapter()
        );
        $concurrentAdapter->addPromise(
            'userList',
            $respository->searchAsync(array('cellPhone'=>'19102931113')),
            $respository->getAdapter()
        );

        $data = $concurrentAdapter->run();
        $this->save($data);

        return $data;
    }
}
