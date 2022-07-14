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
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'product_id', title: __('Product_id')},
                        {field: 'app_id', title: __('App_id')},
                        {field: 'customer_id', title: __('Customer_id')},
                        {field: 'browser_ip', title: __('Browser_ip'), operate: 'LIKE'},
                        {field: 'buyer_accepts_marketing', title: __('Buyer_accepts_marketing'), searchList: {"0":__('Buyer_accepts_marketing 0'),"1":__('Buyer_accepts_marketing 1')}, formatter: Table.api.formatter.normal},
                        {field: 'cancel_reason', title: __('Cancel_reason'), operate: 'LIKE'},
                        {field: 'cancelled_at', title: __('Cancelled_at')},
                        {field: 'cart_token', title: __('Cart_token'), operate: 'LIKE'},
                        {field: 'checkout_token', title: __('Checkout_token'), operate: 'LIKE'},
                        {field: 'user_agent', title: __('User_agent'), operate: 'LIKE'},
                        {field: 'session_hash', title: __('Session_hash'), operate: 'LIKE'},
                        {field: 'browser_width', title: __('Browser_width'), operate:'BETWEEN'},
                        {field: 'browser_height', title: __('Browser_height'), operate:'BETWEEN'},
                        {field: 'accept_language', title: __('Accept_language'), operate: 'LIKE'},
                        {field: 'closed_at', title: __('Closed_at')},
                        {field: 'currency', title: __('Currency'), operate: 'LIKE'},
                        {field: 'current_total_discounts', title: __('Current_total_discounts'), operate:'BETWEEN'},
                        {field: 'current_total_discounts_set', title: __('Current_total_discounts_set'), operate: 'LIKE'},
                        {field: 'current_total_duties_set', title: __('Current_total_duties_set'), operate: 'LIKE'},
                        {field: 'current_total_price', title: __('Current_total_price'), operate:'BETWEEN'},
                        {field: 'current_total_price_set', title: __('Current_total_price_set'), operate: 'LIKE'},
                        {field: 'current_subtotal_price', title: __('Current_subtotal_price'), operate:'BETWEEN'},
                        {field: 'current_subtotal_price_set', title: __('Current_subtotal_price_set'), operate: 'LIKE'},
                        {field: 'current_total_tax', title: __('Current_total_tax'), operate:'BETWEEN'},
                        {field: 'current_total_tax_set', title: __('Current_total_tax_set'), operate: 'LIKE'},
                        {field: 'customer_locale', title: __('Customer_locale'), operate: 'LIKE'},
                        {field: 'email', title: __('Email'), operate: 'LIKE'},
                        {field: 'estimated_taxes', title: __('Estimated_taxes'), searchList: {"0":__('Estimated_taxes 0'),"1":__('Estimated_taxes 1')}, formatter: Table.api.formatter.normal},
                        {field: 'financial_status', title: __('Financial_status'), searchList: {"0":__('Financial_status 0'),"1":__('Financial_status 1'),"2":__('Financial_status 2'),"3":__('Financial_status 3'),"4":__('Financial_status 4'),"5":__('Financial_status 5'),"6":__('Financial_status 6')}, formatter: Table.api.formatter.status},
                        {field: 'name', title: __('Name'), operate: 'LIKE'},
                        {field: 'note', title: __('Note'), operate: 'LIKE'},
                        {field: 'number', title: __('Number')},
                        {field: 'order_number', title: __('Order_number')},
                        {field: 'tags', title: __('Tags'), operate: 'LIKE'},
                        {field: 'taxes_included', title: __('Taxes_included'), searchList: {"0":__('Taxes_included 0'),"1":__('Taxes_included 1')}, formatter: Table.api.formatter.normal},
                        {field: 'test', title: __('Test'), searchList: {"0":__('Test 0'),"1":__('Test 1')}, formatter: Table.api.formatter.normal},
                        {field: 'token', title: __('Token'), operate: 'LIKE'},
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