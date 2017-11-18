<?php
namespace Common\Controller;

use Common\Utils\Captcha;

trait CaptchaTrait
{

    public function validateCaptcha(string $phrase) : bool
    {
        return Captcha::validate($phrase);
    }
}
