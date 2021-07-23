<?php

declare(strict_types=1);

namespace app\api\lib\model\rbac;

use app\api\lib\model\Zmodel;

/**
 * @mixin \think\Model
 */
class RolePermission extends Zmodel
{
    protected $pk = 'rp_id';
}
