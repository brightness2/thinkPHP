<?php


namespace app\subscribe;

use app\lib\domain\JWT;
use think\facade\Cookie;

/**
 * 需要在app/event.php subscribe中配置 'UserSub' => \app\subscribe\UserSub::class,
 */
class UserSub
{
    /**
     * 方法名必须是on开头，后面大驼峰
     * 如：onUserLogin(),触发 event('UserLogin')
     */
    public function onUserLogin($userId)
    {

        $token = JWT::signToken($userId);
        Cookie::set('token', $token);
    }

    public function onUserLogout()
    {
        Cookie::set('token', '');
    }
}
