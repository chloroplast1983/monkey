<?php
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
    //memcached
    'memcached.serevice'=>[['memcached-data-1',11211],['memcached-data-2',11211]],
];
