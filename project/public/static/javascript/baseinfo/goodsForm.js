requestUrl = 'domain.goods/addGoods';
updateRequestUrl = 'domain.goods/editGoods';
loadFormDataPM = (param) => {
    return new Promise((resolve, reject) => {
        layui.api.request('domain.baseInfo/get', { id: param.id, model: 'app\\model\\Goods' }, (res) => {
            if (res) {
                return resolve(res);
            }
        })
    })

};