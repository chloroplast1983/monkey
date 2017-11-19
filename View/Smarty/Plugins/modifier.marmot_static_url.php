<?php

function smarty_modifier_marmot_static_url(string $url, string $type = '')
{
    if ($type == 'img' || empty($type)) {
        return \Marmot\Core::$container->get('static.img.url').$url;
    }

    if ($type == 'css') {
        return \Marmot\Core::$container->get('static.css.url').$url;
    }

    if ($type == 'js') {
        return \Marmot\Core::$container->get('static.js.url').$url;
    }

    return $url;
}
