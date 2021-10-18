tableConfig = {
    url: zconfig.createLink('domain.user/getList'),
    cols: [[
        { type: "checkbox", width: 50 },
        { field: 'id', width: 80, title: 'ID', sort: true },
        { field: 'name', title: '账号名称' },
        { field: 'real_name', title: '真实姓名' },
        { field: 'remark', title: '备注' },
        { title: '操作', minWidth: 150, toolbar: '#currentTableBar', align: "center" },
    ]],


};

addClickConfig = {
    title: '添加用户信息',
    page: zconfig.createPage('system/userForm'),
}

editClickConfig = {
    title: '编辑用户信息',
    page: zconfig.createPage('system/userForm'),
}

onDeleteMorePM = (table, data) => {
    let keys = [];
    data.forEach(row => {
        keys.push(row.id);
    });
    return new Promise((resolve, reject) => {
        layui.use(['api'], function () {
            let api = layui.api;
            api.request('domain.user/deleteMore', { keys: keys }, res => {
                if (res) {
                    resolve(res);
                }
            });
        })
    });

}

onDelete = (table, obj) => {

    layui.use(['api'], function () {
        let api = layui.api;
        api.request('domain.user/delete', { id: obj.data.id }, (res) => {
            if (res) {
                obj.del();
            }
        })
    })
}