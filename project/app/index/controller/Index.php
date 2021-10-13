<?php

namespace app\index\controller;

use app\BaseController;
use app\lib\domain\JWT;
use app\lib\exception\ZException;

class Index extends BaseController
{
    public function index()
    {

        return 'index';
    }

    /**
     * 自定义异常
     *
     * @return void
     */
    public function test1()
    {
        throw new ZException('抛出自定义异常');
    }

    /**
     * 数据库事务
     *
     * @return void
     */
    public function test2()
    {
        // 启动事务
        // Db::startTrans();
        // try {
        //     Db::table('think_user')->find(1);
        //     Db::table('think_user')->delete(1);
        //     // 提交事务
        //     Db::commit();
        // } catch (\Exception $e) {
        //     // 回滚事务
        //     Db::rollback();
        // }
        //模型的方法一样
        return success('数据库事务;');
    }
    /**
     * token生成与解码
     *
     * @return void
     */
    public function test3()
    {
        //路由中间件配置checkToken后，可以检查token，通过$GLOBALS['USER']获取token信息

        $token =    JWT::signToken('u111');
        $arr = [
            'token' => $token,
            'parse' => JWT::checkToken($token),
        ];
        return success($arr);
    }
}
