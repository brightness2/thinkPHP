<?php

namespace app\controller;

use app\BaseController;

class Middle extends BaseController
{
    protected  $middleware = [
        \app\middleware\After::class,
    ]; //控制器中间件

    public function index()
    {
        echo '主体程序';
        return '返回结果';
    }
}
