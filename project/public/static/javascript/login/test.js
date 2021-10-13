layui.use(["form", "api"], function () {
    let form = layui.form,
        api = layui.api;

    //监听提交
    form.on("submit(loginSubmit)", function (data) {
        api.request("domain.account/doLogin", data.field, () => {
            location.href = zconfig.baseUrl + "main/home";
        });

        return false;
    });
});
