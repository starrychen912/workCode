package com.ddtech.netspider.utils;


import cn.hutool.core.date.DateUtil;
import cn.hutool.core.util.StrUtil;


import java.beans.PropertyDescriptor;
import java.lang.reflect.Field;
import java.lang.reflect.Method;
import java.util.*;

public class CamelUnderlineUtil {

    /**
     * 主键字段名
     */
    public static final String PK ="pk";
    private static final char UNDERLINE ='_';
    /**
     * 驼峰命名转换成下划线方式名称，eg：cfConfigRecord > cf_config_record
     *
     * @param param
     * @return
     */
    public static String camelToUnderline(String param) {
        if (StrUtil.isEmpty(param)) {
            return "";
        }
        StringBuilder sb = new StringBuilder();
        int len = param.length();
        for (int i = 0; i < len; i++) {
            char c = param.charAt(i);
            if (Character.isUpperCase(c) && i>0) {
                sb.append(UNDERLINE);
                sb.append(Character.toLowerCase(c));
            } else {
                sb.append(c);
            }
        }
        return sb.toString();
    }

    /**
     * 下划线方式名称转换成驼峰命名，eg：cf_config_record > cfConfigRecord
     *
     * @param param
     * @return
     */
    public static String underlineToCamel(String param){
        if (StrUtil.isEmpty(param)) {
            return "";
        }
        StringBuilder sb = new StringBuilder();
        int len = param.length();
        for (int i = 0; i < len; i++) {
            char c = param.charAt(i);
            if (c==UNDERLINE) {
                if(++i<len){
                    sb.append(Character.toUpperCase(param.charAt(i)));
                }
            } else {
                sb.append(c);
            }
        }
        return sb.toString();
    }

    /**
     * Bean对象转Map方法<br/><br/>
     *
     * eg、{pk=ccr_id, ccr_id=1, operate_type=1, create_time=2020-08-24 13:44:09, remark=测试测试, sql=aaa}
     *
     * @param obj
     * @return
     * @throws Exception
     */
    public static Map<String,Object> convertObjectToMap(Object obj) throws Exception {
        Map<String,Object> fieldMap = new HashMap<>();
        Field[] fields = obj.getClass().getDeclaredFields();
        for (Field field : fields) {
            if ("serialVersionUID".equals(field.getName())) {
                continue;
            }
            if ("id".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("syncStatus".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("createDate".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("lastModifiedDate".equalsIgnoreCase(field.getName())) {
                continue;
            }


            String dstName = CamelUnderlineUtil.camelToUnderline(field.getName());


            PropertyDescriptor pd = new PropertyDescriptor(field.getName(),obj.getClass());
            Method method = pd.getReadMethod();
            Object dstObject = method.invoke(obj);
            if (dstObject instanceof Date) {
                dstObject = ((Date)dstObject).toString();
            }
            if (dstObject instanceof ArrayList) {
                dstObject = "";
            }
            fieldMap.put(dstName, dstObject == null ? "" : dstObject.toString());
        }
        return fieldMap;
    }


    public static List<String> getFieldList(Object obj) throws Exception {
        List<String> fieldList = new ArrayList<>();
        Field[] fields = obj.getClass().getDeclaredFields();
        for (Field field : fields) {
            if ("serialVersionUID".equals(field.getName())) {
                continue;
            }
            if ("id".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("syncStatus".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("createDate".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("lastModifiedDate".equalsIgnoreCase(field.getName())) {
                continue;
            }


            String dstName = CamelUnderlineUtil.camelToUnderline(field.getName());
            fieldList.add(dstName);

        }
        return fieldList;
    }

    public static List<String> getFieldValue(Object obj) throws Exception {
        List<String> fieldList = new ArrayList<>();
        Field[] fields = obj.getClass().getDeclaredFields();
        for (Field field : fields) {
            if ("serialVersionUID".equals(field.getName())) {
                continue;
            }
            if ("id".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("syncStatus".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("createDate".equalsIgnoreCase(field.getName())) {
                continue;
            }

            if ("lastModifiedDate".equalsIgnoreCase(field.getName())) {
                continue;
            }



            PropertyDescriptor pd = new PropertyDescriptor(field.getName(),obj.getClass());
            Method method = pd.getReadMethod();
            Object dstObject = method.invoke(obj);

            fieldList.add(dstObject.toString());

        }
        return fieldList;
    }

}
