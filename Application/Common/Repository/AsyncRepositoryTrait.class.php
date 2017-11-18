<?php
namespace Common\Repository;

use System\Interfaces\IAsyncAdapter;

trait AsyncRepositoryTrait
{
    public function fetchOneAsync($id)
    {
        $adapter = $this->getAdapter();
        return $adapter instanceof IAsyncAdapter ? $adapter->fetchOneAsync($id) : '';
    }

    public function fetchListAsync($id)
    {
        $adapter = $this->getAdapter();
        return $adapter instanceof IAsyncAdapter ? $adapter->fetchListAsync($id) : '';
    }

    public function searchAsync(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) {
        $adapter = $this->getAdapter();
        return $adapter instanceof IAsyncAdapter
            ? $adapter->searchAsync($filter, $sort, $offset, $size)
            : '';
    }
}
