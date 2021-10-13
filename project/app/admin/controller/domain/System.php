<?php

namespace app\admin\controller\domain;

use app\BaseController;
use app\model\Menu;

class System extends BaseController
{

    public function getAllMenu()
    {
        $rows = Menu::select();
        return success($rows->append(["checkArr"]));
    }
}
