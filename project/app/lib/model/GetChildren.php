<?php
namespace app\model;

use app\lib\exception\ZException;
use app\lib\model\Zmodel;

class GetChildren extends Zmodel{

    
    protected $temp = [];//临时存储
    protected $count = 1;//计数
   
   /**
    * 递归获取分类的子分类
    * 包括自己
    * @param string $id
    * @return array
    */ 
   public function getChildren($id,$idField='id',$pidField='pid')
   {

      $row = $this->find($id);
      if(!$row){
          return [];
      }
      $children = $this->where($pidField,$row->$pidField)->select();
      $children = $children->toArray();
      if(count($children)>0){
        $this->count++; 
        $this->temp[] = $children;
        foreach($children as $child){
            $this->getChildren($child[$idField]);
        }
      }
      $this->count--; 
      if($this->count <= 0){//递归返回达到第一层
        //查询到的数据降维
        $data = [];
        $data[] = $row;//不要忘了加上自己 categoryId
        $all = $this->temp;
        $this->temp = [];//清除临时存储
        $this->count = 1;
        foreach($all as $arr){
            foreach($arr as $item){
                $data[] = $item;
            }
        }
        return $data;
      }

   }

} 
 