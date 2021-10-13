layui.define(["jquery", "layer"], function (exports) {
    let $ = layui.jquery,
        layer = layui.layer;
    let api = {
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
                    if(!res || res.errCode == undefined){
                        layer.msg(
                            '接口出错',
                            { icon: 2, time: 1500 },
                            function () {
                                failFn && failFn(res);
                            }
                        );
                        
                    }
                    if (res.errCode != 0) {
                        layer.msg(
                            res.msg,
                            { icon: 2, time: 1500 },
                            function () {
                                failFn && failFn(res);
                            }
                        );

                    } else {
                        res.msg?
                            layer.msg(
                                res.msg,
                                { icon: 1, time: 1500 },
                                function () {
                                    successFn && successFn(res);
                                }
                            ):successFn && successFn(res);
                    }
                },
                error: function (res) {
                    layer.alert("服务出错，请联系管理员", { icon: 2 });
                },
            });
        },
    };
    //暴露接口
    exports("api", api);
});
