<?php

declare(strict_types=1);

namespace app\api\lib\model\rbac;

use app\api\lib\model\Zmodel;
use app\api\lib\model\rbac\Role;

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
