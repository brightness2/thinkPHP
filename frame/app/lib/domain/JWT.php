<?php

namespace app\lib\domain;

use app\lib\exception\ForbbidenException;
use Firebase\JWT\JWT as BaseJWT;

/**
 * 需要通过composer安装php-jwt
 * composer require firebase/php-jwt
 */
class JWT
{

    /**
     * 生成签名
     */
    static public function signToken($userId)
    {
        $key  =  config('token.iss');
        $time = time();
        $token = [
            "iss" => $key,        //签发者 可以为空
            "aud" => config('token.aud'),          //面象的用户，可以为空
            "iat" => $time,      //签发时间
            "nbf" => $time + config('token.nbf'),    //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => $time + config('token.exp'), //token 过期时间
            "refresh" => $time + config('token.exp') - 60,
            "data" => [           //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
                'uid' => $userId,
            ],
        ];

        $jwt = BaseJWT::encode($token,  $key, config('token.alg'));
        return $jwt;
    }

    /**
     * 校验token
     */
    static public function checkToken($token)
    {
        $key = config('token.iss');
        $alg = config('token.alg');
        $time = time();
        try {
            BaseJWT::$leeway = 60; //当前时间减去60，把时间留点余地
            $decoded = BaseJWT::decode($token, $key, array($alg)); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            //解密后token数据
            $res = [
                'data' => $arr['data'],
                'newToken' => null,
            ];
            //达到刷新时间，生成新的token
            if ($time >= $arr['refresh']) {
                $newToken = self::signToken($arr['data']->uid);
                $res['newToken'] = $newToken;
            }
            return $res;
        } catch (\Firebase\JWT\SignatureInvalidException $e) { //签名不正确
            throw new ForbbidenException('签名不正确');
        } catch (\Firebase\JWT\BeforeValidException $e) { // 签名在某个时间点之后才能用
            throw new ForbbidenException('token失效');
        } catch (\Firebase\JWT\ExpiredException $e) { // token过期
            throw new ForbbidenException('token失效');
        } catch (\Exception $e) {
            throw new ForbbidenException('token错误');
        }
    }
}
