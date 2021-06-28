<?php

namespace app\subscribe;

class UserSub
{
    /**
     * 方法名必须是on开头，后面大驼峰
     * 如：onUserLogin(),触发 event('UserLogin')
     */
    public function onUserLogin()
    {
        echo '处理登录后';
    }

    public function onUserLogout()
    {
        echo '处理退出登录后';
    }
}
