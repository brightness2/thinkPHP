<?php

namespace app\admin\controller\domain;

use app\model\User;
use app\BaseController;
use app\lib\exception\ZException;


class Account extends BaseController
{
    public function doLogin()
    {
        // throw new ZException('account doLogin');
        $data = $this->request->post();
        $this->validate($data, 'app\validate\User.login');
        $row = User::getByName($data['name']);
        if (!$row) {
            throw new ZException('账号不存在');
        }
        if ($row->pass != encryptPwd($data['pass'])) {
            throw new ZException('密码错误');
        }
        if ($row->locked) {
            throw new ZException('账号被禁用，请联系管理员');
        }
        event('UserLogin', $row->id);
        return success($row->hidden(['pass']), '登录成功');
    }

    public function logout()
    {
        event('UserLogout');
        return success(true);
    }

    public function getMenu()
    {
        $data = [
            'homeInfo' => [
                'title' => '首页',
                'href' => 'home/welcome',
            ],
            'logoInfo' => [
                'title' => '进销存系统',
                'image' => '/public/static/layuimini/images/logo.png',
                'href' => ''
            ],
            'menuInfo' => [
                [
                    'title' => '常规管理',
                    'icon' => 'fa fa-address-book',
                    'href' => '',
                    'target' => '_self',
                    'child' => [
                        [
                            'title' => '主页模板',
                            'href' => 'home/test',
                            'icon' => 'fa fa-home',
                            'target' => '_self',
                        ],
                        [
                            'title' => '系统设置',
                            'href' => '',
                            'icon' => 'fa fa-home',
                            'target' => '_self',
                            'child' => [
                                [
                                    'title' => '用户管理',
                                    'href' => 'system/user',
                                    'icon' => '',
                                    'target' => '_self',
                                ],
                                [
                                    'title' => '角色维护',
                                    'href' => 'system/role',
                                    'icon' => '',
                                    'target' => '_self',
                                ],
                                [
                                    'title' => '菜单管理',
                                    'href' => 'system/menu',
                                    'icon' => '',
                                    'target' => '_self',
                                ],
                            ]
                        ]

                    ]
                ],

            ]

        ];
        return success($data);
    }

    public function updateInfo()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\User.updateSelf');
        $row = User::find($GLOBALS['USER']->uid);
        if (!$row) {
            throw new ZException('当前账号信息不存在');
        }
        $has = User::getByName($data['name']);
        if ($has) {
            if ($has->id != $row->id) {
                throw new ZException('账号已存在,请使用其它账号');
            }
        }
        $row->where('id', $row->id)->update($data);
        return success(true, '更新成功');
    }

    public function changePassword()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\User.changePassword');
        $row = User::find($GLOBALS['USER']->uid);
        if (!$row) {
            throw new ZException('当前账号信息不存在');
        }
        $oldPass = encryptPwd($data['old_password']);
        $newPass = encryptPwd($data['new_password']);
        if ($row->pass != $oldPass) {
            throw new ZException('原密码错误');
        }
        $rs = $row->save(['pass' => $newPass]);
        return success($rs, '修改成功');
    }
}
