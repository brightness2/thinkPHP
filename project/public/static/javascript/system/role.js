
tableConfig = {
    url: zconfig.createLink('domain.role/getList'),
    cols: [[
        // { type: "checkbox", width: 50 },
        { field: 'id', width: 80, title: 'ID', sort: true },
        { field: 'name', title: '角色名称' },
        { field: 'remark', title: '备注' },
        { title: '操作', minWidth: 150, toolbar: '#currentTableBar', align: "center" },
    ]],
};

addClickConfig = {
    title: '添加角色信息',
    page: zconfig.createPage('system/roleForm'),
}

editClickConfig = {
    title: '编辑角色信息',
    page: zconfig.createPage('system/roleForm'),
}

// onDeleteMorePM = (table, data) => {
//     let keys = [];
//     data.forEach(row => {
//         keys.push(row.id);
//     });
//     return new Promise((resolve, reject) => {
//         layui.use(['api'], function () {
//             let api = layui.api;
//             api.request('domain.baseInfo/removeMore', { keys: keys, model: 'app\\model\\Role' }, res => {
//                 if (res) {
//                     resolve(res);
//                 }
//             });
//         })
//     });

// }

onDelete = (table, obj) => {

    layui.use(['api'], function () {
        let api = layui.api;
        api.request('domain.role/delete', { id: obj.data.id }, (res) => {
            if (res) {
                obj.del();
            }
        })
    })
}

//行操作
onOtherCurrentTableBar = (table, obj) => {
    if (obj.event == "auth") {
        let roleId = obj.data.id
        let index = layer.open({
            title: "角色授权",//
            type: 2,
            shade: 0.2,
            maxmin: true,
            shadeClose: false,
            area: ['60%', '70%'],
            content: zconfig.createPage('system/auth'),
            success: (layero, index) => {
                var body = layer.getChildFrame('body', index);
                var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象
                iframeWin.LoadData && iframeWin.LoadData(obj.data);//调用iframe页的窗口对象中的方法
            },
        });

    }
}