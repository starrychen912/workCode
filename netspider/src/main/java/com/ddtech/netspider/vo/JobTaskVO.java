package com.ddtech.netspider.vo;

import com.ddtech.netspider.jpa.entity.spider.CronJob;
import lombok.Data;
import org.springframework.data.domain.Pageable;

import java.util.Date;


@Data
public class JobTaskVO extends PageVO {

    private CronJob cronJob;
    private String startDate;
    private String endDate;

}
