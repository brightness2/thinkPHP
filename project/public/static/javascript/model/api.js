/**
  扩展一个 api 模块
**/

layui.use(["jquery", "layer"]).define(function (exports) {
    //提示：模块也可以依赖其它模块，如：layui.define('mod1', callback);
    let $ = layui.jquery,
        layer = layui.layer;
    var api = {
        baseUrl: "/public/admin.php/",
        request(
            url,
            data = {},
            successFn = null,
            failFn = null,
            type = "post"
        ) {
            $.ajax({
                type: type,
                url: api.baseUrl + url,
                data: data,
                success: function (res) {
                    if (res.errCode != 0) {
                        failFn && failFn(res);
                        layer.msg(res.msg, { icon: 2 });
                    } else {
                        successFn && successFn(res);
                        res.msg && layer.msg(res.msg, { icon: 1 });
                    }
                },
                error: function (res) {
                    layer.alert("服务出错，请联系管理员", { icon: 2 });
                },
            });
        },
    };

    //输出 api 接口
    exports("api", api);
});
