/**
 * 登录页
 */
layui.use(["form", "jquery", "api"], function () {
    var $ = layui.jquery,
        form = layui.form;
    api = layui.api;

    // 登录过期的时候，跳出ifram框架
    if (top.location != self.location) top.location = self.location;
    //密码显示
    $(".bind-password").on("click", function () {
        if ($(this).hasClass("icon-5")) {
            $(this).removeClass("icon-5");
            $("input[name='pass']").attr("type", "password");
        } else {
            $(this).addClass("icon-5");
            $("input[name='pass']").attr("type", "text");
        }
    });
    //勾选保持登录
    $(".icon-nocheck").on("click", function () {
        if ($(this).hasClass("icon-check")) {
            $(this).removeClass("icon-check");
        } else {
            $(this).addClass("icon-check");
        }
    });

    // 进行登录操作
    form.on("submit(login)", function (data) {
        data = data.field;

        api.request("domain.account/doLogin", data, (res) => {
            window.location = zconfig.createPage("home");
        });

        return false;
    });
});
