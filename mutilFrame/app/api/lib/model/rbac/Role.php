<?php

declare(strict_types=1);

namespace app\api\lib\model\rbac;

use app\api\lib\model\Zmodel;

/**
 * @mixin \think\Model
 */
class Role extends Zmodel
{
    protected $pk = 'role_id';
}
