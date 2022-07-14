define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'customer/customer/index' + location.search,
                    add_url: 'customer/customer/add',
                    edit_url: 'customer/customer/edit',
                    del_url: 'customer/customer/del',
                    multi_url: 'customer/customer/multi',
                    import_url: 'customer/customer/import',
                    table: 'customer',
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
                        {field: 'email', title: __('Email'), operate: 'LIKE'},
                        {field: 'accepts_marketing', title: __('Accepts_marketing'), searchList: {"0":__('Accepts_marketing 0'),"1":__('Accepts_marketing 1')}, formatter: Table.api.formatter.normal},
                        {field: 'accepts_marketing_updated_at', title: __('Accepts_marketing_updated_at')},
                        {field: 'last_name', title: __('Last_name'), operate: 'LIKE'},
                        {field: 'first_name', title: __('First_name'), operate: 'LIKE'},
                        {field: 'state', title: __('State'), searchList: {"0":__('State 0'),"1":__('State 1'),"2":__('State 2'),"3":__('State 3')}, formatter: Table.api.formatter.normal},
                        {field: 'country', title: __('Country'), operate: 'LIKE'},
                        {field: 'currency', title: __('Currency'), operate: 'LIKE'},
                        {field: 'last_order_id', title: __('Last_order_id')},
                        {field: 'phone', title: __('Phone'), operate: 'LIKE'},
                        {field: 'tags', title: __('Tags'), operate: 'LIKE'},
                        {field: 'last_order_name', title: __('Last_order_name'), operate: 'LIKE'},
                        {field: 'marketing_opt_in_level', title: __('Marketing_opt_in_level'), searchList: {"0":__('Marketing_opt_in_level 0'),"1\r\n":__('Marketing_opt_in_level 1\r\n'),"2":__('Marketing_opt_in_level 2'),"3":__('Marketing_opt_in_level 3')}, formatter: Table.api.formatter.normal},
                        {field: 'note', title: __('Note'), operate: 'LIKE'},
                        {field: 'tax_exempt', title: __('Tax_exempt'), searchList: {"0":__('Tax_exempt 0'),"1":__('Tax_exempt 1')}, formatter: Table.api.formatter.normal},
                        {field: 'total_spent', title: __('Total_spent')},
                        {field: 'verified_email', title: __('Verified_email'), operate: 'LIKE'},
                        {field: 'orders_count', title: __('Orders_count')},
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