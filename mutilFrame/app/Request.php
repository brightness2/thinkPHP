<?php

namespace app;


// 应用请求对象类
class Request extends \think\Request
{

    public function app_name()
    {
        return App('http')->getName();
    }
}
