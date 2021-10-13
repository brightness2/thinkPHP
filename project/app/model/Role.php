<?php

namespace app\model;

use app\lib\model\Zmodel;

class Role extends Zmodel
{
    public function roleMenu()
    {
        return  $this->hasMany(RoleMenu::class);
    }

    public function menus()
    {
        return $this->hasManyThrough(Menu::class, RoleMenu::class, 'role_id', 'id', 'id', 'menu_id');
    }

    public function searchRoleNameAttr($query, $value)
    {
        $query->where('name', 'like', '%' . $value . '%');
    }
}
