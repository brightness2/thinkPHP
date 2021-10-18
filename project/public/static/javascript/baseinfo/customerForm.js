requestUrl = 'domain.customer/add';
updateRequestUrl = 'domain.customer/edit';
loadFormDataPM = (param) => {
    return new Promise((resolve, reject) => {
        layui.api.request('domain.baseInfo/get', { id: param.id, model: 'app\\model\\Customer' }, (res) => {
            if (res) {
                return resolve(res);
            }
        })
    })

};