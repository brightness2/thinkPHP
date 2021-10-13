<?php

declare(strict_types=1);

namespace app;

use think\App;
use app\BaseController;
use app\model\User;
use think\facade\View;

abstract class PageController extends BaseController
{
    public function __construct(App $app)
    {
        if (isset($GLOBALS['USER'])) {
            $user = User::find($GLOBALS['USER']->uid);
            View::assign('user', $user->hidden(['pass']));
        }

        parent::__construct($app);
    }

    function __call($name, $arguments)
    {
        try {
            return View::fetch($name);
        } catch (\Exception $e) {
            return View::fetch('common/404');
        }
    }
}
