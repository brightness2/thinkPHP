<?php

declare(strict_types=1);

namespace app\lib\model;

use think\Model;
use app\lib\model\Sequence;

/**
 * @mixin \think\Model
 */
abstract class Zmodel extends Model
{
    protected $SeqName = false; //计数序列
    protected $SeqAutoCreate = true; //计数序列自动创建
    protected $SeqPkPrefix = 'S'; //计数主键前缀

    /**
     * 新增前事件
     */
    public static  function onBeforeInsert($row)
    {
        //$SeqName != false 使用计数主键
        if ($row->SeqName) {
            $id = Sequence::GetSequenceId($row->SeqName, $row->SeqAutoCreate);
            $id = sprintf('%04d', $id);
            $pk = $row->pk;
            $row->$pk = $row->SeqPkPrefix . $id;
        }
    }
}
