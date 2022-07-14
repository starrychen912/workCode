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


@Service("WhatCouponMainService")
public class WhatCouponMainService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(WhatCouponMainService.class);

    @Autowired
    private SpiderDBService spiderService;

    private static String domainName="whatcoupon";



    @Async
    @Override
    public void startTask(JobTask jobTask) {
        String url="https://slickdeals.net/deal-categories/";
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


        Elements categoriesEl = doc.select("div.column");
        for(Element webElement:categoriesEl){

            Elements liEls=webElement.select("div li");

                for(Element element:liEls) {
                    Element atagName1=element.selectFirst("a");

                    String linkUrl=atagName1.attr("href");
                    if (linkUrl.indexOf("http") < 0) {
                        linkUrl = "https://slickdeals.net" + linkUrl;
                    }
                    spiderService.insertResources(ResourcesType.LIST.name(),domainName, LinkType.URL.name(),linkUrl,atagName1.text(),"");
                }



            }
        logger.info("Parser list url completed.");

    }







}
