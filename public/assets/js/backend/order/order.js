define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/order/index' + location.search,
                    add_url: 'order/order/add',
                    edit_url: 'order/order/edit',
                    del_url: 'order/order/del',
                    multi_url: 'order/order/multi',
                    import_url: 'order/order/import',
                    table: 'order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                /* showToggle: false,
                showColumns: false,
                commonSearch: false,
                searchFormVisible: true,
                showExport: false, */
                search:false,
                columns: [
                    [
                        {checkbox: true, operate: false},
                        {field: 'id', title: __('Id')},
                        {field: 'order_id', title: __('Order_id'), operate: 'LIKE'},
                        // {field: 'user_id', title: __('User_id')},
                        {field: 'user_name', title: __('User_name'), operate: 'LIKE'},
                        {field: 'user_tel', title: __('User_tel'), operate: 'LIKE'},
                        {field: 'user_address', title: __('User_address'), operate: 'LIKE'},
                        // {field: 'goods_josn', title: __('Goods_josn')},
                        // {field: 'goods_images', title: __('Goods_images'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.images},
                        // {field: 'the_door_time', title: __('The_door_time'), operate: 'LIKE'},
                        // {field: 'total_amount', title: __('Total_amount'), operate:'BETWEEN'},
                        {
                            field: 'status',
                            title: __('Status'),
                            table: table,
                            // custom: {"0": 'success', "1": 'danger'},
                            searchList: {"0": __('Status 0'), "1": __('Status 1'), "2": __('Status 2'), "3": __('Status 3')},
                            formatter: Table.api.formatter.status
                        },
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'accepttime', title: __('Accepttime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'canceltime', title: __('Canceltime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'completetime', title: __('Completetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        // {field: 'administrator_id', title: __('Administrator_id')},
                        {field: 'administrator_name', title: __('Administrator_name'), operate: 'LIKE'},
                        {field: 'administrator_tel', title: __('Administrator_tel'), operate: false},
                        // {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                        {
                            field: 'operate',
                            width: "150px",
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                              
                                {
                                    name: 'detail',
                                    text:  '详情',
                                    title: '详情',
                                    // classname: 'btn btn-xs btn-primary btn-dialog',
                                    classname:'btn btn-primary btn-success btn-dialog',
                                    icon: 'fa fa-camera',
                                    url: 'order/order/detail',
                                    callback: function (data) {
                                        Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
                                    }
                                },
                                
                            ],
                            formatter: Table.api.formatter.operate
                        },
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});