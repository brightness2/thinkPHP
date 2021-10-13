<?php

namespace app\admin\controller\domain;

use app\BaseController;
use app\lib\exception\ZException;
use app\model\Menu as ModelMenu;

class Menu extends BaseController
{

    // public function get()
    // {
    //     $id = $this->request->param('id');
    //     if (!$id) {
    //         throw new ZException("菜单ID不能为空");
    //     }
    //     $row = Menu::find($id);
    //     if (!$row) {
    //         throw new ZException("菜单数据不存在");
    //     }
    //     return success($row);
    // }

    public function add()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Menu.createChild');
        $id = (new ModelMenu)->addChildMenu($data['pid'], $data);
        return success($id, "新增成功");
    }

    public function edit()
    {
        $data = $this->request->param();
        $this->validate($data, 'app\validate\Menu.update');
        $res = (new ModelMenu)->editMenu($data['id'], $data);
        return success($res, "修改成功");
    }

    public function delete()
    {
        $id = $this->request->param('id');
        if (!$id) {
            throw new ZException("菜单ID不能为空");
        }
        $res = (new ModelMenu)->deleteMenu($id);
        return success($res, "删除成功");
    }
}
