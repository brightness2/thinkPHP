<?php
// 事件定义文件

return [
    'bind'      => [],

    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
        'Test' => [\app\listener\Test::class], //可多个
    ],

    'subscribe' => [
        'UserSub' => \app\subscribe\UserSub::class
    ],
];
