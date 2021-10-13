<?php

declare(strict_types=1);

namespace app\lib\model;

use app\lib\exception\ZException;
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
     * 搜索列表
     *
     * @param array $search 搜索条件
     * @param array $with   关联模型
     * @return object
     */
    static public function getList($search = [], $with = [])
    {

        $s = self::parseSearch($search);
        try {
            $rows = self::withSearch($s['keys'], $s['arr'])->with($with)->select();
        } catch (\Exception $e) {
            $rows = self::select([0]);
        }
        return $rows;
    }

    /**
     * 拼接搜索条件
     *
     * @param array $arr
     * @return array
     */
    static public function parseSearch($search = [])
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
        return [
            'arr' => $arr,
            'keys' => $keys,
        ];
    }

    /**
     * 批量修改某个字段
     *
     * @param array $keys
     * @param string $field
     * @param string $value
     * @return object
     */
    public function changeField($keys, $field, $value)
    {
        if (!is_array($keys)) {
            if (is_string($keys)) {
                $keys = explode(',', $keys);
            } else {
                throw new ZException('keys参数不存在或参数错误');
            }
        }

        return $this->whereIn($this->getPk(), $keys)->update([$field => $value]);
    }

    /**
     * 批量删除
     *
     * @param array $keys
     * @return void
     */
    public function deleteMore($keys)
    {
        if (!is_array($keys)) {
            if (is_string($keys)) {
                $keys = explode(',', $keys);
            } else {
                throw new ZException('keys参数不存在或参数错误');
            }
        }
        return $this->whereIn($this->getPk(), $keys)->delete();
    }

    /**
     * 新增前事件
     *
     * @param object $row
     * @return void
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

    public function searchLimitAttr($query, $value)
    {
        $query->limit((int)$value);
    }

    public function searchPageAttr($query, $value)
    {
        $query->page((int)$value);
    }
}
