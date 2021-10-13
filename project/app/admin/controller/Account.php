<?php

namespace app\admin\controller;

use app\PageController;
// use think\facade\Config;
use think\facade\View;

class Account extends PageController
{
    public function login()
    {
        // $userId = $this->request->param('id');
        // if ($userId) {
        //     event('UserLogin', $userId);
        // }
        // return 'admin';
        // Config::set(['layout_on' => false], 'view'); //关闭全局layout
        return View::fetch('common/login');
    }
}
