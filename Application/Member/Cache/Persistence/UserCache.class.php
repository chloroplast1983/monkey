<?php
namespace Member\Cache\Persistence;

use System\Classes\Cache;

class UserCache extends Cache
{
    public function __construct()
    {
        parent::__construct('user');
    }
}
