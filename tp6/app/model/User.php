<?php

namespace app\model;

use think\Model;

class User extends Model
{

    /**
     *user 是主表，role是从表
     * 一对多
     */
    public function roles()
    {
        return $this->hasMany(Role::class, 'user_id', 'id');
    }


    /**
     * user 是主表，info是从表
     * 一对一
     */
    public function info()
    {

        return  $this->hasOne(Info::class, 'user_id', 'id');
    }


    // 设置字段信息，默认会自动获取（包括字段类型）,
    //最好做以下操作，减少一次查询,做字段缓存，
    //终端执行命令 php think optimize:schema 生成，
    // 修改 config/database.php 字段缓存配置为true
    // protected $schema = [
    //     'id'          => 'int',
    //     'name'        => 'string',
    //     'status'      => 'int',
    //     'score'       => 'float',
    //     'create_time' => 'datetime',
    //     'update_time' => 'datetime',
    // ];
    // protected $connection = 'demo'; #切换数据库
    // protected $table = 'tableName';#修改数据表名
    // protected $pk = 'id';#修改对应的主键字段
    // protected $defaultSoftDelete = 0;#软删除字段默认值
    // protected $autoWriteTimestamp = true;#开启自动时间戳
    // 定义时间戳字段名
    //  protected $createTime = 'create_at';
    //  protected $updateTime = 'update_at';
    // protected $readonly = ['name', 'email'];#设置只读字段
    // protected $globalScope = ['status'];#全局查询范围
    // protected $type = ['age' => 'boolean', 'cdate' => 'datetime:Y-m']; #类型转换
    /**
     * 获取器，
     * get属性名Attr，属性名是模型实例的属性，
     * 访问模型实例的属性时 $modle->属性名 得到修改器返回的值
     */
    // public function getNameAttr($value,$data)
    // {
    //      $status = [0=>'禁用',1=>'正常'];
    //      return $status[$data['name']];
    // }

    /**
     * 修改器,写入数据库前把字段的数据进行操作
     * set字段名Attr
     */
    // public function setFieldNameAttr($value)
    // {
    //      return strtoupper($value);
    // }

    /************ 查询范围 ************************ */
    /**
     * 封装查询 查询范围
     * scope名称,Model::scope('名称')->select();
     * 控制器调用时 , UserModel::scope('age')->select();
     */
    // public function scopeAge($query)
    // {
    //     $query->where('age', 1)->field(['name', 'cname'])->limit(2);
    // }

    /**
     * 全局查询范围，需要设置 protected $globalScope = ['status'];
     */
    // public function scopeStatus($query, $value = 1)
    // {
    //     $query->where('status', $value);
    // }

    /********** 模型事件 ********** */
    // public static function onBeforeUpdate($user)
    // {
    // 	if ('thinkphp' == $user->name) {
    //     	return false;
    //     }
    // }

    // public static function onAfterDelete($user)
    // {
    // 	Profile::destroy($user->id);
    // }


}
