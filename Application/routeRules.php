<?php
/**
 *
 * 路由设置
 */
return [
    
    //users
	//保存用户页面
    [
        'method'=>'GET',
        'rule'=>'/Users/Save[/{id:\d+}]',
        'controller'=>[
            'Member\Controller\UserController',
            'signUp'
        ]
    ],
    //保存提交触发
    [
        'method'=>'POST',
        'rule'=>'/Users',
        'controller'=>[
            'Member\Controller\UserController',
            'signUp'
        ]
    ],
];
