<?php
namespace Common\Persistence;

use System\Classes\Session;

class UtilsSession extends Session
{
    public function __construct()
    {
        parent::__construct('utils');
    }
}
