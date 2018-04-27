<?php
namespace Home\Controller;

use System\Classes\Controller;
use Common\Controller\CaptchaTrait;
use Marmot\Core;

use Member\Repository\User\UserRepository;

use Common\Controller\CsrfTokenTrait;

class IndexController extends Controller
{
    use CaptchaTrait;
    use CsrfTokenTrait;

    public function index()
    {
        var_dump('Hello World monkey');
        return true;
    }
}
