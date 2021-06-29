<?php

namespace app\model;

use think\Model;

class User extends Model
{
    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id', 'id');
    }
}
