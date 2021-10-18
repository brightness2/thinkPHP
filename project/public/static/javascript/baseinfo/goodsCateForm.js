requestUrl = 'domain.goods/addCate';
updateRequestUrl = 'domain.goods/editCate';
loadFormDataPM = (param) => {
    return new Promise((resolve, reject) => {
        layui.api.request('domain.baseInfo/get', { id: param.data.id, model: 'app\\model\\GoodsCate' }, (res) => {
            if (res) {
                return resolve(res);
            }
        })
    })

};