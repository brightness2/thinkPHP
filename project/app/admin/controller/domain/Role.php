<?php

namespace app\admin\controller\domain;

use app\BaseController;
use app\lib\domain\Rbac;
use app\lib\exception\ZException;
use app\model\Role as ModelRole;

class Role extends BaseController
{
    public function getList()
    {
        $param = $this->request->param();
        $model = new ModelRole();
        $rows = $model->getList($param);
        $res = [
            'list' => $rows,
            'total' => count($rows),
        ];
        return success($res);
    }

    public function add()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Role.create');
        $role = ModelRole::create($data);
        if (!$role->id) {
            throw new ZException('添加失败', null, config('errCode.query'));
        }
        return success($role->id, '添加成功');
    }

    public function edit()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Role.update');
        $role = ModelRole::find($data['id']);
        if (!$role) {
            throw new ZException('角色不存在');
        }
        $res = $role->save($data);
        return success($res, '修改成功');
    }


    public function delete()
    {
        $roleId = $this->request->param('id');
        if (!$roleId) {
            throw new ZException('缺少角色ID');
        }
        $row = ModelRole::with(['roleMenu'])->find($roleId);
        if (!$row) {
            throw new ZException("角色已删除");
        }
        $res = $row->together(['roleMenu'])->delete();
        return success($res, '删除成功');
    }

    public function getAuthByRole()
    {
        $id = $this->request->param("id");
        $model = new ModelRole();
        $row = $model->find($id);
        if (!$row) {
            throw new ZException("数据不存在");
        }
        $menus = $row->roleMenu;
        $arr = [];
        foreach ($menus as $value) {
            $arr[] = $value['menu_id'];
        }
        return success($arr);
    }

    public function setAuth()
    {
        $id = $this->request->param('id');
        $choose = $this->request->param("choose");

        if (!$id) {
            throw new ZException("角色ID不能为空");
        }

        // if (!$choose || !is_array($choose)) {
        //     throw new ZException("菜单数据参数错误");
        // }

        $domain = new Rbac();
        $domain->addRoleMenu($id, $choose);

        return success(true, "操作成功");
    }
}
