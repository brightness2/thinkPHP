<?php

namespace app;

// 应用请求对象类
class Request extends \think\Request
{
    //设置任何全局过滤规则，你可以在app\Request对象中设置filter全局过滤属性：
    protected $filter = ['htmlspecialchars'];
}
