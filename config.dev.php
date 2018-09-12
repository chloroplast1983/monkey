<?php
ini_set("display_errors","on");

return [
    //cookie
    'cookie.domain'		=>	'',
    'cookie.path'		=>	'/',
    'cookie.duration'   => 3600,
    'cookie.name'       => 'marmot',
    'cookie.encrypt.key' => 'marmot',
    //services
    'services.user.url' => 'http://marmot-backend/',
    //cache
    'cache.route.disable' => true,
    //cache strategy
    'cache.session.ttl' => 60,
    'cache.restful.ttl' => 60,
    //memcached
    'memcached.serevice'=>[['memcached-data-1',11211],['memcached-data-2',11211]],
];
