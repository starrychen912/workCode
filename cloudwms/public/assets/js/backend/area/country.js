define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'area/country/index' + location.search,
                    add_url: 'area/country/add',
                    edit_url: 'area/country/edit',
                    del_url: 'area/country/del',
                    multi_url: 'area/country/multi',
                    import_url: 'area/country/import',
                    table: 'country',
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
                        {field: 'continent_id', title: __('Continent_id')},
                        {field: 'namecn', title: __('Namecn'), operate: 'LIKE'},
                        {field: 'nameeng', title: __('Nameeng'), operate: 'LIKE'},
                        {field: 'nameengsp', title: __('Nameengsp'), operate: 'LIKE'},
                        {field: 'brief', title: __('Brief'), operate: 'LIKE'},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'yzid', title: __('Yzid')},
                        {field: 'deliverys', title: __('Deliverys'), operate: 'LIKE'},
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