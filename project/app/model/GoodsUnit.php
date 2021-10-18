<?php

namespace app\model;

use app\lib\model\Zmodel;

class GoodsUnit extends Zmodel
{
    /******************搜索器******************* */
    public function searchUnitNameAttr($query, $value)
    {
        $query->where('name', 'like', '%' . $value . '%');
    }
}
