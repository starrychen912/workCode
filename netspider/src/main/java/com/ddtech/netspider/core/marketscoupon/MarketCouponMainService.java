package com.ddtech.netspider.core.marketscoupon;

import cn.hutool.http.HttpUtil;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.service.SpiderDBService;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;


@Service("MarketCouponMainService")
public class MarketCouponMainService extends SpiderService {


    Logger logger = LoggerFactory.getLogger(MarketCouponMainService.class);

    @Autowired
    private SpiderDBService spiderDBService;


    private static String domainName = "marketsCoupon";

    private int totalPage = 0;

    @Override
    @Async
    public void startTask(JobTask jobTask) {
        WebDriver driver=null;
        String url = "https://www.weeklyadpro.com/";
        try {
            saveTaskLog(jobTask, JobStatus.PROCESSING.name(),this.getClass()+" begin parser url:" + url);
//            driver=getChromeDriver();
//            driver.get(url);

            parserMain(driver, url);
            saveTaskLog(jobTask, JobStatus.COMPLETE.name(),this.getClass()+" parser url:" + url+" succeed.");
        } catch (Exception es) {
            saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" error:" + es.getMessage() + " url:" + url);
            logger.error("failed:",es);
            es.printStackTrace();
            logger.error(" error:" + es.getMessage() + " url:" + url);
        } finally {
            if(driver!=null) {
                driver.quit();
            }
        }

    }


//    @Override
//    @Async
//    public void startTask(JobTask jobTask) {
//        String url = "https://www.weeklyadpro.com/";
//        try {
//            saveTaskLog(jobTask, JobStatus.PROCESSING.name(),this.getClass()+" begin parser url:" + url);
//            String result1= HttpUtil.get(url);
//            Document doc=Jsoup.parse(result1);
//
//            parserMain(doc,url);
//            saveTaskLog(jobTask, JobStatus.COMPLETE.name(),this.getClass()+" parser url:" + url+" succeed.");
//        } catch (Exception es) {
//            saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" error:" + es.getMessage() + " url:" + url);
//            logger.error(" error:" + es.getMessage() + " url:" + url);
//        } finally {
//
//        }
//
//    }

//    public void parserMain(WebDriver driver, String url) throws Exception {
//        try {
////            String pageSource=driver.getPageSource();
////            System.out.println("pageSource:"+pageSource);
//            WebElement totalPageEle = driver.findElement(By.cssSelector("a.last"));
//            String totalPageStr = totalPageEle.getText();
//            setTotalPage(totalPageStr);
//
//            spiderDBService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), url);
//            for (int i = 1; i < this.totalPage + 1; i++) {
//                String tempListUrl = "https://www.weeklyadpro.com/page/" + i + "/";
//                spiderDBService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), tempListUrl);
//            }
//        } catch (Exception es) {
//            es.printStackTrace();
//            throw es;
//        }
//    }

    public void parserMain(WebDriver driver, String url) throws Exception {
        try {
//            String pageSource=driver.getPageSource();
//            System.out.println("pageSource:"+pageSource);
//            WebElement totalPageEle = driver.findElement(By.cssSelector("a.last"));
//            String totalPageStr = totalPageEle.getText();
//            setTotalPage(totalPageStr);

            spiderDBService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), url);
            for (int i = 1; i <120; i++) {
                String tempListUrl = "https://www.weeklyadpro.com/page/" + i + "/";
                spiderDBService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), tempListUrl);
            }
        } catch (Exception es) {
            es.printStackTrace();
            throw es;
        }
    }

    public void parserMain(Document doc,String url) throws Exception {
        try {

            Element totalPageEle = doc.selectFirst("a.last");
            String totalPageStr = getElementText(totalPageEle);
            setTotalPage(totalPageStr);

            spiderDBService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), url);
            this.totalPage=6;
            for (int i = 1; i < this.totalPage + 1; i++) {
                String tempListUrl = "https://www.weeklyadpro.com/page/" + i + "/";
                spiderDBService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), tempListUrl);
            }
        } catch (Exception es) {
            es.printStackTrace();
            throw es;
        }
    }

    private void setTotalPage(String totalPageStr) {
        totalPageStr = totalPageStr.replace(",", "");
        this.totalPage = Integer.parseInt(totalPageStr);

    }

    public int getTotalPage() {
        return this.totalPage;
    }
}
