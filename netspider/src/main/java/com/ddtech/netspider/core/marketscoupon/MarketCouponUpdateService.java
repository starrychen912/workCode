package com.ddtech.netspider.core.marketscoupon;

import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.service.SpiderDBService;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;


@Service("MarketCouponUpdateService")
public class MarketCouponUpdateService extends SpiderService {


    Logger logger = LoggerFactory.getLogger(this.getClass());

    @Autowired
    private SpiderDBService spiderDBService;


    private static String domainName = "marketsCoupon";


    @Async
    @Override
    public void startTask(JobTask jobTask) {
        String tempListUrl="";
        try {

            for (int i = 1; i < 4; i++) {
                tempListUrl = "https://www.weeklyadpro.com/page/" + i + "/";
                saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass() + " begin update resource url:"+tempListUrl);
                LinkResource linkResource=spiderDBService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), tempListUrl);
                saveTaskLog(jobTask, JobStatus.COMPLETE.name(), this.getClass() + " update resource succeed.",linkResource);
            }

        } catch (Exception es) {
            saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass() + " failed:" + es.getMessage()+" url:"+tempListUrl);
            logger.error("failed:",es);
            es.printStackTrace();

        }

    }


}
