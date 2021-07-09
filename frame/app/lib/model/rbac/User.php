<?php

declare(strict_types=1);

namespace app\model;

use app\lib\model\Zmodel;

/**
 * @mixin \think\Model
 */
class User extends Zmodel
{
    protected $pk = 'user_id';
    protected $SeqName = 'user';
    protected $SeqPkPrefix = 'U'; //计数主键前缀

}
