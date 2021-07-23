<?php

namespace app\admin\controller;

use think\facade\View;

class Error
{

    public function __call($method, $args)
    {
        return View::engine('php')->fetch('/404');
    }
}
