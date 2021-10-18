requestUrl = 'domain.role/add';
updateRequestUrl = 'domain.role/edit';
loadFormDataPM = (param) => {
    return new Promise((resolve, reject) => {
        layui.api.request('domain.baseInfo/get', { id: param.id, model: 'app\\model\\Role' }, (res) => {
            if (res) {
                return resolve(res);
            }
        })
    })

};