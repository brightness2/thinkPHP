<?php

namespace app\model;

use app\lib\model\Zmodel;

class Customer extends Zmodel
{
    // 定义全局的查询范围
    protected $globalScope = ['deleted'];

    public function scopeDeleted($query)
    {
        $query->where('deleted', 0);
    }

    /*********搜索器******** */
    public function searchCustomerNameAttr($query, $value, $data)
    {
        $query->where('name', 'like', '%' . $value . '%');
    }
}
