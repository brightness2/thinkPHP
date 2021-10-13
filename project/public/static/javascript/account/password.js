layui.use(['form', 'miniTab','api'], function () {
    var form = layui.form,
        layer = layui.layer,
        miniTab = layui.miniTab,
        api = layui.api;
    
    //监听提交
    form.on('submit(saveBtn)', function (data) {
        api.request('domain.account/changePassword',data.field,(res)=>{
            if(res){
                layer.msg('系统3秒后退出...',{time:3000},()=>{
                    api.request("domain.account/logout");
                    top.location = zconfig.createPage("login");
                })
                
            }
        });
      
        return false;
    });

});