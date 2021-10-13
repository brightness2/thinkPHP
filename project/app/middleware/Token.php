<?php

declare(strict_types=1);

namespace app\middleware;

use app\lib\domain\JWT;

class Token
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //前置，校验token
        $action = $request->controller() . '/' . $request->action();
        $except = config('middleware.except.checkToken'); //排除的操作
        $newToken = null;
        if (!in_array($action, $except)) {
            $token = $request->header('token');
            if (!$token) $token = $request->param('token');
            $data = JWT::checkToken($token);
            $GLOBALS['USER'] = $data['data'];
            $newToken = $data['newToken'];
        }

        //执行响应
        $response =  $next($request);

        //响应后,修改返回的数据
        $res = $response->getData();
        if (is_array($res)) {
            $res['newToken'] = $newToken;
        }
        $response->data($res);

        //返回响应
        return $response;
    }
}
