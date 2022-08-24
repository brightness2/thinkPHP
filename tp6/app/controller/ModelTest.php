<?php

namespace app\controller;

use app\BaseController;
use app\model\Info as InfoModel;
use app\model\User as UserModel;
use think\db\Where;

class ModelTest extends BaseController
{
    public function index()
    {
        return UserModel::select();
    }

    /**
     * 新增
     */
    public function test1()
    {

        //方式一
        // $model = new UserModel();
        // $model->name = '李白';
        // $model->save();

        //方式二
        // $data2 = ['name' => '杜甫', 'other' => 'jjjj'];
        // $model = new UserModel();
        // $res = $model->save($data2);
        // var_dump($res); //true


        //批量新增
        // $data3 = [['name' => 'Brightness'], ['name' => 'tom']];
        // $model = new  UserModel();
        // $model->saveAll($data3);

        //方法三 （推荐）
        // $data4 = ['name' => '杜甫', 'other' => 'jjjj'];
        // $user = UserModel::create($data4);
        // return $user->id;
    }

    /**
     * 删除
     */
    public function test2()
    {
        //方法一
        // $user = UserModel::find(13);
        // var_dump($user->delete()); //true

        //方法二 
        // $res = UserModel::destroy(1);
        // var_dump($res); //true

        // UserModel::where('id', '>', 20)->delete();

        // UserModel::destroy(function ($query) {
        //     $query->where('id', '>', 20);
        // });
    }

    /**
     * 更新
     */
    public function test3()
    {
        //方式一
        // $user = UserModel::find(4);
        // $user->name = '李白';
        // $user->age = Db::raw('age + 1');
        // $user->save(); #数据没有变化，不更新

        // $user->force()->save(); #强行更新

        //批量更新，通过id
        // $data = [
        //     ['id' => 4, 'name' => '张三'],
        //     ['id' => 5, 'name' => '李四'],
        // ];
        // $model = new UserModel();
        // $model->saveAll($data);

        // 方式二 推荐
        $data2 =  ['id' => 5, 'name' => '李四'];

        UserModel::update($data2);
    }

    /******************* 查询 ********************* */
    /**
     * 基础查询
     */
    public function test4()
    {
        //单条查询
        $user = UserModel::find(4);
        $user = UserModel::where('id', '=', 4)->find(); //没有查询到返回null
        $user = UserModel::where('id', '=', 4)->findOrEmpty(); //没有查询到返回空模型
        $user->isEmpty(); //判断是否为空模型;
        $user = UserModel::where('id', '=', 4)->value('name'); //没有查询到返回null
        $user = UserModel::getByName('tom'); //没有查询到返回null,getBy字段名(),字段名要大驼峰


        //多条查询
        $user = UserModel::select([3, 4]);
        $user = UserModel::whereIn('id', [3, 4])->column('name', 'id');

        //聚合查询
        $user = UserModel::count();
        $user = UserModel::max('age');
        $user = UserModel::min('age');
        $user = UserModel::avg('age');

        //chunk() 分批处理 ,cursor() 游标
        UserModel::chunk(3, function ($arr) {
            foreach ($arr as $v) {
                echo $v->name . '<br/>';
            }
        });
        echo '----------------<br/>';
        foreach (UserModel::where('age', 1)->cursor() as $val) {
            echo $val->name . '<br/>';
        }

        // return json($user);
    }

    /******* 封装查询 查询范围 ********** */
    public function test5()
    {
        // $res = UserModel::scope('age')->select();
        // return json($res);

        // 关闭全局查询范围
        // User::withoutGlobalScope()->select();
        // 关闭部分全局查询范围。
        // User::withoutGlobalScope(['status'])->select();
    }

    /**************** 数据集 *********************** */
    public function test6()
    {
        $collection = UserModel::select();
        //是否为空
        // $collection->isEmpty();

        //	合并其它数据
        // $collection->merge($collection2);
        //	比较数组，返回差集
        // $collection->diff($collection2);
        //比较数组，返回交集
        // $collection->intersect($collection2);

        //隐藏字段
        // $res = $collection->hidden(['name', 'age']);

        //添加字段
        // $res = $collection->append(['other']);

        //只显示字段
        $res = $collection->visible(['name', 'age', 'cdate']);

        return json($res);
    }

    /****************** 关联模型 *************************** */
    /**
     * 一对一
     */
    public function test7()
    {
        //主表获取关联
        $user = UserModel::find(3);
        $infoData = $user->info;

        //从表获取关联
        $info = InfoModel::find(1);
        $userName = $info->user->name;

        //根据关联数据查询
        $user =  UserModel::hasWhere('info', ['id' => 2])->find(); #'inof'表示user模型的info方法
        $user = UserModel::hasWhere('info', function ($query) {
            $query->where('phone', 'like', '%1%');
        })->select();

        // $user =  UserModel::with(['info', 'two'])->find(1);#关联多个


        //关联保存,新增和更新的区别是info()和info
        $user2 = UserModel::find(5);
        if (!$user2->info) {
            $res =  $user2->info()->save(['phone' => '144']); #新增，$user2->info()
        } else {
            $res = $user2->info->save(['phone' => '666']); #更新,$user2->info
        }

        //删除主表信息时，同时删除从表信息,注意要with()
        $user3 = UserModel::with('info')->find(14);
        $user3->together(['info'])->delete();


        return json($res);

        // return json($user);
    }

    /**
     * 一对多
     */
    public function test8()
    {
        $user = UserModel::find(3);
        $roleData = $user->roles;
        // [{"id":1,"user_id":3,"role":"管理员"},{"id":2,"user_id":3,"role":"销售"}]

        //筛选从表数据
        $roleData = $user->roles()->where('id', '>', 1)->select(); #注意是roles()


        //关联新增，批量关联新增
        $user = UserModel::find(5);
        // $user->roles()->save(['role' => '会计']);#新增一条
        // $user->roles()->saveAll([
        //     ['role' => '前台'],
        //     ['role' => '设计'],
        // ]);

        //删除主表信息时，同时删除从表全部关联信息,注意要with()
        // $user2 = UserModel::with('roles')->find(4);
        // $user2->together(['roles'])->delete();
    }

    /**
     * 关联预载入
     * 一对多，主表同时查找多条，从表关联查询
     */
    public function test9()
    {
        $users = UserModel::with(['info', 'roles'])->select([3, 5]);
        // foreach ($users as $user) {
        //     $user->info;
        // }

        //延迟预载入
        $users = UserModel::select([3, 5]);
        $users->load(['info']);

        return json($users);
    }

    /**
     * or 查询
     * 通过闭包实现
     * @return void
     */
    public function test10()
    {
        $where = [
            'admin_id' => ['in',[5,6]],
            'id'=> ['in',[4,3]],
        ];
        $whereOr = [
            'stf_id'=>'S0007',
            'id'=> ['in',[4,3]],
        ];
        $users = UserModel::where(function($query) use($where){
            $query->where($where);
        })
        ->whereOr(function ($query) use($whereOr)
        {
            $query->where($whereOr);
        })
        ->select();

    }
}
