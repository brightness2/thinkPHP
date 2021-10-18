<?php

declare(strict_types=1);

namespace app\validate;

use think\Validate;

class Supplier extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id|供应商编号' => 'require',
        'name|供应商名称' => 'require|unique:supplier',

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

        'create' => ['name'],
        'update' => ['id', 'name'],

    ];
}
