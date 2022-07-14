package com.ddtech.netspider.vo;

import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.CronJob;
import lombok.Data;

@Data
public class JobLogSearchVO extends PageVO{

    private CronJob cronJob;
    private String jobStatus;
    private String resourcesType;


    private String startDate;
    private String endDate;


}
