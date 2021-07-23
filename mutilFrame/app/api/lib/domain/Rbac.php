<?php

namespace app\api\lib\domain;

use app\api\lib\exception\ZException;
use app\api\lib\model\rbac\Permission;
use app\api\lib\model\rbac\Role;
use app\api\lib\model\rbac\RolePermission;
use app\api\lib\model\rbac\UserRole;
use think\facade\Db;

class Rbac
{
    /**
     * 添加角色
     */
    public function addRole($data)
    {
        $role = Role::create($data);
        if (!$role->role_id) {
            throw new ZException('添加失败', null, config('errCode.query'));
        }
        return $role->role_id;
    }

    /**
     * 更新角色
     */
    public function updateRole($roleId, $data)
    {
        $role = Role::find($roleId);
        if (!$role) {
            throw new ZException('角色不存在');
        }
        $res = $role->save($data);
        return $res;
    }

    /**
     * 删除角色
     */
    public function deleteRole($roleId)
    {
        $res = Role::where('role_id', $roleId)->delete();
        return $res;
    }

    /**
     * 添加权限
     */
    public function addPermission($data)
    {
        $permission = Permission::create($data);
        if (!$permission->per_id) {
            throw new ZException('添加失败', null, config('errCode.query'));
        }
        return $permission->per_id;
    }

    /**
     * 更新权限
     */
    public function updatePermission($perId, $data)
    {
        $permission = Permission::find($perId);
        if (!$permission) {
            throw new ZException('权限不存在');
        }
        $res = $permission->save($data);
        return $res;
    }

    /**
     * 删除权限
     */
    public function deletePermission($perId)
    {
        $res = Permission::where('per_id', $perId)->delete();
        return $res;
    }

    /**
     * 添加用户角色关联
     */
    public function addUserRole($userId, $allData)
    {
        //先删除所有
        UserRole::where('user_id', $userId)->delete();
        //新增
        $user_role = new UserRole();
        return $user_role->saveAll($allData);
    }

    /**
     * 添加角色权限关联
     */
    public function addRolePermission($roleId, $allData)
    {
        //先删除所有
        RolePermission::where('role_id', $roleId)->delete();
        //新增
        $user_role = new RolePermission();
        return $user_role->saveAll($allData);
    }


    /**
     * 根据用户id获取角色
     */
    public function getRolesByUserId($userId)
    {
        $rows = UserRole::with(['role'])->where('user_id', $userId)->select();
        return $rows;
    }

    /**
     * 根据用户id获取权限
     */
    public function getPermissionByUserId($userId, $permissionType = null)
    {
        $dbobj = Db::table('tp_user_role')
            ->alias('ur')
            ->join('tp_role_permission rp', 'ur.role_id = rp.role_id')
            ->join('tp_permission p', 'rp.per_id = p.per_id')
            ->where(['ur.user_id' => $userId]);

        if ($permissionType !== null) {
            $dbobj->where(['p.type' => $permissionType]);
        }

        $data = $dbobj->group('p.per_id') //通过分组去重
            ->column('ur.user_id,p.*'); //只要用户id，以及权限信息
        return $data;
    }

    /**
     * 校验用户是否有某个操作权限
     * @return bool
     */
    public function checkUserPermission($userId, $controller, $action)
    {
        $count = Db::table('tp_user_role')
            ->alias('ur')
            ->join('tp_role_permission rp', 'ur.role_id = rp.role_id')
            ->join('tp_permission p', 'rp.per_id = p.per_id')
            ->where(['ur.user_id' => $userId])
            ->where([
                'p.controller' => $controller,
                'p.action' => $action,
            ])
            ->count();
        return $count > 0; //大于零表示有权限
    }
}
