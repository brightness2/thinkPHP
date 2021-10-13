<?php

declare(strict_types=1);

namespace app\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id|用户编号' => 'require',
        'name|账号名称' => 'require',
        'pass|密码' => 'require',
        'real_name|真实姓名' => 'require',
        'old_password|旧密码' => 'require',
        'new_password|新密码' => 'require',
        'again_password|重复密码' => 'require|confirm:new_password'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'again_password.confirm' => '重复密码与新密码不一致',
    ];

    /**
     * 定义验证场景
     * 格式：'场景名'=>['规则1','规则2',...]
     *
     * @var array
     */
    protected $scene = [
        'login' => ['name', 'pass'], //需要验证的规则
        'create' => ['name', 'real_name'],
        'update' => ['id', 'name', 'real_name'],
        'updateSelf' => ['name', 'real_name'],
        'changePassword' => ['old_password', 'new_password', 'again_password'],
    ];
}
