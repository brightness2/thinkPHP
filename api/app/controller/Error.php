<?php

namespace app\controller;

class Error extends Base
{
    public function index()
    {
        return $this->create([], '资源错误~', 404);
    }
}
