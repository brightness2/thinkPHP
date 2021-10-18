layui.use(['jquery', 'dtree', 'form', 'table', 'api'], function () {
    var $ = layui.jquery,
        dtree = layui.dtree,
        form = layui.form,
        api = layui.api,
        table = layui.table;

    /******分类*****/
    dtree.render({
        elem: "#cate-tree",
        width: '100%',
        checkbarType: "all",
        dataStyle: "layuiStyle",  //使用layui风格的数据格式
        dataFormat: "list",  //配置data的风格为list
        url: zconfig.createLink("domain.Goods/getCateList"),
        response: {
            statusName: "errCode", //返回标识（必填）
            statusCode: 0,
            message: "msg", //返回信息（必填）
            title: 'name',
            parentId: 'pid',
        }
    });
    dtree.on("node('cate-tree')", function (obj) {
        let node = obj.param;
        if (node.leaf == true) {
            search(table, { field: { goods_cate_id: node.nodeId } })
        }
    });
    /*****表格****/
    let tableConfig = {
        elem: '#currentTableId',
        url: zconfig.createLink('domain.Goods/getGoodsList'),
        toolbar: '#toolbarDemo',
        defaultToolbar: ['filter', 'exports', 'print'],
        cols: [[
            // { type: "checkbox", width: 50 },
            { field: 'id', width: 80, title: 'ID', sort: true },
            { field: 'code', title: '编号' },
            { field: 'name', title: '名称' },
            { field: 'model', title: '型号' },
            { field: 'cateName', title: '类别' },
            { field: 'unit', title: '单位' },
            { field: 'purchasing_price', title: '采购价' },
            { field: 'selling_price', title: '出售价' },
            { field: 'in_qty', title: '库存' },
            { field: 'min_num', width: 100, title: '库存下限' },
            // { field: 'producer', title: '产商' },
            { title: '操作', minWidth: 150, toolbar: '#currentTableBar', align: "center" },
        ]],
        limits: [10, 15, 20, 25, 50, 100],
        limit: 15,
        page: true,
        skin: 'line',
        parseData: function (res) { //res 即为原始返回的数据
            return {
                "code": res.errCode, //解析接口状态
                "msg": res.msg, //解析提示文本
                "count": res.data.total, //解析数据长度
                "data": res.data.list //解析数据列表
            };
        }
    }
    table.render(tableConfig);//渲染表格
    //表格重载
    function tableReload() {
        table.reload('currentTableId', {
            page: {
                curr: 1
            }
        }, 'data');
    }
    // 执行搜索重载
    function search(table, data) {
        table.reload('currentTableId', {
            page: {
                curr: 1
            }
            , where: data.field

        }, 'data');
    }
    // 监听搜索操作
    form.on('submit(data-search-btn)', function (data) {
        search(table, data);
        return false;
    });

    //toolbar监听事件

    table.on('toolbar(currentTableFilter)', function (obj) {
        if (obj.event === 'add') {
            var index = layer.open({
                title: "新增商品信息",//
                type: 2,
                shade: 0.2,
                maxmin: true,
                shadeClose: false,
                area: ['100%', '100%'],
                content: zconfig.createPage('baseinfo/goodsForm'),
                end: () => {
                    tableReload();
                }
            });
        } else if (obj.event === 'delete') {
            let checkStatus = table.checkStatus('currentTableId')
                , data = checkStatus.data;
            if (data.length <= 0) {
                layer.msg('请勾选数据', { icon: 5 });
                return;
            }
            let keys = [];
            data.forEach(row => {
                keys.push(row.id);
            });
            layer.confirm('真的删除条 <strong>' + data.length + '</strong> 数据么', { icon: 3 }, function (index) {
                //删除按钮回调
                api.request('domain.goods/deleteGoodsMore', { keys }, res => {
                    tableReload();
                })

                layer.close(index);
            });
        }
    });

    //监听表格复选框选择
    // table.on('checkbox(currentTableFilter)', function (obj) {
    // });

    //监听行操作
    table.on('tool(currentTableFilter)', function (obj) {
        if (obj.event === 'edit') {
            var index = layer.open({
                title: "编辑商品信息",//
                type: 2,
                shade: 0.2,
                maxmin: true,
                shadeClose: false,
                area: ['100%', '100%'],
                content: zconfig.createPage('baseinfo/goodsForm'),
                success: (layero, index) => {
                    var body = layer.getChildFrame('body', index);
                    var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象
                    iframeWin.LoadData && iframeWin.LoadData(obj.data);//调用iframe页的窗口对象中的方法
                },
                end: () => {
                    tableReload();
                }
            });
        } else if (obj.event === 'delete') {
            layer.confirm('真的删除行么', { icon: 3 }, function (index) {
                api.request('domain.goods/deleteGoods', { id: obj.data.id }, res => {
                    obj.del();
                })
                layer.close(index);
            });

        }
    });

})