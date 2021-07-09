<?php

declare(strict_types=1);

namespace app\model;

use app\lib\model\Zmodel;
use app\model\Role;

/**
 * @mixin \think\Model
 */
class UserRole extends Zmodel
{
    protected $pk = 'ur_id';

    public function role()
    {
        return  $this->hasOne(Role::class, 'role_id', 'role_id');
    }
}
