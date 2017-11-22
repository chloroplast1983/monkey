<?php

function smarty_function_marmot_widget($args)
{
    $widget = new $args['widget']();
    $func = $args['func'];
    $widget->$func($args['parameters']);
}
