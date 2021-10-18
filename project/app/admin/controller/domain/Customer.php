<?php

namespace app\admin\controller\domain;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\Customer as ModelCustomer;

class Customer extends BaseController
{

    public function getList()
    {
        $param = $this->request->param();
        $model = new ModelCustomer();
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
        $this->validate($data, 'app\validate\Customer.create');
        $id = ModelCustomer::create($data)->getKey();
        return success($id, "创建成功");
    }

    public function edit()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Customer.update');
        $row = ModelCustomer::find($data['id']);
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
            throw new ZException("客户ID不能为空");
        }
        $row = ModelCustomer::find($id);
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
        $res = ModelCustomer::whereIn('id', $keys)->save(['deleted' => 1]);
        return success($res, "删除成功");
    }
}
