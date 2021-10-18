<?php

namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;

class GoodsCate extends Zmodel
{
    /**
     * 删除分类
     *
     * @param int $id
     * @return int
     */
    public function deleteCate(int $id)
    {
        $row = $this->find($id);
        if (!$row) {
            throw new ZException("数据已删除");
        }
        $count = $this->where('pid', $id)->count();
        if ($count > 0) {
            throw new ZException("存在子分类，不可删除");
        }

        return $row->delete();
    }

    /***************搜索器*************** */
    public function searchCateNameAttr($query, $value)
    {
        $query->where('name', 'like', '%' . $value . '%');
    }
}
