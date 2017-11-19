<?php

function smarty_modifier_marmot_mask($string, int $start = 0, $length=null)
{
    return \Common\Utils\Mask::mask($string, $start, $length);
}
