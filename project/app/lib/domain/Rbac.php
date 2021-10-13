<?php

namespace app\lib\domain;

use app\lib\exception\ZException;
use app\model\RoleMenu;
use app\model\UserRole;

/**
 * RBAC操作
 */
class Rbac
{
    /**
     * 为用户添加角色
     *
     * @param int $userId
     * @param array $roles [1,2]
     * @return void
     */
    public function addUserRoles($userId, $roles)
    {

        UserRole::startTrans();
        try {
            //先删除所有角色
            UserRole::where('user_id', $userId)->delete();
            if (is_array($roles) && count($roles) > 0) {
                //修改实参原数据
                foreach ($roles as $key => $role) {
                    $roles[$key] = ['user_id' => $userId, 'role_id' => $role];
                }
                (new UserRole())->saveAll($roles);
            }
            UserRole::commit();
        } catch (\Exception $e) {
            UserRole::rollback();
            throw new ZException('角色添加失败');
        }
    }


    /**
     * 为角色添加菜单权限
     *
     * @param int $roleId
     * @param array $menus [1,2]
     * @return void
     */
    public function addRoleMenu($roleId, $menus)
    {
        RoleMenu::startTrans();
        try {
            //先删除所有菜单
            RoleMenu::where('role_id', $roleId)->delete();
            if (is_array($menus) && count($menus) > 0) {
                //修改实参原数据
                foreach ($menus as $key => $menu) {
                    $menus[$key] = ['role_id' => $roleId, 'menu_id' => $menu];
                }
                (new RoleMenu())->saveAll($menus);
            }
            RoleMenu::commit();
        } catch (\Exception $e) {
            RoleMenu::rollback();
            throw new ZException('操作失败');
        }
    }
}
