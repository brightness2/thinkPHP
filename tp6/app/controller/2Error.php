<?php

namespace app\controller;

/**
 * 空控制器
 * 用了提示错误
 * 类名必须是 Error
 */
class Error
{
    public function index()
    {
        return '当前控制器不存在';
    }
}
