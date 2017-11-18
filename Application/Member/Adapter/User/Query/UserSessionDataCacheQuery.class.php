<?php
namespace Member\Adapter\User\Query;

use Member\Adapter\User\Query\Persistence\UserSessionCache;
use System\Query\DataCacheQuery;

class UserSessionDataCacheQuery extends DataCacheQuery
{
    public function __construct()
    {
        parent::__construct(new UserSessionCache());
    }
}
