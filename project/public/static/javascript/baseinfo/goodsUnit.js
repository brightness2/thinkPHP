tableConfig = {
    url: zconfig.createLink('domain.goods/getUnitList'),
    cols: [[
        { field: 'id', width: 80, title: 'ID', sort: true },
        { field: 'name', title: '单位名称' },
        { title: '操作', minWidth: 150, toolbar: '#currentTableBar', align: "center" },
    ]],


};

addClickConfig = {
    title: '添加商品单位',
    page: zconfig.createPage('baseinfo/goodsUnitForm'),
    area: ['50%', '50%'],
}
editClickConfig = {
    title: '编辑商品单位',
    page: zconfig.createPage('baseinfo/goodsUnitForm'),
    area: ['50%', '50%'],

}

onDelete = (table, obj) => {

    layui.use(['api'], function () {
        let api = layui.api;
        api.request('domain.goods/deleteUnit', { id: obj.data.id }, (res) => {
            if (res) {
                obj.del();
            }
        })
    })
}