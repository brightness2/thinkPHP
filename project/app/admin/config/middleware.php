<?php
// 后台中间件配置,注意会覆盖全局配置
return [
    // 别名或分组
    'alias'    => [
        'checkCookie' => \app\middleware\Cookie::class,
    ],
    // 优先级设置，此数组中的中间件会按照数组中的顺序优先执行
    'priority' => [],
    //全局中间件排除的操作，注意是路由中间件 或 应用中间件 或 控制器中间件
    'except' => [
        'checkToken' => [
            'Login/index', //注意大小写,控制器大驼峰
            'domain.Account/doLogin'
        ],
    ],
];
