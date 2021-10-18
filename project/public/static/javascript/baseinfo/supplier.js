tableConfig = {
    url: zconfig.createLink('domain.supplier/getList'),
    cols: [[
        { type: "checkbox", width: 50 },
        { field: 'id', width: 80, title: 'ID', sort: true },
        { field: 'name', title: '供应商名称' },
        { field: 'address', title: '地址' },
        { field: 'contact', title: '联系人' },
        { field: 'phone', title: '联系电话' },
        { field: 'remark', title: '备注' },
        { title: '操作', minWidth: 150, toolbar: '#currentTableBar', align: "center" },
    ]],


};

addClickConfig = {
    title: '添加供应商信息',
    page: zconfig.createPage('baseinfo/supplierForm'),
}

editClickConfig = {
    title: '编辑供应商信息',
    page: zconfig.createPage('baseinfo/supplierForm'),
}

onDeleteMorePM = (table, data) => {
    let keys = [];
    data.forEach(row => {
        keys.push(row.id);
    });
    return new Promise((resolve, reject) => {
        layui.use(['api'], function () {
            let api = layui.api;
            api.request('domain.supplier/deleteMore', { keys: keys }, res => {
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
        api.request('domain.supplier/delete', { id: obj.data.id }, (res) => {
            if (res) {
                obj.del();
            }
        })
    })
}