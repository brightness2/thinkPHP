<?php

declare(strict_types=1);

namespace app\lib\exception;

/**
 * 自定义异常
 */
class ZException extends \RuntimeException
{
    public function __construct($msg, $data = null, $errCode = null, $code = 200)
    {
        $this->error = $msg;
        $this->msg = $msg;
        $this->data = $data;
        if ($errCode === null) {
            $this->errCode =  config('errCode.default');
        } else {
            $this->errCode = $errCode;
        }

        $this->code = $code;
    }

    /**
     * 获取验证错误信息
     * @access public
     * @return array|string
     */
    public function getError()
    {
        return $this->error;
    }
}
