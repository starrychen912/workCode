package com.ddtech.netspider.utils;

import cn.hutool.core.util.StrUtil;

public class SqlUtils {

    public static String filterSqlString(String sqlStr) {
        if (StrUtil.isEmpty(sqlStr)) {
            return sqlStr;
        }
        sqlStr = sqlStr.replace("\'", "\\'");
        sqlStr = sqlStr.replaceAll("_", "/_");
        return sqlStr;
    }
}
