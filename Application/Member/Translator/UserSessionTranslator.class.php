<?php
namespace Member\Translator;

use System\Classes\Translator;
use Member\Model\User;

class UserSessionTranslator extends Translator
{
    public function arrayToObject(array $expression, $user = null)
    {
        if ($user == null) {
            $user = new User($expression['id']);
        }

        $user->setCellphone($expression['cellphone']);
        $user->setUserName($expression['userName']);

        return $user;
    }
    
    public function arrayToObjects(array $expression) : array
    {
        $user = new User($expression['id']);
        $user->setCellphone($expression['cellphone']);
        $user->setUserName($expression['userName']);
        return [
            $expression['id'] => $user
        ];
    }

    public function objectToArray($user, array $keys = array())
    {
        unset($keys);
        $expression = array();

        $expression['id'] = $user->getId();
        $expression['userName'] = $user->getUserName();
        $expression['cellphone'] = $user->getCellphone();

        return $expression;
    }
}
