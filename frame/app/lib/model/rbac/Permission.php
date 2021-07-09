<?php

declare(strict_types=1);

namespace app\model;

use app\lib\model\Zmodel;

/**
 * @mixin \think\Model
 */
class Permission extends Zmodel
{
    protected $pk = 'per_id';
}
