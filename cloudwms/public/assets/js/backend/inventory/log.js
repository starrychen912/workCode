define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'inventory/log/index' + location.search,
                    add_url: 'inventory/log/add',
                    edit_url: 'inventory/log/edit',
                    del_url: 'inventory/log/del',
                    multi_url: 'inventory/log/multi',
                    import_url: 'inventory/log/import',
                    table: 'inventory_log',
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
                        {field: 'in_quantity', title: __('In_quantity')},
                        {field: 'memo', title: __('Memo'), operate: 'LIKE'},
                        {field: 'out_quantity', title: __('Out_quantity')},
                        {field: 'stock', title: __('Stock')},
                        {field: 'type', title: __('Type')},
                        {field: 'product_variant_id', title: __('Product_variant_id')},
                        {field: 'proof_img', title: __('Proof_img'), operate: 'LIKE'},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
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