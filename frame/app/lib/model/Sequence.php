<?php

declare(strict_types=1);

namespace app\lib\model;

use app\lib\exception\CustomizeException;
use think\Model;

/**
 * @mixin \think\Model
 */
class Sequence extends Model
{
    //
    protected $pk = 'seq_name'; #修改对应的主键字段

    /**
     * 获取计数
     */
    static  public function GetSequenceId($SeqName, $AutoCreate = false)
    {
        $seq_no = 0;
        $row =  self::find($SeqName);
        if (!$row) {
            if ($AutoCreate) {
                $createData = [
                    'seq_name' => $SeqName,
                    'seq_no' => 1,
                    'seq_last_update' => date('Y-m-d H:i:s'),
                ];
                return self::create($createData)->getData('seq_no');
            } else {
                throw new CustomizeException($SeqName . '序列不存在', null, config('errCode.query'));
            }
        }

        $seq_no = $row->seq_no;
        $row->seq_no = $seq_no + 1;
        $row->seq_last_update =  date('Y-m-d H:i:s');
        $row->save();
        return $seq_no;
    }
}
