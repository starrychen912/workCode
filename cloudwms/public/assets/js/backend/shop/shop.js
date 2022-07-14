define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'shop/shop/index' + location.search,
                    add_url: 'shop/shop/add',
                    edit_url: 'shop/shop/edit',
                    del_url: 'shop/shop/del',
                    multi_url: 'shop/shop/multi',
                    import_url: 'shop/shop/import',
                    table: 'shop',
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
                        {field: 'address1', title: __('Address1'), operate: 'LIKE'},
                        {field: 'address2', title: __('Address2'), operate: 'LIKE'},
                        {field: 'email', title: __('Email'), operate: 'LIKE'},
                        {field: 'domain', title: __('Domain'), operate: 'LIKE'},
                        {field: 'myshopify_domain', title: __('Myshopify_domain'), operate: 'LIKE'},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'phone', title: __('Phone'), operate: 'LIKE'},
                        {field: 'type', title: __('Type'), operate: 'LIKE'},
                        {field: 'finder_user_id', title: __('Finder_user_id')},
                        {field: 'apiKey', title: __('Apikey'), operate: 'LIKE'},
                        {field: 'apiSecretKey', title: __('Apisecretkey'), operate: 'LIKE'},
                        {field: 'access_token', title: __('Access_token'), operate: 'LIKE'},
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