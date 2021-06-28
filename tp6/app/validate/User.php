<?php

namespace app\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'=>['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'name|用户名' => 'require|max:20|checkName:Brightness',
        'price' => 'number|between:1,6',
        'email' => 'email',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'=>'错误信息'
     *
     * @var array
     */
    protected $message = [
        'name.max' => '名称过长',
        'email.email' => '不符合邮箱格式',

    ];
    /**
     * 定义验证场景
     * 格式：'场景名'=>['规则1','规则2',...]
     *
     * @var array
     */
    protected $scene = [
        'insert' => ['name', 'price', 'email'], //需要验证的规则
        'edit' => ['name', 'price'],
    ];

    /**
     * 定义验证场景
     * 去掉部分规则，使得场景规则修改更细腻
     */
    protected function sceneUpdate()
    {
        $update = $this->only(['name', 'price'])
            ->remove('price', 'number|between')
            ->append('price', 'require');
        return $update;
    }

    /**
     * 自定义规则
     * 
     */
    protected function checkName($value, $rule, $data, $field, $title)
    {
        // dump($value); //要检测的值
        // dump($rule); //Brightness，要匹配的内容
        //dump($data);//要检测的所有数据
        return $value != $rule ? true : '名称Brightness已被使用';
    }
}
