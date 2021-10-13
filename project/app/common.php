<?php
// 应用公共文件
define('DS', DIRECTORY_SEPARATOR); #路径分隔符

/**
 * 加密算法
 */
function encryptPwd($str, $salt = null)
{
    if (!$salt) {
        $salt = config('account.encryptSalt');
    }
    return md5(md5($str) . $salt);
}

/**
 * 返回结果
 */
function success($data = null, $msg = '', $errCode = 0, $statusCode = 200)
{
    $jsonData = [
        'msg' => $msg,
        'data' => $data,
        'errCode' => $errCode,
    ];
    return json($jsonData, $statusCode);
}
