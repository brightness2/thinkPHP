<?php

namespace app\admin\controller\domain;

use app\BaseController;
use app\lib\domain\Rbac;
use app\lib\exception\ZException;
use app\model\User as ModelUser;

class User extends BaseController
{
    public function get()
    {
        $userId = $this->request->param('id');
        if (!$userId) {
            throw new ZException('缺少用户ID');
        }
        $row = ModelUser::with(['roles'])->find($userId);
        if (!$row) {
            throw new ZException('用户信息不存在');
        }
        return success($row);
    }

    public function getList()
    {
        $param = $this->request->param();
        $model = new ModelUser();
        $data = $model->getList($param);
        $res = [
            'list' => $data->hidden(['pass']),
            'total' => $model->count()
        ];
        return success($res);
    }

    /**
     * 新增用户
     *
     * @return json
     */
    public function add()
    {

        $roles = $this->request->param('roles');
        $data = $this->request->except(['roles']);
        $this->validate($data, 'app\validate\User.create');
        $has = ModelUser::getByName($data['name']);
        if ($has) {
            throw new ZException('账号已存在,请使用其它账号');
        }
        $data['pass'] = encryptPwd('123456');
        $id = ModelUser::create($data)->getKey();
        if ($roles) {
            if (!is_array($roles)) {
                $roles = explode(',', $roles);
            }
            (new Rbac())->addUserRoles($id, $roles);
        }
        return success($id, '创建成功');
    }

    /**
     * 更新用户
     *
     * @return void
     */
    public function edit()
    {
        $roles = $this->request->param('roles');
        $data = $this->request->except(['pass', 'roles']);

        $this->validate($data, 'app\validate\User.update');
        $row = ModelUser::find($data['id']);
        if (!$row) {
            throw new ZException('用户信息不存在');
        }
        $has = ModelUser::getByName($data['name']);
        if ($has) {
            if ($has->id != $row->id) {
                throw new ZException('账号已存在,请使用其它账号');
            }
        }

        if ($roles and !is_array($roles)) {
            $roles = explode(',', $roles);
        }
        (new Rbac())->addUserRoles($data['id'], $roles);

        $res = $row->save($data);
        return success($res, '更新成功');
    }

    /**
     * 删除一个用户
     *
     * @return void
     */
    public function delete()
    {

        $userId = $this->request->param('id');

        if (!$userId) {
            throw new ZException('主键不能为空');
        }
        $model = new ModelUser();
        $row =  $model->with(['userRole'])->find($userId);
        if (!$row) {
            throw new ZException('数据已删除');
        }
        $res =  $row->together(['userRole'])->delete();
        return success($res, '删除成功');
    }

    public function deleteMore()
    {
        $keys = $this->request->param('keys');
        if (!is_array($keys)) {
            throw new ZException('主键集参数错误');
        }
        $model = new ModelUser();
        // $rows = $model->with(['userRole'])->whereIn('id', $keys)->select();
        // $res = $rows->together(['userRole'])->delete();//不支持批量together
        foreach ($keys as $key) {
            $row = $model->with(['userRole'])->find($key);
            if (!$row) continue;
            $row->together(['userRole'])->delete();
        }
        return success(true, '删除成功');
    }
}
