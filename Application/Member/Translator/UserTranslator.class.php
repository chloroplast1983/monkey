<?php
namespace Member\Translator;

use System\Classes\Translator;
use Member\Model\Application;
use Saas\Model\User;

class ApplicationTranslator extends Translator
{

    public function arrayToObject(array $expression)
    {

        $user = new User($expression['id']);
        $user->setCellPhone($expression['cellPhone']);
        $user->setCreateTime($expression['createTime']);
        $user->setUpdateTime($expression['updateTime']);
        $user->setNickName($expression['nickName']);
        $user->setUserName($expression['userName']);
        $user->setStatus($expression['status']);
        $user->setStatusTime($expression['statusTime']);
        
        return $application;
    }

    public function objectToArray($user, array $keys = array())
    {
        if (!$user instanceof User) {
            return false;
        }

        if (empty($keys)) {
            $keys = array(
                        'id',
                        'cellPhone',
                        'updateTime',
                        'createTime',
                        'statusTime',
                        'status',
                        'nickName',
                        'userName',
                        'password'
                    );
        }

        $expression = array();


        if (in_array('id', $keys)) {
            $expression['id'] = $user->getId();
        }

        if (in_array('cellPhone', $keys)) {
            $expression['cellPhone'] = $user->getCellPhone();
        }


        if (in_array('userName', $keys)) {
            $expression['user_name'] = $user->getUserName();
        }

        if (in_array('createTime', $keys)) {
            $expression['createTime'] = $user->getCreateTime();
        }

        if (in_array('updateTime', $keys)) {
            $expression['updateTime'] = $user->getUpdateTime();
        }

        if (in_array('status', $keys)) {
            $expression['status'] = $user->getStatus();
        }

        if (in_array('statusTime', $keys)) {
            $expression['statusTime'] = $user->getStatusTime();
        }

        return $expression;
    }
}
