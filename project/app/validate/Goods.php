<?php

declare(strict_types=1);

namespace app\validate;

use think\Validate;

class Goods extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'id|商品ID' => 'require',
        'code|商品编号' => 'require',
        'name|商品名称' => 'require|unique:goods',
        'model|商品型号' => 'require',
        'unit|商品单位' => 'require',

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

        'create' => ['code', 'name', 'model', 'unit'],
        'update' => ['id', 'code', 'name', 'model', 'unit'],

    ];
}
