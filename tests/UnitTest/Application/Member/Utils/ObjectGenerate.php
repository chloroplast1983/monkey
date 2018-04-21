<?php
namespace Member\Utils;

use Member\Model\User;

class ObjectGenerate
{
    public static function generateCrew(int $id = 0, int $seed = 0, array $value = array()) : User
    {
         $faker = \Faker\Factory::create('zh_CN');
         $faker->seed($seed);

         $crew = new User($id);

        return $crew;
    }
}
