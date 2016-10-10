<?php
namespace Home\Controller;

use System\Classes\Controller;

class IndexController extends Controller
{
    public function index()
    {
         $this->getResponse()->view()->display('Home/index.tpl');
        return true;
    }
}
