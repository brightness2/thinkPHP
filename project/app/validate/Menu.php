<?php

declare(strict_types=1);

namespace app\validate;

use think\Validate;

class Menu extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id|菜单ID' => 'require',
        'title|菜单名称' => 'require|unique:menu',
        'acl_value|权限码' => 'require|unique:menu',
        // 'type|类型' => 'require|in:0,1,2',

    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    /**
     * 定义验证场景
     * 格式：'场景名'=>['规则1','规则2',...]
     *
     * @var array
     */
    protected $scene = [
        'createChild' => ['title', 'acl_value'], //需要验证的规则
        'update' => ['id', 'title', 'acl_value'],
    ];
}
