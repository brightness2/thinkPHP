<?php

namespace app\model;

use app\lib\model\Zmodel;

class User extends Zmodel
{
    // 定义全局的查询范围
    // protected $globalScope = ['deleted'];

    // public function scopeDeleted($query)
    // {
    //     $query->where('deleted', 0);
    // }

    public function userRole()
    {
        return  $this->hasMany(UserRole::class);
    }

    public function roles()
    {
        //SELECT `role`.* FROM `tp_role` `role` INNER JOIN `tp_user_role` ON `tp_user_role`.`role_id`=`role`.`id`
        // INNER JOIN `tp_user` ON `tp_user`.`id`=`tp_user_role`.`user_id` WHERE  `tp_user_role`.`user_id` = '2'                                                           
        return $this->hasManyThrough(Role::class, UserRole::class, 'user_id', 'id', 'id', 'role_id');
    }

    public function searchUserNameAttr($query, $value)
    {
        $query->where('name', 'like', '%' . $value . '%');
    }
}
