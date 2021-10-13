<?php

namespace app\lib\domain;

/**
 * 工具类
 */
class Tools
{

    /**
     * 把数据集转换成Tree
     *
     * @param array $list 要转换的数据集
     * @param string $pk 主键字段
     * @param string $pid 父级字段
     * @param string $child 子级字段
     * @param mixed $root  无父级的父级字段值
     * @return array
     */
    static public  function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = 'children', $root = 0)
    {

        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] = &$list[$key];
            }

            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    //找顶级部门,将现在遍历的顶级数组变量地址赋值给找到顶级分类
                    $tree[] = &$list[$key];
                } else {
                    //如果不是顶级部门,进来通过之前生成基于主键索引的找他上级
                    if (isset($refer[$parentId])) {
                        ////找到他上级
                        $parent = &$refer[$parentId]; //生成一个临时子集变量将他的父级数据地址写进去
                        $parent[$child][] = &$list[$key]; //将他写进带他爸爸数据的临
                        //时子集变量里,因为是变量地址,所以修改时修改是同步进行的,所以引用
                        //索引的地址改变后在数据源数组内也会跟着改变
                    }
                }
            }
        }
        return $tree;
    }
}
