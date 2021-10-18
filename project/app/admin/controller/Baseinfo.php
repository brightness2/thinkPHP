<?php

declare(strict_types=1);

namespace app\admin\controller;

use app\model\GoodsCate;
use app\model\GoodsUnit;
use app\PageController;
use think\facade\View;

class Baseinfo extends PageController
{

    public function goodsForm()
    {
        try {
            $categories = GoodsCate::select();
            $unites = GoodsUnit::select();
        } catch (\Exception $e) {
            $categories = [];
            $unites = [];
        }

        View::assign('categories', $categories);
        View::assign('unites', $unites);

        return View::fetch('baseinfo/goodsForm');
    }

    public function goodsCateForm()
    {
        try {
            $categories = GoodsCate::select();
        } catch (\Exception $e) {
            $categories = [];
        }

        View::assign('categories', $categories);

        return View::fetch('baseinfo/goodsCateForm');
    }
}
