<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        View::assign('name', 'Brightness');
        View::assign('pwd', '123456');
        View::assign('list', ['one', 'two', 'three']);

        return View::fetch();
    }

    public function test1()
    {
        return 'test1';
    }
}
