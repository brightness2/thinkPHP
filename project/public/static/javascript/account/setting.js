layui.use(['form', 'miniTab','api'], function () {
    var form = layui.form,
        // miniTab = layui.miniTab,
        api = layui.api;

    //监听提交
    form.on('submit(saveBtn)', function (data) {
        
        api.request('domain.account/updateInfo',data.field,(res)=>{
            if(res  && res.errCode == 0){
                // miniTab.deleteCurrentByIframe();
                top.location.reload()
            }
        })
        return false;
    });

});