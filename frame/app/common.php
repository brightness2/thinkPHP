<?php
// 应用公共文件

//返回结果
function success($data = null, $msg = '请求成功', $errCode = 0, $statusCode = 200)
{
    $jsonData = [
        'msg' => $msg,
        'data' => $data,
        'errCode' => $errCode,
    ];
    return json($jsonData, $statusCode);
}
