define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'user/user_apply/index' + location.search,
                    add_url: 'user/user_apply/add',
                    edit_url: 'user/user_apply/edit',
                    del_url: 'user/user_apply/del',
                    multi_url: 'user/user_apply/multi',
                    import_url: 'user/user_apply/import',
                    table: 'user_apply',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'the_name', title: __('The_name'), operate: 'LIKE'},
                        {field: 'gender', title: __('Gender')},
                        {field: 'mobile', title: __('Mobile'), operate: 'LIKE'},
                        {field: 'home_address', title: __('Home_address'), operate: 'LIKE'},
                        {field: 'management_area', title: __('Management_area'), operate: 'LIKE'},
                        {field: 'lng', title: __('Lng'), operate: 'LIKE'},
                        {field: 'lat', title: __('Lat'), operate: 'LIKE'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'state', title: __('State'), searchList: {"0":__('State 0'),"1":__('State 1'),"2":__('State 2')}, formatter: Table.api.formatter.normal},
                        {field: 'user.id', title: __('User.id')},
                        {field: 'user.nickname', title: __('User.nickname'), operate: 'LIKE'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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