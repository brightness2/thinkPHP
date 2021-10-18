requestUrl = 'domain.user/add';
updateRequestUrl = 'domain.user/edit';
layui.use(['xmSelect', 'api'], function () {
    let xmSelect = layui.xmSelect,
        api = layui.api;
    let rolesSelect = xmSelect.render({
        el: '#roles',
        name: 'roles',
        prop: {
            name: 'name',
            value: 'id',
        },
        data: [],
        initValue: [],//默认选中
    });

    api.request('domain.role/getList', {}, function (res) {
        if (res.data.list) {
            rolesSelect.update({ data: res.data.list });
        }
    });
})
loadFormDataPM = (param) => {
    return new Promise((resolve, reject) => {
        rolesSelect = layui.xmSelect.get('#roles');
        layui.api.request('domain.user/get', { id: param.id }, (res) => {
            if (res) {

                rolesSelect[0].setValue(res.data.roles);
                return resolve(res);
            }
        })
    })

};
