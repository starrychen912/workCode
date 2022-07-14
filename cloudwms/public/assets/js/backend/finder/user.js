define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finder/user/index' + location.search,
                    add_url: 'finder/user/add',
                    edit_url: 'finder/user/edit',
                    del_url: 'finder/user/del',
                    multi_url: 'finder/user/multi',
                    import_url: 'finder/user/import',
                    table: 'finder_user',
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
                        {field: 'username', title: __('Username'), operate: 'LIKE'},
                        {field: 'email', title: __('Email'), operate: 'LIKE'},
                        {field: 'country', title: __('Country'), operate: 'LIKE'},
                        {field: 'phone', title: __('Phone'), operate: 'LIKE'},
                        {field: 'avatar', title: __('Avatar'), operate: 'LIKE', events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'loginip', title: __('Loginip'), operate: 'LIKE'},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), operate: 'LIKE', formatter: Table.api.formatter.status},
                        {field: 'shop', title: __('Shop'), operate: 'LIKE'},
                        {field: 'shopify_apiKey', title: __('Shopify_apikey'), operate: 'LIKE'},
                        {field: 'shopify_apiSecretKey', title: __('Shopify_apisecretkey'), operate: 'LIKE'},
                        {field: 'amazon_apiKey', title: __('Amazon_apikey'), operate: 'LIKE'},
                        {field: 'amazon_apiSecretKey', title: __('Amazon_apisecretkey'), operate: 'LIKE'},
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