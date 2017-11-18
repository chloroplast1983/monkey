<?php
namespace Common\Utils;

class Mask
{
    public static function mask(
        string $string,
        int $start,
        $length = null
    ) {
        $mask = preg_replace("/\S/", "*", $string);
        if (is_null($length)) {
            $mask = substr($mask, $start);
            return substr_replace($string, $mask, $start);
        }
        $mask = substr($mask, $start, $length);
        return substr_replace($string, $mask, $start, $length);
    }
}
