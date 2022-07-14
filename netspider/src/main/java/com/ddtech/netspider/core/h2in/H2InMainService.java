package com.ddtech.netspider.core.h2in;

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


@Service("H2InMainService")
public class H2InMainService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(this.getClass());

    @Autowired
    private SpiderDBService spiderService;

    private static String domainName="H2IN";



    @Async
    @Override
    public void startTask(JobTask jobTask) {
        String url="https://am5.com/category/";
        Document doc = null;
        Connection connection = null;
        try {
            saveTaskLog(jobTask, JobStatus.PROCESSING.name(),this.getClass()+" begin parser url:" + url);
            logger.info("Begin parser url:" + url);
            parserMain(doc,url);
            saveTaskLog(jobTask, JobStatus.COMPLETE.name(),this.getClass()+" parser url:" + url+" succeed.");
        } catch (Exception es) {
            saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" error:" + es.getMessage() + " url:" + url);
            logger.error("error:" + es.getMessage() + " url:" + url,es);
            es.printStackTrace();

        } finally {

        }

    }



    public void parserMain(Document doc,String url) throws Exception{


        for (int i = 1; i <40; i++) {
            String tempListUrl =url + i ;
            spiderService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), tempListUrl);
        }

    }







}
