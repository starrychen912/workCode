package com.ddtech.netspider.core.whatcoupon;

import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.service.SpiderDBService;
import org.jsoup.Connection;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;


@Service("WhatCouponUpdateService")
public class WhatCouponUpdateService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(this.getClass());

    @Autowired
    private SpiderDBService spiderService;

    private static String domainName="whatcoupon";

    @Async
    @Override
    public void startTask(JobTask jobTask) {
        String url = "https://slickdeals.net/";
        Document doc = null;
        Connection connection = null;
        try {
            saveTaskLog(jobTask, JobStatus.PROCESSING.name(),this.getClass()+" begin parser url:" + url);
            connection = Jsoup.connect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserMain(doc);
            saveTaskLog(jobTask, JobStatus.COMPLETE.name(),this.getClass()+" parser url:" + url+" succeed.");
        } catch (Exception es) {
            saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" error:" + es.getMessage() + " url:" + url);
            logger.error("error:" + es.getMessage() + " url:" + url,es);
            es.printStackTrace();
        } finally {

        }

    }




    public void parserMain(Document doc) throws Exception{


        Elements categoriesEl = doc.select("ul.dealTiles.gridDeals li");
        for(Element webElement:categoriesEl){

            Element atagName1=webElement.selectFirst("a");

            String linkUrl=atagName1.attr("href");
            if (linkUrl.indexOf("http") < 0) {
                linkUrl = "https://slickdeals.net" + linkUrl;
            }

            spiderService.insertResources(ResourcesType.DETAIL.name(),domainName, LinkType.URL.name(),linkUrl,"Frontpage","");

        }
        logger.info("Parser list url completed.");

    }

}
