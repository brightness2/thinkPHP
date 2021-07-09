<?php

namespace app\controller;

use app\BaseController;
use app\lib\domain\Rbac as RbacDomain;
use app\lib\model\Sequence;
use app\lib\exception\ZException;
use app\lib\exception\ForbbidenException;
use app\model\RolePermission;
use app\model\User;
use app\model\UserRole;
use app\validate\Test;
use think\Exception;

class Index extends BaseController
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">14载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

    /**
     * 抛出异常
     */
    public function test1()
    {

        validate(Test::class)->check(['age' => 'a']);
        // throw new ForbbidenException();
        // throw new ZException('自定义错误');
        // throw new Exception('系统错误');
        return success('ok');
    }

    /**
     * 计数表使用
     */
    public function test2()
    {
        $res =  Sequence::GetSequenceId('user');
        return success($res);
    }

    /**
     * Zmodel 类使用
     */
    public function test3()
    {
        $user = User::create([
            'uname' => 'admin',
            'password' => md5(123456),
        ]);
        return $user;
    }

    /**
     * RBAC
     */
    public function test4()
    {
        $domain =  new RbacDomain;
        $data = [
            ['role_id' => 1, 'per_id' => 4],
            ['role_id' => 1, 'per_id' => 5],
            ['role_id' => 1, 'per_id' => 6],
        ];
        $res = $domain->checkUserPermission(1, 'index', 'test2');
        return success($res);
    }
}
