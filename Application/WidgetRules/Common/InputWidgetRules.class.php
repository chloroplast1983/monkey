<?php
namespace WidgetRules\Common;

use Respect\Validation\Validator as V;
use Marmot\Core;

class InputWidgetRules
{
    public static function cellphone(string $cellphone)
    {
        if (!V::digit()->length(11, 11)->validate($cellphone)) {
            Core::setLastError(CELLPHONE_FORMAT_ERROR);
            return false;
        }
        return true;
    }

    public static function password(string $password)
    {
        //验证,设置错误编号
        return !empty($password);
    }
}
