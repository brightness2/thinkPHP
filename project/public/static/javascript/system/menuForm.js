requestUrl = 'domain.Menu/add';
updateRequestUrl = 'domain.Menu/edit';
loadFormDataPM = (param) => {
    return new Promise((resolve, reject) => {
        if (param.event === "add") {
            return resolve({
                data: { pid: param.data.id }
            });
        } else if (param.event === "edit") {
            layui.api.request('domain.baseInfo/get', { id: param.data.id, model: 'app\\model\\Menu' }, (res) => {
                if (res) {
                    return resolve(res);
                }
            })
        }

    })

};