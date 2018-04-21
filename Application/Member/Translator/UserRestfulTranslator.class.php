<?php
namespace Member\Translator;

use System\Classes\Translator;
use Member\Model\User;
use Member\Model\NullUser;

class UserRestfulTranslator extends Translator
{
    public function arrayToObject(array $expression, $user = null)
    {
        return $this->translateToObject($expression['data'], $user);
    }

    public function arrayToObjects(array $expression) : array
    {
        if (isset($expression['data'][0])) {
            $results = array();
            foreach ($expression['data'] as $each) {
                $results[$each['id']] = $this->translateToObject($each);
            }

            $count = isset($expression['meta']['count']) ? $expression['meta']['count'] : sizeof($results);
            return [$count, $results];
        }

        return [1, [$expression['data']['id']=>$this->translateToObject($expression['data'])]];
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    private function translateToObject(array $expression, $user = null)
    {
        $id = $expression['id'];
        $attributes = $expression['attributes'];

        if ($user == null) {
            $user = new User();
        }

        $user->setId($id);

        if (isset($attributes['cellphone'])) {
            $user->setCellphone($attributes['cellphone']);
        }

        if (isset($attributes['password'])) {
            $user->setPassword($attributes['password']);
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
                'cellphone',
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
        if (in_array('cellphone', $keys)) {
            $attributes['cellphone'] = $user->getCellphone();
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
