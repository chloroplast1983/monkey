<?php
namespace Member\Widget;

use System\Classes\Controller;

class UserWidget extends Controller
{
    public function test($a)
    {
        $this->getResponse()->view()->assign('a', $a);
        $this->getResponse()->view()->display('Home/test.tpl');
        return true;
    }
}
