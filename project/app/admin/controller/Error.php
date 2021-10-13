<?php

namespace app\admin\controller;

use think\facade\View;

/**
 * 空控制器
 * 用了提示错误
 * 类名必须是 Error
 */
class Error
{
    public function index()
    {
        return View::fetch('common/404');
    }

    function __call($name, $arguments)
    {
        return View::fetch('common/404');
    }
}
