define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'product/variants/index' + location.search,
                    add_url: 'product/variants/add',
                    edit_url: 'product/variants/edit',
                    del_url: 'product/variants/del',
                    multi_url: 'product/variants/multi',
                    import_url: 'product/variants/import',
                    table: 'product_variants',
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
                        {field: 'product_id', title: __('Product_id')},
                        {field: 'sku', title: __('Sku'), operate: 'LIKE'},
                        {field: 'grams', title: __('Grams')},
                        {field: 'barcode', title: __('Barcode'), operate: 'LIKE'},
                        {field: 'compare_at_price', title: __('Compare_at_price'), operate:'BETWEEN'},
                        {field: 'fulfillment_service', title: __('Fulfillment_service'), operate: 'LIKE'},
                        {field: 'image_id', title: __('Image_id')},
                        {field: 'inventory_item_id', title: __('Inventory_item_id')},
                        {field: 'inventory_management', title: __('Inventory_management'), operate: 'LIKE'},
                        {field: 'inventory_policy', title: __('Inventory_policy')},
                        {field: 'inventory_quantity', title: __('Inventory_quantity')},
                        {field: 'option_id', title: __('Option_id')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'delete_time', title: __('Delete_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
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