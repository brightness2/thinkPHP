<?php

namespace app\model;

use app\lib\model\Zmodel;

class Goods extends Zmodel
{

    // 定义全局的查询范围
    protected $globalScope = ['deleted'];

    public function scopeDeleted($query)
    {
        $query->where('deleted', 0);
    }

    public function goodsCate()
    {
        return  $this->belongsTo(GoodsCate::class);
    }

    /******************搜索器******************* */
    public function searchGoodsNameAttr($query, $value)
    {
        $query->where('name', 'like', '%' . $value . '%');
    }

    public function searchGoodsCateIdAttr($query, $value)
    {
        $query->where('goods_cate_id', $value);
    }
}
