<?php
return [
    //cookie
    'cookie.domain'		=>	'',
    'cookie.path'		=>	'/',
    'cookie.duration'   => 3600,
    'cookie.name'       => 'marmot',
    'cookie.encrypt.key' => 'marmot',
    //url
    'services.user.url' => 'http://marmot-backend/',
    //cache
    'cache.route.disable' => true,
    //memcached
    'memcached.serevice'=>[['memcached_data_1',11211],['memcached_data_2',11211]],
];
