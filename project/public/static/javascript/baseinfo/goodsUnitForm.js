requestUrl = 'domain.goods/addUnit';
updateRequestUrl = 'domain.goods/editUnit';
loadFormDataPM = (param) => {
    return new Promise((resolve, reject) => {
        layui.api.request('domain.baseInfo/get', { id: param.id, model: 'app\\model\\GoodsUnit' }, (res) => {
            if (res) {
                return resolve(res);
            }
        })
    })

};