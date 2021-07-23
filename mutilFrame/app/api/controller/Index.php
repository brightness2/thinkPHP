<?php

namespace app\api\controller;

use app\api\lib\exception\ZException;
use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        return 'api index';
    }


    public function test()
    {

        // validate(['name' => 'require'])->check(['name' => '']);
        // throw new ZException('自定义错误');
        // throw new \Exception('系统错误');
        return success('test');
    }
}
