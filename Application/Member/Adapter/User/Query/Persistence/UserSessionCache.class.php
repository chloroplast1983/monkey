<?php
namespace Member\Adapter\User\Query\Persistence;

use System\Classes\Cache;

class UserSessionCache extends Cache
{
    public function __construct()
    {
        parent::__construct('user.session');
    }
}
