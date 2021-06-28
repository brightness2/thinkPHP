<?php

namespace app\middleware;

/**
 * 后置中间件
 */
class After
{
    /**
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        //处理http请求
        echo '<br/>后置处理<br/>';

        //固定写法
        return $response; //本身返回Response对象

    }
}
