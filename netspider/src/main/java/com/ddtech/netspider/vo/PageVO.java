package com.ddtech.netspider.vo;

import lombok.Data;

import java.io.Serializable;

/**
 * 分页Vo
 *
 * @author Funson
 * @date 2018-06-11
 */
@Data
public class PageVO implements Serializable {
    private static final long serialVersionUID = 1L;

    private String keyWord;

    private Integer pageNumber=1;

    private Integer pageSize=20;

    private String sort;

    private String order;
}
