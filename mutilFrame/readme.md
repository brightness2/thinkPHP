# 使用多应用模式
composer require topthink/think-multi-app
增加入口文件 admin.php、api.php

# 使用模板引擎
composer require topthink/think-view
ThinkTemplate开发指南 https://www.kancloud.cn/manual/think-template

# 异常处理，及数据返回处理
1、增加自定义异常类，app/api/lib/exception文件夹下定义；
2、app/common.php 文件增加success方法，返回json格式；
3、修改app/ExceptionHandel.php 文件的render方法，处理自定义异常类。

# 模型扩展
1、增加计数模型 app/api/lib/mode/Sequence.php;
2、增加扩展的model,app/api/lib/model/Zmodel.php;

# RBAC
1、创建数据表,SQL语句data/RBAC.sql
2、创建模型，
app/api/lib/model/rbac/User.php,
app/api/lib/model/rbac/Role.php,
app/api/lib/model/rbac/Permission.php,
app/api/lib/model/rbac/UserRole.php,
app/api/lib/model/rbac/RolePermission.php


# token 令牌
1、命令行执行 composer require firebase/php-jwt
2、安装的类在vendor/firebase/php-jwt/JWT.php
3、实现JWT使用类,app/api/lib/domain/JWT.php,包含签名方法,校验方法;达到刷新时间,重新生成token用于前端刷新token
4、token的校验一般用在路由中间件
4.1 app/api/config/middleware.php增加中间件别名
4.2 app/api/config/route.php文件增加，
    'middleware' => [
        'checkToken',
    ]