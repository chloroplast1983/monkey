<?php
namespace Member\Translator;

use System\Classes\Translator;
use Member\Model\User;

class UserRestfulTranslator extends Translator
{
    public function arrayToObject(array $expression)
    {
        if (isset($expression['data'][0])) {
            $results = array();
            foreach ($expression['data'] as $each) {
                $results[$each['id']] = $this->arrayToSingleObject($each);
            }

            return $results;
        }
        return [$expression['data']['id']=>$this->arrayToSingleObject($expression)];
    }

    private function arrayToSingleObject(array $expression)
    {
        $id = $expression['id'];
        $attributes = $expression['attributes'];
    
        $user = new User($id);

        if (isset($attributes['cellPhone'])) {
            $user->setCellPhone($attributes['cellPhone']);
        }

        if (isset($attributes['createTime'])) {
            $user->setCreateTime($attributes['createTime']);
        }

        if (isset($attributes['updateTime'])) {
            $user->setUpdateTime($attributes['updateTime']);
        }

        if (isset($attributes['nickName'])) {
            $user->setNickName($attributes['nickName']);
        }

        if (isset($attributes['userName'])) {
            $user->setUserName($attributes['userName']);
        }

        if (isset($attributes['statue'])) {
            $user->setStatus($attributes['status']);
        }


        if (isset($attributes['statueTime'])) {
            $user->setStatusTime($attributes['statusTime']);
        }
        
        return $user;
    }
    
    public function objectToArray($user)
    {
        unset($user);
    }
}
