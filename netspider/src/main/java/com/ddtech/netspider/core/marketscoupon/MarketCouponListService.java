package com.ddtech.netspider.core.marketscoupon;


import cn.hutool.core.io.FileUtil;
import cn.hutool.http.HttpUtil;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.marketscoupon.McWeekAds;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.repo.marketscoupon.McStoreRepo;
import com.ddtech.netspider.jpa.repo.marketscoupon.McWeekAdsRepo;
import com.ddtech.netspider.service.SpiderDBService;
import org.openqa.selenium.*;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import java.io.File;
import java.nio.file.StandardCopyOption;
import java.util.List;

@Service("MarketCouponListService")
public class MarketCouponListService extends SpiderService {


    Logger logger = LoggerFactory.getLogger(MarketCouponListService.class);

    @Autowired
    private SpiderDBService spiderDBService;

    @Autowired
    private McWeekAdsRepo mcWeekAdsRepo;

    @Autowired
    private McStoreRepo mcStoreRepo;

    private static String domainName = "marketsCoupon";

    private static String baseDir = "/marketscoupon";

    private static String domainUrl="https://www.weeklyadpro.com";

    @Value("${resource.download.root}")
    private String downloadRoot;

    @Override
    @Async
    public void startTask(JobTask jobTask) {
        List<LinkResource> linkResourceList = spiderDBService.findTop5Res(domainName, ResourcesType.LIST.name());
        for (LinkResource linkResource : linkResourceList) {
            if (linkResource != null) {
                saveResStatus(linkResource,JobStatus.PROCESSING.name());
                try {
                    saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass()+" begin parser",linkResource);
                    parserInit(linkResource,jobTask);
                    saveResStatus(linkResource,JobStatus.COMPLETE.name());
                    saveTaskLog(jobTask, JobStatus.COMPLETE.name(), this.getClass()+" parser succeed.",linkResource);

                } catch (Exception es) {
                    saveResStatus(linkResource,JobStatus.FAILED.name());
                    saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass()+" failed:" + es.getMessage(),linkResource);
                    logger.error("failed:",es);
                    es.printStackTrace();
                    continue;
                }
            } else {
                saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" parser Get link resource for list failed:"+ linkResource);
                logger.warn("parser Get link resource for list failed...");
                continue;
            }

        }
    }


    public void parserInit(LinkResource linkResource, JobTask jobTask) throws Exception {
        String url = linkResource.getLinkUrl();
        WebDriver driver=null;
        try {
            logger.info("Begin parser url:" + url);
            driver=getChromeDriver();
            driver.manage().window().setSize(new Dimension(15360,3600));
            driver.get(url);
            parserMain(driver, linkResource,jobTask);
        } catch (Exception es) {
            logger.error("parserCateList error:" + es.getMessage() + " url:" + url);
            es.printStackTrace();
            throw es;
        } finally {
            if(driver!=null) {
                driver.quit();
            }
        }

    }

    public void parserMain(WebDriver driver, LinkResource linkResource,JobTask jobTask) throws Exception{

        List<WebElement> elements = driver.findElements(By.cssSelector("div.td-block-row"));
        if(elements==null){
            throw new Exception("No list record found");
        }
        for (WebElement rowElement : elements) {
            List<WebElement> tdElements = rowElement.findElements(By.cssSelector("div.td-block-span6 div.td-module-thumb"));
            for (WebElement colElement : tdElements) {
                WebElement linkEle = colElement.findElement(By.tagName("a"));

                McWeekAds weekAdBean = new McWeekAds();
//                weekAdBean.setLinkResource(linkResource);
                if (linkEle != null) {
                    spiderDBService.insertResources(ResourcesType.DETAIL.name(), domainName,LinkType.URL.name(),getWebElementAttr(linkEle,"href"));
                    String title = linkEle.getAttribute("title");
                    weekAdBean.setTitle(title);
                }
                WebElement titleImg = colElement.findElement(By.tagName("img"));

                if (titleImg != null) {
                    String titleImgUrl = titleImg.getAttribute("src").replace(domainUrl,"");

                    File file=titleImg.getScreenshotAs(OutputType.FILE);
                    FileUtil.copyFile(file,new File(downloadRoot+baseDir + titleImgUrl), StandardCopyOption.REPLACE_EXISTING);
                    if(titleImgUrl!=null) {
                        weekAdBean.setTitleImg(titleImgUrl);
                    }
//                    if(titleImgUrl.indexOf("base64")<0) {
//                        try{
//                            HttpUtil.downloadFile(linkResource.getLinkUrl(), downloadRoot+baseDir + getUrlPath(linkResource.getLinkUrl()));
//                        }catch (Exception es) {
//                            spiderDBService.insertResources(ResourcesType.RESOURCES.name(), domainName, LinkType.IMG.name(), titleImgUrl);
//                            es.printStackTrace();
//                        }
//                    }
                }
                try {
                    mcWeekAdsRepo.save(weekAdBean);
                }catch (Exception es){
                    es.printStackTrace();
                     throw es;
                }
            }
        }




    }



}
