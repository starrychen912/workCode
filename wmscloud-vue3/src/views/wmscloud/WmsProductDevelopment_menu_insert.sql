-- 注意：该页面对应的前台目录为views/wmscloud文件夹下
-- 如果你想更改到其他目录，请修改sql中component字段对应的值

INSERT INTO sys_permission(id, parent_id, name, url, component, component_name, redirect, menu_type, perms, perms_type, sort_no, always_show, icon, is_route, is_leaf, keep_alive, hidden, hide_tab, description, status, del_flag, rule_flag, create_by, create_time, update_by, update_time, internal_or_external) 
VALUES ('202206300248694056', NULL, '产品研发', '/wmscloud/wmsProductDevelopmentList', 'wmscloud/WmsProductDevelopmentList', NULL, NULL, 0, NULL, '1', 1.00, 0, NULL, 1, 1, 0, 0, 0, NULL, '1', 0, 0, 'admin', '2022-06-30 14:48:56', NULL, NULL, 0);