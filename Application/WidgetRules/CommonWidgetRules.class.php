<?php
namespace WidgetRules;

use Respect\Validation\Validator as V;
use Marmot\Core;

class CommonWidgetRules
{
    public static function INPUT_CELLPHONE(string $cellphone)
    {
        if (!V::digit()->length(11,11)->validate($cellphone))
        {
            Core::setLastError(CELLPHONE_FORMAT_ERROR);
            return false;
        }
        return true;
    }
}
