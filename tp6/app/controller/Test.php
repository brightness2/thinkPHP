<?php

namespace app\controller;

use app\BaseController;
use app\facade\Test as FacadeTest;
use think\Request;

class Test extends BaseController
{
    public function index()
    {
        return 'test';
    }

    /**
     * 输出json数据
     */
    public function test1()
    {
        $arr = ['a' => 1, 'b' => 2];
        return json($arr);
    }

    /**
     * 中断测试
     */
    public function test2()
    {
        halt('中断测试');
        return 'test2';
    }

    /**
     * 门面 facade
     */
    public function test3()
    {
        return FacadeTest::hello();
    }

    /**
     * 请求
     * 相关知识
     */
    public function test4(Request $request)
    {
        $request->param('name');
        //推荐 以下方式
        $this->request->param('name');
        $this->request->get('name', 'default');
        $this->request->post('name');
        $this->request->file('name');
        $this->request->session('name');
        $this->request->server('name');


        //$this->request 基础控制类BaseController 通过构造函数实例化了

        request()->param('name'); //助手函数

        //  request()->host();//当前访问域名或者IP
        //  request()->scheme();//当前访问协议
        //  request()->port();//当前访问的端口
        //  request()->domain();//当前包含协议的域名,http://192.168.174.134
        //  request()->time(); //获取当前请求的时间戳
        //  request()->method(); //当前请求类型，GET,POST
        //  request()->controller(); //当前请求的控制器名
        //  request()->action(); //当前请求的操作名
        //  request()->ip();//获取ip
        //  request()->header();//头部信息

        // 多应用模式，可以通过下面的方法来获取当前应用
        // app('http')->getName();
    }

    /**
     * 响应输出，重定向
     */
    public function test5()
    {

        // return response('Brightness', 201);
        // return json('Brightness', 201);

        //重定向
        // return redirect('http://www.baidu.com');
        // return redirect(url('test/index'));//站内跳转
        //
    }
}
