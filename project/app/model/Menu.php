<?php

namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;

class Menu extends Zmodel
{

    /**
     * 添加子菜单
     *
     * @param integer $pid
     * @param array $data
     * @return int
     */
    public function addChildMenu(int $pid, array $data)
    {

        $parent = $this->find($pid);
        if ($parent) {
            $data['pid'] = $pid;
            $data['type'] = $parent['type'] + 1;
        } else {
            $data['pid'] = 0;
            $data['type'] = 0;
        }
        if ($data['type'] > 2) {
            $data['type'] = 2;
        }
        //如果是菜单或按钮，访问操作不能为空
        if ($data['type'] > 0 and empty($data['action'])) {
            throw new ZException("访问操作不能为空");
        }
        return $this->create($data)->getKey();
    }

    /**
     * 修改菜单
     *
     * @param integer $id
     * @param array $data
     * @return int
     */
    public function editMenu(int $id, array $data)
    {
        $row = $this->find($id);
        if (!$row) {
            throw new ZException("数据不存在");
        }
        if ($row['type'] == -1) {
            throw new ZException("根目录不可修改");
        }
        //如果是菜单或按钮，访问操作不能为空
        if ($row['type'] > 0 and empty($data['action'])) {
            throw new ZException("访问操作不能为空");
        }
        return $row->save($data);
    }

    /**
     * 删除菜单
     *
     * @param integer $id
     * @return void
     */
    public function deleteMenu(int $id)
    {
        $row = $this->find($id);
        if (!$row) {
            throw new ZException("菜单已删除");
        }
        if ($row['id'] == 1 or $row['type'] == -1) {
            throw new ZException("根目录不可删除");
        }
        $children = $this->where('pid', $id)->count();
        if ($children > 0) {
            throw new ZException("存在子项,不可删除");
        }
        return $row->delete();
    }

    public function getCheckArrAttr($value)
    {
        return "0";
    }
}
