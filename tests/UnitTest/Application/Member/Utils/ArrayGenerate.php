<?php
namespace Member\Utils;

class ArrayGenerate
{
    public static function generateCrew(int $seed = 0) : array
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $crew = array();

        $crew = array(
            'data'=>array(
                'type'=>'crews',
                'id'=>$faker->randomNumber(2)
            )
        );

        $attributes = array();

        //cellphone
        $cellphone = isset($value['cellphone']) ? $value['cellphone'] : $faker->phoneNumber;
        $attributes['cellphone'] = $cellphone;

        //nickName
        $nickName = isset($value['nickName']) ? $value['nickName'] : $faker->sentence;
        $attributes['nickName'] = $nickName;

        //crewName
        $crewName = isset($value['crewName']) ? $value['crewName'] : $faker->word;
        $attributes['crewName'] = $crewName;

        //password
        $password = isset($value['password']) ? $value['password'] : $faker->password;
        $attributes['password'] = $password;

        //cardID
        $cardID = isset($value['cardID']) ? $value['cardID'] : $faker->randomDigit(18);
        $attributes['cardID'] = $cardID;

        //createTime
        $createTime = isset($value['createTime']) ? $value['createTime'] : 1513737146;
        $attributes['createTime'] = $createTime;

        //updateTime
        $updateTime = isset($value['updateTime']) ? $value['updateTime'] : 1513737146;
        $attributes['updateTime'] = $updateTime;

        //statusTime
        $statusTime = isset($value['statusTime']) ? $value['statusTime'] : 0;
        $attributes['statusTime'] = $statusTime;

        //status
        $status = isset($value['status']) ? $value['status'] : 0;
        $attributes['status'] = $status;

        //realName
        $realName = isset($value['realName']) ? $value['realName'] : $faker->name();
        $attributes['realName'] = $realName;

        $crew['data']['attributes'] = $attributes;

        $crew['data']['relationships']['userGroup']['data'] = array(
            'type' => 'userGroups',
            'id' => $faker->randomNumber(1)
        );

        $crew['data']['relationships']['roles']['data'] = array(
           array('type' => 'roles',
               'id' => $faker->randomNumber(1)
           )
        );

        return $crew;
    }
}
