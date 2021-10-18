requestUrl = 'domain.supplier/add';
updateRequestUrl = 'domain.supplier/edit';
loadFormDataPM = (param) => {
    return new Promise((resolve, reject) => {
        layui.api.request('domain.baseInfo/get', { id: param.id, model: 'app\\model\\Supplier' }, (res) => {
            if (res) {
                return resolve(res);
            }
        })
    })

};