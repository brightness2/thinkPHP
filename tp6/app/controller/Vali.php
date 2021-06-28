<?php

namespace app\controller;

use app\BaseController;
use app\validate\User;
use think\exception\ValidateException;
use think\facade\Validate as FacadeValidate;

class Vali extends BaseController
{
    public function index()
    {
        return 'vali';
    }

    /**
     * 验证类
     */
    public function test1()
    {
        try {

            validate(User::class)->batch(false)->check([
                'name' => 'Brightness',
                'price' => 9,
                'email' => '2390@qqcom'
            ]);
            //控制器里以下效果同上

            // $this->validate([
            //     'name' => '6688986',
            //     'price' => 9,
            //     'email' => '2390@qqcom'
            // ], User::class);



        } catch (ValidateException $e) {
            dump($e->getMessage());
        }
    }

    /**
     * 场景验证
     */
    public function test2()
    {
        try {
            validate(User::class)->scene('update')->check([
                'name' => 'aaa',
                'price' => 9,
                'email' => '2390@qqcom'
            ]);
        } catch (ValidateException $e) {
            dump($e->getMessage());
        }
    }
    /**
     * 独立验证
     */
    public function test3()
    {
        $validate = FacadeValidate::rule([
            'name|用户名' => 'require|max:6',
            'price' => 'number|between:1,6',
            'email' => 'email',
        ]);

        $validate->message([
            'email.email' => '邮箱格式错误'
        ]);

        $res = $validate->batch(true)->check([
            'name' => '99999',
            'price' => 9,
            'email' => '2390@qqcom'
        ]);

        if (!$res) {
            dump($validate->getError());
        }
    }
}
