<?php

namespace app\controller;

use app\BaseController;
use think\facade\Event as FacadeEvent;

class Event extends BaseController
{

    function __construct()
    {
        //监听器，动态
        FacadeEvent::listen('TestListen', function ($param) {
            echo '<br/>动态定义的监听器被触发了<br/>';
        });
    }

    public function index()
    {

        FacadeEvent::trigger('TestListen');
        echo '登录前准备<br/>';

        FacadeEvent::trigger('Test');
    }

    public function login()
    {
        echo '登录成功<br/>';
        event('UserLogin');
    }

    public function logout()
    {
        echo '退出成功<br/>';
        event('UserLogout');
    }
}
