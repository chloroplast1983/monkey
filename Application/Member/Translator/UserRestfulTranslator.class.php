<?php
namespace Member\Translator;

use System\Classes\Translator;
use Member\Model\User;
use Member\Model\NullUser;

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

        return [$expression['data']['id']=>$this->arrayToSingleObject($expression['data'])];
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
    
    public function objectToArray($user, array $keys = array())
    {
        if (!$user instanceof User) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'cellPhone',
                'userName',
                'nickName',
                'password'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'users'
            )
        );
        
        if (in_array('id', $keys)) {
            $expression['data']['id'] = $user->getId();
        }

        $attributes = array();
        if (in_array('cellPhone', $keys)) {
            $attributes['cellPhone'] = $user->getCellPhone();
        }
        if (in_array('password', $keys)) {
            $attributes['password'] = $user->getPassWord();
        }
        if (in_array('userName', $keys)) {
            $attributes['userName'] = $user->getUserName();
        }
        if (in_array('nickName', $keys)) {
            $attributes['nickName'] = $user->getNickName();
        }
        $expression['data']['attributes'] = $attributes;

        return $expression;
    }
}
