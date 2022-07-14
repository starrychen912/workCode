define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'product/product_import/index' + location.search,
                    add_url: 'product/product_import/add',
                    edit_url: 'product/product_import/edit',
                    del_url: 'product/product_import/del',
                    multi_url: 'product/product_import/multi',
                    import_url: 'product/product_import/import',
                    table: 'product_import',
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
                        {field: 'sku', title: __('Sku'), operate: 'LIKE'},
                        {field: 'product_id', title: __('Product_id')},
                        {field: 'finder_user_id', title: __('Finder_user_id')},
                        {field: 'description', title: __('Description'), operate: 'LIKE'},
                        {field: 'image_ids', title: __('Image_ids'), operate: 'LIKE'},
                        {field: 'status', title: __('Status')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'delete_time', title: __('Delete_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'is_inport', title: __('Is_inport'), searchList: {"0":__('Is_inport 0'),"1":__('Is_inport 1')}, formatter: Table.api.formatter.normal},
                        {field: 'body_html', title: __('Body_html'), operate: 'LIKE'},
                        {field: 'handle', title: __('Handle'), operate: 'LIKE'},
                        {field: 'product_type', title: __('Product_type'), operate: 'LIKE'},
                        {field: 'published_at', title: __('Published_at')},
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {field: 'supplier_id', title: __('Supplier_id')},
                        {field: 'category_id', title: __('Category_id')},
                        {field: 'brand_id', title: __('Brand_id')},
                        {field: 'shop_id', title: __('Shop_id')},
                        {field: 'product_data', title: __('Product_data'), operate: 'LIKE'},
                        {field: 'out_link', title: __('Out_link'), operate: 'LIKE'},
                        {field: 'shopify_product_id', title: __('Shopify_product_id')},
                        {field: 'tag_ids', title: __('Tag_ids'), operate: 'LIKE'},
                        {field: 'country_id', title: __('Country_id')},
                        {field: 'HScode', title: __('Hscode'), operate: 'LIKE'},
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