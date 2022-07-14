package com.ddtech.netspider.core.whatcoupon;


import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCateRepo;
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



@Service("WhatCouponCategoriesService")
public class WhatCouponCategoriesService extends SpiderService {


    Logger logger = LoggerFactory.getLogger(WhatCouponCategoriesService.class);

    @Autowired
    private CpCateRepo cpCateRepo;

    @Autowired
    private SpiderDBService spiderDBService;

    private static String domainName = "whatcoupon";

    private int totalPage = 0;

    @Override
    @Async
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
            logger.error("  error:" + es.getMessage() + " url:" + url);
            saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" error:" + es.getMessage() + " url:" + url);
            logger.error("failed:",es);
            es.printStackTrace();

        } finally {

        }

    }

    public void parserMain(Document doc) {

        Elements categoriesEl = doc.select("div.column");
        for (Element webElement : categoriesEl) {
            Element liEls = webElement.selectFirst("div ul");
            saveCate(liEls.children(),0L);
        }
        logger.info("Parser list url completed.");

    }



    public void saveCate(Elements elements,Long pid){
       if(elements!=null){
           for(Element childEle:elements){
               CpCate categories=new CpCate();
               Element ptagName=childEle.selectFirst("a");
               categories.setName(getElementText(ptagName));
               categories.setPid(pid);
               categories.setTypeId(1L);
               System.out.println("begin save categories :"+categories.toString());
               categories= cpCateRepo.save(categories);
               System.out.println("save categories:"+categories.toString()+" success!");
               String linkUrl=getElementAttr(ptagName,"href");
               linkUrl="https://slickdeals.net"+linkUrl;
               spiderDBService.insertResources(ResourcesType.LIST.name(),domainName, LinkType.URL.name(),linkUrl, ptagName.text());
               Element child1El = childEle.selectFirst("ul");
               if(child1El!=null && child1El.children()!=null && child1El.children().size()>0){
                   saveCate(child1El.children(), categories.getId());
               }
           }

       }


    }


}
