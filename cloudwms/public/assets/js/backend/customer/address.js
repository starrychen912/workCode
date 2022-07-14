define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'customer/address/index' + location.search,
                    add_url: 'customer/address/add',
                    edit_url: 'customer/address/edit',
                    del_url: 'customer/address/del',
                    multi_url: 'customer/address/multi',
                    import_url: 'customer/address/import',
                    table: 'customer_address',
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
                        {field: 'zip', title: __('Zip')},
                        {field: 'city', title: __('City'), operate: 'LIKE'},
                        {field: 'phone', title: __('Phone'), operate: 'LIKE'},
                        {field: 'company', title: __('Company'), operate: 'LIKE'},
                        {field: 'country', title: __('Country'), operate: 'LIKE'},
                        {field: 'address1', title: __('Address1'), operate: 'LIKE'},
                        {field: 'address2', title: __('Address2'), operate: 'LIKE'},
                        {field: 'province', title: __('Province'), operate: 'LIKE'},
                        {field: 'last_name', title: __('Last_name'), operate: 'LIKE'},
                        {field: 'first_name', title: __('First_name'), operate: 'LIKE'},
                        {field: 'customer_id', title: __('Customer_id')},
                        {field: 'country_code', title: __('Country_code'), operate: 'LIKE'},
                        {field: 'country_name', title: __('Country_name'), operate: 'LIKE'},
                        {field: 'province_code', title: __('Province_code'), operate: 'LIKE'},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'delete_time', title: __('Delete_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'default', title: __('Default'), searchList: {"0":__('Default 0'),"1":__('Default 1')}, formatter: Table.api.formatter.normal},
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