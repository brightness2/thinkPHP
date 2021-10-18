
function LoadData(row) {

    layui.use(['jquery', 'dtree', 'api'], function () {
        let $ = layui.jquery;
        let dtree = layui.dtree;
        let api = layui.api;
        let authTree = dtree.render({
            elem: "#auth-tree",
            checkbar: true,
            checkbarType: "all",
            dataStyle: "layuiStyle",  //使用layui风格的数据格式
            dataFormat: "list",  //配置data的风格为list
            url: zconfig.createLink("domain.System/getAllMenu"),
            response: {
                statusName: "errCode", //返回标识（必填）
                statusCode: 0,
                message: "msg", //返回信息（必填）
                parentId: 'pid',
            },
            done: function (res, ul, first) {
                if (first) {
                    // console.log(authTree);
                    api.request("domain.Role/getAuthByRole", { id: row.id }, (res) => {
                        dtree.chooseDataInit('auth-tree', res.data); // 初始化选
                    })
                }
            }

        });


        //按钮点击
        $('#save-auth').click(function (e) {
            let params = dtree.getCheckbarNodesParam("auth-tree");
            let keys = [];
            for (const key in params) {
                if (Object.hasOwnProperty.call(params, key)) {
                    keys.push(params[key].nodeId);
                }
            }
            api.request("domain.Role/setAuth", { id: row.id, choose: keys }, (res) => {
                if (res) {
                    var iframeIndex = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(iframeIndex);

                }

            })
        });
    })
}