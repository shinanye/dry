<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

    //index模块路由配置
    //index控制器路由配置
     'index'=>'index/index/index',
    ':id/user'=>'index/index/user',
    ':id/login'=>'index/index/login',
    ':id/forget'=>'index/index/forget',
    ':id/sendSMSCode'=>'index/index/sendSMSCode',
    ':id/register'=>'index/index/register',

    //rents控制器路由配置
    ':id/detail/:fid'=>'index/rents/detail',
     'rents/:type'=>'index/rents/rents',
    'rents'=>'index/rents/rents',

    //owner控制器路由配置
    'owner'=>'index/owner/owner',
    'aboutus'=>'index/owner/aboutus',
    //index模块路由配置完成

    'demo'=>'index/demo/demo',
    'mai'=>'index/demo/mai',
    'pop'=>'index/demo/pop',
];
