<?php

declare(strict_types=1);

namespace app\lib\exception;

use app\lib\exception\ZException;


/**
 * 自定义异常
 */
class ForbbidenException extends ZException
{
    public function __construct($msg = '没有权限', $data = null, $errCode = 403, $code = 200)
    {
        if ($errCode === null) {
            $errCode = config('errCode.forbbiden');
        }
        parent::__construct($msg, $data, $errCode, $code);
    }
}
