<?php

namespace app\model;

use think\Model;


class Info extends Model
{
    /**
     * user 是主表，info是从表
     * 一对一
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
