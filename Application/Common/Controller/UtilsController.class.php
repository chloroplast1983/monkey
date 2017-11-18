<?php
namespace Common\Controller;

use System\Classes\Controller;

use Common\Utils\Captcha;

class UtilsController extends Controller
{
    public function captcha()
    {
        Captcha::render();
    }
}
