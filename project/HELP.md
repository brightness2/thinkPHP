# 异常处理，及数据返回处理
1、增加自定义异常类，app/lib/exception文件夹下定义；
2、app/common.php 文件增加success方法，返回json格式；
3、修改app/ExceptionHandel.php 文件的render方法，处理自定义异常类。

# 模型扩展
1、增加计数模型 app/lib/mode/Sequence.php;
2、增加扩展的model,app/lib/model/Zmodel.php;

# token 令牌
1、命令行执行 composer require firebase/php-jwt
2、安装的类在vendor/firebase/php-jwt/JWT.php
3、实现JWT使用类,app/lib/domain/JWT.php,包含签名方法,校验方法;达到刷新时间,重新生成token用于前端刷新token
4、token的校验一般用在路由中间件
4.1 config/middleware.php增加中间件别名
4.2 config/route.php文件增加，
    'middleware' => [
        'checkToken',
    ]

# cookie + token 后台身份验证
1 app/admin/config/middleware.php增加中间件别名
2 app/admin/config/route.php文件增加，
    'middleware' => [
        'checkCookie',
    ]