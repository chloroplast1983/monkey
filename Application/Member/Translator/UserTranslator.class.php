<?php
namespace Member\Translator;

use System\Classes\Translator;

use Member\Model\User;

class UserTranslator extends Translator
{

    public function arrayToObject(array $expression, $user = null)
    {
        unset($user);
        unset($expression);
        return false;
    }

    public function arrayToObjects(array $expression) : array
    {
        unset($expression);
        return array();
    }

    public function objectToArray($user, array $keys = array())
    {
        if (!$user instanceof User) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'cellphone',
                'userName',
                'nickName'
            );
        }

        $expression = array();
        
        if (in_array('id', $keys)) {
            $expression['id'] = $user->getId();
        }

        if (in_array('cellphone', $keys)) {
            $expression['cellphone'] = $user->getCellphone();
        }
        if (in_array('userName', $keys)) {
            $expression['userName'] = $user->getUserName();
        }
        if (in_array('nickName', $keys)) {
            $expression['nickName'] = $user->getNickName();
        }

        return $expression;
    }
}
