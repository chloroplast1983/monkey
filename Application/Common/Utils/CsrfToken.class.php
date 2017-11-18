<?php
namespace Common\Utils;

use Common\Persistence\UtilsSession;

class CsrfToken
{
    use RandomTokenTrait;

    public static function generateToken() : string
    {
        $token = self::random(40);
        self::storeToken($token);
        return $token;
    }

    private static function storeToken(string $token) : bool
    {
        $session = new UtilsSession();
        return $session->save('csrfToken', $token);
    }

    public static function validate(string $token) : bool
    {
        $session = new UtilsSession();
        return $token == $session->get('csrfToken');
    }
}
