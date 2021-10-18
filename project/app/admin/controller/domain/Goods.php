<?php

namespace app\admin\controller\domain;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\Goods as ModelGoods;
use app\model\GoodsCate;
use app\model\GoodsUnit;

class Goods extends BaseController
{
    /********************商品分类************************** */

    public function getCateList()
    {
        $param = $this->request->param();

        $rows = GoodsCate::getList($param);
        return success($rows);
    }


    public function addCate()
    {
        $data  = $this->request->param();
        $this->validate($data, 'app\validate\GoodsCate.create');
        $id = GoodsCate::create($data)->getKey();
        return success($id, "新增成功");
    }

    public function editCate()
    {
        $data  = $this->request->param();
        $this->validate($data, 'app\validate\GoodsCate.update');
        $row = GoodsCate::find($data['id']);
        if (!$row) {
            throw new ZException("数据不存在");
        }

        $res = $row->save($data);
        return success($res, "更新成功");
    }

    public function deleteCate()
    {
        $id = $this->request->param('id');
        if (empty($id)) {
            throw new ZException("id不能为空");
        }
        $res = (new GoodsCate)->deleteCate($id);
        return success($res, "删除成功");
    }



    /*****************商品信息********************* */


    public function getGoodsList()
    {
        $param = $this->request->param();
        $rows = ModelGoods::getList($param, ['goodsCate']);

        $rows->map(function ($row) {
            return $row['cateName'] = $row['goodsCate']['name'];
        });
        $res = [
            'list' => $rows,
            'total' => $rows->count(),
        ];
        return success($res);
    }

    public function addGoods()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Goods.create');
        $id = ModelGoods::create($data)->getKey();
        return success($id, '创建成功');
    }

    public function editGoods()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Goods.update');
        $row = ModelGoods::find($data['id']);
        if (!$row) {
            throw new ZException("数据不存在");
        }
        $res = $row->save($data);
        return success($res, "修改成功");
    }

    public function deleteGoods()
    {
        $id = $this->request->param('id');
        if (empty($id)) {
            throw new ZException("商品ID不能为空");
        }
        $row = ModelGoods::find($id);
        if (!$row) {
            throw new  ZException("数据已删除");
        }
        $res = $row->save(['deleted' => 1]);
        return success($res, "删除成功");
    }

    public function deleteGoodsMore()
    {
        $keys = $this->request->param('keys');
        if (empty($keys)) {
            throw new ZException("缺少keys参数");
        }
        if (!is_array($keys)) {
            $keys = explode(',', $keys);
        }
        $res = ModelGoods::whereIn('id', $keys)->save(['deleted' => 1]);
        return success($res, "删除成功");
    }

    /****************商品单位******************** */
    public function getUnitList()
    {
        $param = $this->request->param();

        $rows = GoodsUnit::getList($param);
        $res = [
            'list' => $rows,
            'total' => $rows->count(),
        ];
        return success($res);
    }

    public function addUnit()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\GoodsUnit.create');
        $id = GoodsUnit::create($data)->getKey();
        return success($id, "新增成功");
    }

    public function editUnit()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\GoodsUnit.update');
        $row = GoodsUnit::find($data['id']);
        if (!$row) {
            throw new ZException("数据不存在");
        }
        $res = $row->save($data);
        return success($res, "更新成功");
    }

    public function deleteUnit()
    {
        $id = $this->request->param('id');
        if (empty($id)) {
            throw new ZException("id不能为空");
        }
        $row = GoodsUnit::find($id);
        if (!$row) {
            throw new ZException("数据已删除");
        }
        $res = $row->delete();
        return success($res, "删除成功");
    }
}
