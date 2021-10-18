layui.use(['table', 'treetable', 'api'], function () {
    var $ = layui.jquery;
    var table = layui.table;
    var treetable = layui.treetable;
    let api = layui.api;
    //表格重载
    function tableReload() {
        location.reload();
    }
    // 渲染表格
    layer.load(2);
    treetable.render({
        elem: '#munu-table',
        url: zconfig.createLink("domain.System/getAllMenu"),

        treeColIndex: 1,
        treeSpid: 0,
        treeIdName: 'id',
        treePidName: 'pid',
        page: false,
        cols: [[
            { type: 'numbers' },
            { field: 'title', minWidth: 200, title: '权限名称' },
            { field: 'acl_value', width: 80, title: '权限标识' },
            { field: 'href', title: '访问操作' },
            // { field: 'orderNumber', width: 80, align: 'center', title: '排序号' },
            {
                field: 'type', width: 80, align: 'center', templet: function (d) {
                    if (d.type == -1) {
                        return '<span class="layui-badge layui-bg-blue">根目录</span>';
                    } else if (d.type == 0) {
                        return '<span class="layui-badge layui-bg-blue">目录</span>';
                    } else if (d.type == 1) {
                        return '<span class="layui-badge-rim">菜单</span>';
                    } else {
                        return '<span class="layui-badge layui-bg-gray">按钮</span>';
                    }
                }, title: '类型'
            },
            { templet: '#auth-state', width: 200, align: 'center', title: '操作' }
        ]],
        done: function () {
            layer.closeAll('loading');
        }
    });

    $('#btn-expand').click(function () {
        treetable.expandAll('#munu-table');
    });

    $('#btn-fold').click(function () {
        treetable.foldAll('#munu-table');
    });

    //监听工具条
    table.on('tool(munu-table)', function (obj) {
        var data = obj.data;
        var layEvent = obj.event;

        if (layEvent === 'del') {
            layer.confirm('真的删除行么', { icon: 3 }, function (index) {
                api.request("domain.Menu/delete", { id: data.id }, res => {
                    if (res) {
                        tableReload();
                    }
                })
                layer.close(index);
            });
        } else if (layEvent === 'edit') {
            let index = layer.open({
                title: "修改菜单",//
                type: 2,
                shade: 0.2,
                maxmin: true,
                shadeClose: false,
                area: ['60%', '70%'],
                content: zconfig.createPage('system/menuForm'),
                success: (layero, index) => {
                    var body = layer.getChildFrame('body', index);
                    var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象
                    iframeWin.LoadData && iframeWin.LoadData(obj);//调用iframe页的窗口对象中的方法
                },
                end: () => {
                    tableReload();
                }
            });
        } else if (layEvent === 'add') {
            let index = layer.open({
                title: "添加子项",//
                type: 2,
                shade: 0.2,
                maxmin: true,
                shadeClose: false,
                area: ['60%', '70%'],
                content: zconfig.createPage('system/menuForm'),
                success: (layero, index) => {
                    var body = layer.getChildFrame('body', index);
                    var iframeWin = window[layero.find('iframe')[0]['name']]; //得到iframe页的窗口对象
                    iframeWin.LoadData && iframeWin.LoadData(obj);//调用iframe页的窗口对象中的方法
                },
                end: () => {
                    tableReload();
                }
            });
        }
    });
});