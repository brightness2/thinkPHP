<?php

namespace app\controller;

use app\api\lib\exception\ZException;
use app\BaseController;


class BaseInfo extends BaseController
{
    /**
     * 获取列表
     * 访问举例:http://192.168.174.134/public/BaseInfo/getList?model=Cust
     */
    public function getList()
    {
        $param = $this->request->param();
        $model = $this->createModel();
        unset($param['model']);
        $data = $model->getList($param);
        $res = [
            'list' => $data,
            'total' => $model->count()
        ];
        return success($res);
    }

    /**
     * 获取一条数据
     */
    public function get()
    {
        $model = $this->createModel();

        $key = $this->request->param($model->getPk());
        if (!$key) {
            throw new ZException('主键不能为空');
        }
        $row = $model->find($key);
        if (!$row) {
            throw new ZException('数据不存在');
        }
        return success($row);
    }

    /**
     * 新增
     */
    public function create()
    {
        $model = $this->createModel();
        $data = $this->request->param();
        $this->validate($data, $data['model'] . '.create');
        unset($data['model']);
        $id = $model->create($data)->getKey();
        return success($id, '新增成功');
    }


    /**
     * 更新
     */
    public function update()
    {
        $model = $this->createModel();
        $data = $this->request->param();
        $this->validate($data, $data['model'] . '.update');
        unset($data['model']);
        $row = $model->find($data[$model->getPk()]);
        if (!$row) {
            throw new ZException('数据不存在');
        }
        $row->update($data);
        return success($row->getKey(), '更新成功');
    }

    /**
     * 删除一条记录
     */
    public function remove()
    {
        $model = $this->createModel();
        $key = $this->request->param($model->getPk());

        if (!$key) {
            throw new ZException('主键不能为空');
        }
        $row =  $model->find($key);
        if (!$row) {
            throw new ZException('数据已删除');
        }
        $res =  $row->delete();
        return success($res, '删除成功');
    }


    /**
     * 批量删除
     */
    public function removeMore()
    {
        $keys = $this->request->param('keys');
        if (!is_array($keys)) {
            throw new ZException('主键集参数错误');
        }
        $model = $this->createModel();
        foreach ($keys as $key) {
            $row = $model->find($key);
            if (!$row) continue;
            $row->delete();
        }
        return success(true, '操作成功');
    }

    /**
     * 创建model对象
     */
    protected function createModel()
    {
        $modelStr = $this->request->param('model');
        if (!$modelStr  or !is_string($modelStr)) {
            throw new ZException('缺少model参数');
        }
        $class = false !== strpos($modelStr, '\\') ? $modelStr : $this->app->parseClass('model', $modelStr);
        try {
            $model = new $class;
        } catch (\Error $e) {
            throw new ZException('model不存在');
        }
        return $model;
    }
}
