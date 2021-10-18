<?php

namespace app\admin\controller\domain;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\Supplier as ModelSupplier;

class Supplier extends BaseController
{

    public function getList()
    {
        $param = $this->request->param();
        $model = new ModelSupplier();
        $rows = $model->getList($param);
        $res = [
            'list' => $rows,
            'total' => $model->count()
        ];
        return success($res);
    }


    public function add()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Supplier.create');
        $id = ModelSupplier::create($data)->getKey();
        return success($id, "创建成功");
    }

    public function edit()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Supplier.update');
        $row = ModelSupplier::find($data['id']);
        if (!$row) {
            throw new ZException("数据不存在");
        }
        $res = $row->save($data);
        return success($res, "修改成功");
    }

    public function delete()
    {
        $id = $this->request->param('id');
        if (empty($id)) {
            throw new ZException("供应商ID不能为空");
        }
        $row = ModelSupplier::find($id);
        if (!$row) {
            throw new ZException("数据已删除");
        }
        $res = $row->save(['deleted' => 1]);
        return success($res, "删除成功");
    }

    public function deleteMore()
    {
        $keys = $this->request->param('keys');
        if (empty($keys)) {
            throw new ZException("缺少参数keys");
        }
        if (!is_array($keys)) {
            $keys = explode(',', $keys);
        }
        $res = ModelSupplier::whereIn('id', $keys)->save(['deleted' => 1]);
        return success($res, "删除成功");
    }
}
