<?php

namespace app\controller;

use app\BaseController;
use app\model\User;
use Exception;
use think\facade\Db;

/**
 * Db使用
 */
class DataTest extends BaseController
{
    /**
     * Db使用
     */
    public function index()
    {
        $user = Db::table('tp_user')->select();
        // $user = Db::name('user')->select();#效果同上
        return json($user);
    }

    /**
     * Db 切换数据库
     */
    public function test1()
    {
        $user = Db::connect('demo')->table('tp_user')->select();
        return json($user);
    }

    /**
     * 通过模型查询
     */
    public function test2()
    {
        $user = User::select();
        return json($user);
    }

    /************* 单数据查询 **************** */

    public function test3()
    {
        $user = Db::table('tp_user')->where('id', 1)->find(); //查询不到返回null
        // $user = Db::table('tp_user')->where('id', 1)->findaOrFail();//查询不到抛出异常
        // $user = Db::table('tp_user')->where('id', 1)->findOrEmpty();//查询不到返回空数组


        // $user2 = User::

        return json($user);
    }

    /******************* 数据集查询 ********************** */

    public function test4()
    {
        $user = Db::table('tp_user')->select();
        // $user = Db::table('tp_user')->selectOrFail();
        // $user = Db::table('tp_user')->select()->toArray();

        return json($user);
    }

    /**
     * 查询自定字段
     */
    public function test5()
    {
        $name = Db::name('user')->where('id', 2)->value('name');
        // $name = Db::name('user')->column('name'); //[0=>Brightness,1=>admin]

        // $name = Db::name('user')->column('name', 'id'); //[1=>Brightness,2=>admin]

        // $name = Db::name('user')->column('name', 'name'); //[Brightness=>Brightness,admin=>admin]


        return $name;
    }

    /**
     * 查询的数据量大，可以使用chunk() 方法
     * 分批处理，
     */
    public function test6()
    {
        //每批处理1条
        Db::name('user')->chunk(1, function ($arr) {
            foreach ($arr as $v) {
                dump($v);
            }
            echo 1;
        });
    }

    /**
     * 查询的数据量大，可以使用cursor() 方法
     * 游标，使用的是php 生成器的功能
     */
    public function test7()
    {

        $cursor = Db::name('user')->cursor();
        foreach ($cursor as $user) {
            dump($user);
        }
    }

    /**
     * 多次查询时，推荐把查询对象用变量存储起来
     * 减少查询对象的创建
     */
    public function test8()
    {
        $query = Db::name('user');
        $user = $query->where('id', 2)->select();
        //注意，$query 的查询条件会保留下拉，下次调用是通过removeOption()清除
        $user = $query->removeOption()->select();
        return json($user);
    }

    /******************* 打印sql******************* */
    /**
     * 打印sql
     */
    public function test()
    {
        Db::table('tp_user')->where('id', 1)->find();
        return Db::getLastSql();
        //SELECT * FROM `tp_user` WHERE `id` = 1 LIMIT 1
    }


    /****************** 数据新增 ************************** */
    /**
     * 单数据新增
     */
    public function test9()
    {
        $data = ['name' => 'test9'];
        // Db::name('user')->insert($data); //true

        //如果想强行新增抛弃不存在的字段数据，则使用strict(false) 方法，忽略异常
        return Db::name('user')->strict(false)->insertGetId($data); //4
        return Db::name('user')->insertGetId($data); //4

    }

    /**
     * 批量新增
     */
    public function test10()
    {
        $data = [
            ['name' => 'test10'],
            ['name' => 't10', 'age' => 10],

        ];

        return Db::name('user')->strict(false)->insertAll($data); //返回新增条数2
    }

    /**
     * save() 方法
     * 新增与更新
     * 按是否存在主键，进行新增/更新
     */
    public function test11()
    {
        $data = [
            'id' => 5, 'name' => 'test11',
        ];
        return    Db::name('user')->save($data); //true
    }

    /**
     * 更新数据
     */
    public function test12()
    {
        $data = ['name' => 'tom'];
        Db::name('user')->where('id', 2)->update($data);
        $data2 = [
            'id' => 3,
            'name' => 'jhon',
        ];
        //数据包含主键可以省略where条件
        Db::name('user')->update($data2);
        //如果想让一些字段修改时执行SQL函数操作，可以使用exp()方法实现
        Db::name('user')->where('id', 4)->exp('cname', 'UPPER(cname)')
            ->update();

        //自增/自减某一字段，inc/dec方法
        Db::name('user')->where('id', 5)->inc('age')
            ->update();

        //灵活的方式，raw()方法
        Db::name('user')->where('id', 6)->update([
            'cname' => Db::raw('UPPER(cname)'),
            'age' => Db::raw('age + 1'),
        ]);
    }

    /**
     * 删除数据
     */
    public function test13()
    {
        // Db::name('user')->delete(5); //参数是主键值
        // Db::name('user')->delete([2, 6]); //参数是主键值数组,返回删除的条数
        Db::name('user')->where('age', '>', 1)->delete();
    }

    /*************** 数据库的查询表达式 ******************** */
    /**
     * 比较查询
     * 区间查询
     * exp查询
     */
    public function test14()
    {
        // Db::name('user')->where('age', '>', 1)->select();
        //SELECT * FROM `tp_user` WHERE `age` > 1

        // Db::name('user')->where('name', 'like', '%te%')->select();
        //SELECT * FROM `tp_user` WHERE `name` LIKE '%te%'
        // Db::name('user')->where('name', 'like', ['%te%', '%a%'], 'or')->select();
        //SELECT * FROM `tp_user` WHERE (`name` LIKE '%te%' OR `name` LIKE '%a%')

        // Db::name('user')->where('age', 'between', [1, 3])->select();
        // SELECT * FROM `tp_user` WHERE `age` BETWEEN 1 AND 3

        // Db::name('user')->where('age','in',  [1, 3])->select();
        // SELECT * FROM `tp_user` WHERE `age` IN (1,3)
        // Db::name('user')->where('age', 'not in',  [1, 3])->select();
        //SELECT * FROM `tp_user` WHERE `age` NOT IN (1,3)

        Db::name('user')->where('age', 'exp',  'IN (1, 2)')->select();
        //SELECT * FROM `tp_user` WHERE ( `age` IN (1, 2) )
        return Db::getLastSql();
    }

    /**
     *  时间查询
     */
    public function test15()
    {
        $user = Db::name('user')->where('cdate', '>', '2020-1-1')->select();
        $user = Db::name('user')->where('cdate', 'between', ['2019-1-1', '2020-1-1'])->select();

        $user = Db::name('user')->whereYear('cdate')->select(); //查询今年
        //SELECT * FROM `tp_user` WHERE `cdate` BETWEEN '2021-01-01' AND '2021-12-31'
        $user = Db::name('user')->whereMonth('cdate')->select(); //查询当前月
        $user = Db::name('user')->whereDay('cdate')->select(); //查询今天

        $user = Db::name('user')->whereYear('cdate', 'last year')->select(); //查询上一年
        $user = Db::name('user')->whereMonth('cdate', 'last month')->select(); //查询上个月
        $user = Db::name('user')->whereDay('cdate', 'last day')->select(); //查询昨天


        $user = Db::name('user')->whereYear('cdate', '2019')->select(); //查询2019年
        $user = Db::name('user')->whereMonth('cdate', '2021-6')->select(); //查询2021年6月
        $user = Db::name('user')->whereDay('cdate', '2020-11-3')->select(); //查询2019年11月3日


        $user = Db::name('user')->whereTime('cdate', '-2 hours')->select(); //查询2小时前

        // $user = Db::name('user')->whereBetweenTimeField('start_time', 'end_time')->select();
        //查询两个时间字段时间有效期的数据，比如会员的开始时到结束的期间
        //SELECT * FROM `tp_user` WHERE `start_time` <= '2021-1-12' AND `end_time` >= '2021-11-12'

        return Db::getLastSql();
    }

    /********************* 聚合.原生.子查询 ********************** */
    /**
     * 聚合查询
     */
    public function test16()
    {
        $res = Db::name('user')->count();
        $res = Db::name('user')->max('age', false); //第二个参数，是否强制转换为数值
        $res = Db::name('user')->min('age'); //第二个参数，是否强制转换为数值
        $res = Db::name('user')->avg('age'); //第二个参数，是否强制转换为数值
        $res = Db::name('user')->sum('age'); //第二个参数，是否强制转换为数值

        return $res;
    }

    /**
     * 子查询
     */
    public function test17()
    {
        //使用fetchSql()方法，可以设置不执行SQL，而返回SQL语句，默认true
        Db::name('user')->fetchSql(true)->select();
        //SELECT * FROM `tp_user`
        //buildSql()方法，也是返回SQL，不需要执行select() ,且有括号
        Db::name('user')->buildSql(true);
        //( SELECT * FROM `tp_user` )

        //综合以上方法，可以实现一个子查询
        $subQuery = Db::name('user')->field('uid')->where('age', '=', '10')->buildSql(true);
        $res = Db::name('user')->where('id', 'in',  $subQuery)->fetchSql(true)->select();
        // SELECT * FROM `tp_user` WHERE `id` = ( SELECT `uid` FROM `tp_user` WHERE `age` = 10 )

        //闭包方式
        $res = Db::name('user')->where('id', 'in',  function ($query) {
            $query->name('user')->field('uid')->where('age', '>', 12);
        })->fetchSql(true)->select();
        //SELECT * FROM `tp_user` WHERE `id` IN (SELECT `uid` FROM `tp_user` WHERE `age` > 12)
        return $res;
    }

    /**
     * 原生查询
     */
    public function test18()
    {
        //使用query()方法，进行原生SQL查询，适合读取操作，SQL错误返回false
        $user =   Db::query('select * from `tp_user`');

        //使用execute()方法，进行原生SQL查询，适合更新写入，SQL错误返回false
        $user =   Db::execute('update `tp_user` set `age` = 16 where `id` = 4');
        return json($user);
    }

    /********************** 数据库的事务和获取器 **************************** */
    /**
     * 事务
     */
    public function test19()
    {
        //自动处理，出错自动回滚
        // Db::transaction(function () {
        //     Db::name('user')->where('id', 1)->save(['name' => 'test19']);
        //     Db::name('user')->where('id', 6)->save(['age' => Db::raw('age + 6')]);
        //     throw new Exception('jjj');
        // });

        //手动处理
        Db::startTrans();
        try {
            Db::name('user')->where('id', 1)->save(['name' => 'test19']);
            Db::name('user')->where('id', 6)->save(['age' => Db::raw('age + 6')]);
            throw new Exception('jjj');
            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
        }
    }

    /**
     * 获取器
     * 将数据的字段进行转换处理再进行操作
     */
    public function test20()
    {
        $user = Db::name('user')->withAttr('cname', function ($value, $data) {
            return strtoupper($value);
        })->select();

        return json($user);
    }
}
