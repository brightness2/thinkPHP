<?php

declare(strict_types=1);

namespace app\controller;

use app\model\User as ModelUser;
use app\validate\User as ValidateUser;
use Exception;
use think\exception\ValidateException;
use think\facade\Validate;
use think\Request;

class User extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $users = ModelUser::field('id,name')
            ->page($this->page, $this->pageSize)
            ->select();
        if ($users->isEmpty()) {
            return $this->create([], '无数据', 204);
        } else {
            return $this->create($users, '数据请求成功');
        }
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //获取数据
        $data = $request->param();
        try {
            //数据验证
            validate(ValidateUser::class)->check($data);
        } catch (ValidateException $e) {
            return $this->create([], $e->getMessage(), 400);
        }
        // 写入数据
        $id = ModelUser::create($data)->getData('id');
        if (!$id) {
            return $this->create([], '新增失败', 400);
        } else {
            return $this->create($id, '新增成功');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {   //校验参数
        if (!Validate::isInteger($id)) {
            return $this->create([], 'id参数不合法~', 400);
        }
        //查询数据
        $user = ModelUser::field('id,name,age')->find($id);
        //返回结果
        if (!$user) {
            return $this->create([], '无数据', 204);
        } else {
            return $this->create($user, '数据请求成功');
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
        //校验参数
        if (!Validate::isInteger($id)) {
            return $this->create([], 'id参数不合法~', 400);
        }
        $data =  $request->param();
        try {
            //数据验证
            validate(ValidateUser::class)->scene('update')->check($data);
        } catch (ValidateException $e) {
            return $this->create([], $e->getMessage(), 400);
        }

        $id = ModelUser::update($data)->getData('id');
        if (!$id) {
            return $this->create([], '修改失败', 400);
        } else {
            return $this->create($id, '修改成功');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //校验参数
        if (!Validate::isInteger($id)) {
            return $this->create([], 'id参数不合法~', 400);
        }

        try {
            ModelUser::destroy($id);
        } catch (Exception $e) {
            return $this->create([], '错误或无法删除~', 400);
        }


        return $this->create([], '删除成功');
    }

    /**
     * 获取用户角色
     */
    public function roles($id)
    {
        //校验参数
        if (!Validate::isInteger($id)) {
            return $this->create([], 'id参数不合法~', 400);
        }
        $user = ModelUser::find($id);
        if (!$user) {
            return $this->create([], '用户不存在', 400);
        }
        $roles = $user->roles;
        if ($roles->isEmpty()) {
            return $this->create([], '无数据', 204);
        } else {
            return $this->create($roles, '请求成功');
        }
    }

    /**
     * 登录
     */
    public function login(Request $request)
    {
        $data = $request->param();

        $vali = Validate::rule([
            'name' => 'unique:user,name^password', #同时存在name，password
        ])->check($data);
        if (!$vali) {
            session('admin', $data['name']);
            return $this->create(true, '登录成功');
        } else {
            return $this->create([], '用户或密码错误');
        }
    }
}
