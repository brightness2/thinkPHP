<?php

declare(strict_types=1);

namespace app\middleware;

use app\lib\domain\JWT;
use app\lib\exception\ForbbidenException;

/**
 * 后台中间件，校验cookie
 */
class Cookie
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
        //前置校验cookie中的token
        $action = $request->controller() . '/' . $request->action();
        $except = config('middleware.except.checkToken'); //排除的操作
        if (!in_array($action, $except)) {
            $token = cookie('token');
            //没有token拒绝访问,可以跳转到登录页
            if (!$token) {
                // throw new ForbbidenException('请先登录');
                return redirect('/public/admin.php/login', 200);
            }
            try {
                $data = JWT::checkToken($token);

                $GLOBALS['USER'] = $data['data'];
                //刷新token
                if ($data['newToken']) {
                    cookie('token', $data['newToken']);
                }
            } catch (\Exception $e) {
                // throw new ForbbidenException('请先登录');
                return redirect('/public/admin.php/login', 200);
            }
        }

        //执行响应
        $response =  $next($request);
        //返回响应
        return $response;
    }
}
