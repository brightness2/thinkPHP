<?php

declare(strict_types=1);

namespace app\model;

use app\lib\model\Zmodel;

/**
 * @mixin \think\Model
 */
class RolePermission extends Zmodel
{
    protected $pk = 'rp_id';
}
