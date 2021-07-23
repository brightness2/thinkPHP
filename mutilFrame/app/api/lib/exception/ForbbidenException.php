<?php

declare(strict_types=1);

namespace app\api\lib\exception;

use app\api\lib\exception\ZException;

class ForbbidenException extends ZException
{
    public function __construct($msg = '没有权限', $data = null, $errCode = 403, $code = 403)
    {
        if ($errCode === null) {
            $errCode = config('errCode.forbbiden');
        }
        parent::__construct($msg, $data, $errCode, $code);
    }
}
