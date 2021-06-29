<?php

namespace app\controller;

use app\BaseController;
use think\facade\Config;
use think\Response;
use think\facade\Request;

abstract class Base extends BaseController
{

    protected $page;
    protected $pageSize;

    public function __construct()
    {
        $this->page = (int)Request::param('page');
        $this->pageSize = (int)Request::param('page_size', Config::get('app.page_size'));
    }

    /**
     * 
     */
    protected function create($data, string $msg = '', int $code = 200, string $type = 'json'): Response
    {
        //标准api数据结构
        $result = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        return Response::create($result, $type);
    }

    /**
     * 404 方法不存在处理
     */
    public function __call($name, $arg)
    {
        return $this->create([], '接口不存在~', 404);
    }
}
