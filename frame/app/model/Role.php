<?php

declare(strict_types=1);

namespace app\model;

use app\lib\model\Zmodel;

/**
 * @mixin \think\Model
 */
class Role extends Zmodel
{
    protected $pk = 'role_id';
}
