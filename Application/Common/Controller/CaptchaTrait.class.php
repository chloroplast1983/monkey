<?php
namespace Common\Controller;

use Common\Persistence\UtilsSession;

trait CaptchaTrait {

    protected function validateCaptcha(string $phrase)
    {
        $session = new UtilsSession();
        return $phrase == $session->get('captcha');
    }
}
