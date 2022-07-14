package com.ddtech.netspider.vo;

import com.ddtech.netspider.jpa.entity.spider.CronJob;
import lombok.Data;


@Data
public class LinkResVO extends PageVO {

    private String startDate;
    private String endDate;

}
