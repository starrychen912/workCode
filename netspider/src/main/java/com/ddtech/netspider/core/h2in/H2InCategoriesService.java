package com.ddtech.netspider.core.h2in;


import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.h2in.H2inCate;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.repo.h2in.H2inCateRepo;
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


@Service("H2InCategoriesService")
public class H2InCategoriesService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(this.getClass());

    @Autowired
    private H2inCateRepo h2inCateRepo;

    @Autowired
    private SpiderDBService spiderDBService;

    private static String domainName = "whatcoupon";

    private int totalPage = 40;

    @Override
    @Async
    public void startTask(JobTask jobTask) {
        String url="https://am5.com/apps/";
        Document doc = null;
        Connection connection = null;
        try {
            saveTaskLog(jobTask, JobStatus.PROCESSING.name(),this.getClass()+" begin parser url:" + url);
            connection = Jsoup.connect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserApps(doc);
            saveTaskLog(jobTask, JobStatus.COMPLETE.name(),this.getClass()+" parser url:" + url+" succeed.");
        } catch (Exception es) {
            logger.error("  error:" + es.getMessage() + " url:" + url);
            saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" error:" + es.getMessage() + " url:" + url);
            logger.error("failed:",es);
            es.printStackTrace();

        } finally {

        }

        url="https://am5.com/games/";
        try {
            saveTaskLog(jobTask, JobStatus.PROCESSING.name(),this.getClass()+" begin parser url:" + url);
            connection = Jsoup.connect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserGames(doc);
            saveTaskLog(jobTask, JobStatus.COMPLETE.name(),this.getClass()+" parser url:" + url+" succeed.");
        } catch (Exception es) {
            logger.error("  error:" + es.getMessage() + " url:" + url);
            saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" error:" + es.getMessage() + " url:" + url);
            logger.error("failed:",es);
            es.printStackTrace();

        } finally {

        }


    }

    public void parserApps(Document doc) {
        String cateName="Apps";
        H2inCate h2inCate= h2inCateRepo.findFirstByName(cateName);
        if(h2inCate==null){
            h2inCate=new H2inCate();
            h2inCate.setIcon("");
            h2inCate.setName(cateName);
            h2inCate.setPid(0L);
            h2inCate=h2inCateRepo.save(h2inCate);
        }
        Elements categoriesEl = doc.select("div.right-categories-box a");
        for (Element webElement : categoriesEl) {
            String linkUrl="https://am5.com/"+getElementAttr(webElement,"href");
            String catName=getElementText(webElement);
            String icon=getElementAttr(webElement.selectFirst("img"),"src");
            h2inCate=new H2inCate();
            h2inCate.setIcon(icon);
            h2inCate.setName(cateName);
            h2inCate.setPid(h2inCate.getId());
            h2inCate=h2inCateRepo.save(h2inCate);
            spiderDBService.insertResources(ResourcesType.RESOURCES.name(), domainName,LinkType.IMG.name(), icon);
            spiderDBService.insertResources(ResourcesType.LIST.name(), domainName,LinkType.URL.name(), linkUrl,catName);

        }
        logger.info("Parser list url completed.");

    }

    public void parserGames(Document doc) {
        String cateName="Games";
        H2inCate h2inCate= h2inCateRepo.findFirstByName(cateName);
        if(h2inCate==null){
            h2inCate=new H2inCate();
            h2inCate.setIcon("");
            h2inCate.setName(cateName);
            h2inCate.setPid(0L);
            h2inCate=h2inCateRepo.save(h2inCate);
        }
        Elements categoriesEl = doc.select("div.right-categories-box a");
        for (Element webElement : categoriesEl) {
            String linkUrl="https://am5.com/"+getElementAttr(webElement,"href");
            String catName=getElementText(webElement);
            String icon=getElementAttr(webElement.selectFirst("img"),"src");
            h2inCate=new H2inCate();
            h2inCate.setIcon(icon);
            h2inCate.setName(cateName);
            h2inCate.setPid(h2inCate.getId());
            h2inCate=h2inCateRepo.save(h2inCate);
            spiderDBService.insertResources(ResourcesType.RESOURCES.name(), domainName,LinkType.IMG.name(), icon);
            spiderDBService.insertResources(ResourcesType.LIST.name(), domainName,LinkType.URL.name(), linkUrl,catName);

        }
        logger.info("Parser list url completed.");

    }



}
