/**
 * 主页
 */
layui.use(["jquery", "layer", "miniAdmin", "miniTongji", "api"], function () {
    var $ = layui.jquery,
        layer = layui.layer,
        miniAdmin = layui.miniAdmin,
        miniTongji = layui.miniTongji,
        api = layui.api;

    var options = {
        iniUrl: zconfig.createLink("domain.account/getMenu"), // 初始化接口
        clearUrl: "api/clear.json", // 缓存清理接口
        urlHashLocation: true, // 是否打开hash定位
        bgColorDefault: false, // 主题默认配置
        multiModule: true, // 是否开启多模块
        menuChildOpen: false, // 是否默认展开菜单
        loadingTime: 0, // 初始化加载时间
        pageAnim: true, // iframe窗口动画
        maxTabNum: 20, // 最大的tab打开数量
    };
    miniAdmin.render(options);

    // 百度统计代码，只统计指定域名
    // miniTongji.render({
    //     specific: true,
    //     domains: [
    //         '99php.cn',
    //         'layuimini.99php.cn',
    //         'layuimini-onepage.99php.cn',
    //     ],
    // });

    $(".login-out").on("click", function () {
        api.request("domain.account/logout");
        layer.msg("退出登录成功", function () {
            window.location = zconfig.createPage("login");
        });
    });
});
