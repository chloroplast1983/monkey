<?php
namespace System\Classes;

class Server
{
    public static function get($name, $value = '') : string
    {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : $value;
    }
}
