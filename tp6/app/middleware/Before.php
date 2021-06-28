<?php

namespace app\middleware;

/**
 * 前置中间件
 */
class Before
{
    /**
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //处理http请求
        echo '前置处理<br/>';

        //固定写法
        return $next($request); //本身返回Response对象

    }
}
