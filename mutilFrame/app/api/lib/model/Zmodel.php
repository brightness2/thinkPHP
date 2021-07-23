<?php

declare(strict_types=1);

namespace app\api\lib\model;

use think\Model;
use app\api\lib\model\Sequence;

/**
 * @mixin \think\Model
 */
abstract class Zmodel extends Model
{
    protected $SeqName = false; //计数序列
    protected $SeqAutoCreate = true; //计数序列自动创建
    protected $SeqPkPrefix = 'S'; //计数主键前缀

    /**
     * 搜索列表
     */
    static public function getList($search = [])
    {
        $arr = [];
        if (is_array($search)) {
            foreach ($search as $key => $value) {
                if ($value !== null and $value !== '') {
                    $arr[$key] = $value;
                }
            }
        }
        $keys = array_keys($arr);
        return self::withSearch($keys, $arr)->select();
    }

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

    /*****************搜索器************************* */
    public function searchPageAttr($query, $value, $data)
    {
        if (is_array($value) and count($value) == 2) {
            $query->page((int)$value[1], (int)$value[0]);
        }
    }
}
