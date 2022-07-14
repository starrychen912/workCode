package com.ddtech.netspider.beans;


import lombok.Data;

import java.util.List;

@Data
public class PageData {
    private Long total;
    private List rows;
}
