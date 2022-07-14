package com.ddtech.netspider.core.marketscoupon;

import cn.hutool.core.io.FileUtil;
import cn.hutool.core.util.StrUtil;
import cn.hutool.json.JSONArray;
import cn.hutool.json.JSONUtil;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.marketscoupon.McStore;
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
import java.util.ArrayList;
import java.util.List;


@Service("MarketCouponDetailService")
public class MarketCouponDetailService extends SpiderService {


    Logger logger = LoggerFactory.getLogger(MarketCouponDetailService.class);

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

    @Async
    @Override
    public void startTask(JobTask jobTask) {
        List<LinkResource> linkResourceList = spiderDBService.findTop5Res(domainName, ResourcesType.DETAIL.name());
        for (LinkResource linkResource : linkResourceList) {
            if (linkResource != null) {
                saveResStatus(linkResource,JobStatus.PROCESSING.name());
                try {
                    saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass()+" begin parser",linkResource);
                    parserInit(linkResource,jobTask);
                    saveTaskLog(jobTask, JobStatus.COMPLETE.name(), this.getClass()+" parser succeed.",linkResource);
                    saveResStatus(linkResource,JobStatus.COMPLETE.name());
                } catch (Exception es) {
                    saveResStatus(linkResource,JobStatus.FAILED.name());
                    saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass()+" failed:" + es.getMessage(),linkResource);
                    logger.error("failed:",es);
                    es.printStackTrace();
                    continue;
                }
            } else {
                saveResStatus(linkResource,JobStatus.FAILED.name());
                saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" parser Get link resource for list failed:"+ linkResource);
                logger.warn("parser Get link resource for list failed...");
                continue;
            }

        }
    }

    public void parserInit(LinkResource linkResource,JobTask jobTask) throws Exception {
        String url = linkResource.getLinkUrl();
        WebDriver driver=null;
        try {
            logger.info("Begin parser url:" + url);
            driver=getChromeDriver();
            driver.manage().window().setSize(new Dimension(15360,3600));
            driver.get(url);
            parserMain(driver, linkResource);
        } catch (Exception es) {
            logger.error("error:" + es.getMessage() + " url:" + url);
            es.printStackTrace();
            throw es;
        } finally {
            if(driver!=null) {
                driver.quit();
            }
        }

    }


    public void parserMain(WebDriver driver, LinkResource linkResource) throws Exception{

        McStore mcStore = parserStore(driver);
        WebElement titleElement = driver.findElement(By.cssSelector("h1.entry-title"));
        String title = getWebElementText(titleElement);

        McWeekAds weekAdBean = mcWeekAdsRepo.findWeekAdsByTitle(title);
        if(weekAdBean==null){
            weekAdBean=new McWeekAds();
            weekAdBean.setTitle(title);
        }
        weekAdBean.setStoreId(mcStore.getId());

        weekAdBean.setLinkResource(linkResource);
        WebElement dateElement = driver.findElement(By.cssSelector("span.td-post-date time"));
        weekAdBean.setCreateTime(getWebElementAttr(dateElement, "datetime"));

        String content = "";
        WebElement contentElements = driver.findElement(By.cssSelector("div.td-post-content"));

        List<WebElement> tdElements = contentElements.findElements(By.cssSelector("p"));
        List<String> contentList = new ArrayList<>();
        for (WebElement colElement : tdElements) {
            contentList.add(getWebElementText(colElement));
        }
        JSONArray contentArray = JSONUtil.parseArray(contentList);
        weekAdBean.setContent(contentArray.toString());

        List<WebElement> adElements = contentElements.findElements(By.cssSelector("img"));
        List<String> imgList = new ArrayList();
        for (WebElement adElement : adElements) {
            String imgLink=getWebElementAttr(adElement, "src");
            String imgUrl = imgLink.replace(domainUrl,"");
            File file=adElement.getScreenshotAs(OutputType.FILE);
            try {
                FileUtil.copyFile(file, new File(downloadRoot + baseDir + imgUrl), StandardCopyOption.REPLACE_EXISTING);
            }catch (Exception es){
                es.printStackTrace();
                spiderDBService.insertResources(ResourcesType.RESOURCES.name(), domainName, LinkType.IMG.name(), imgLink);
            }

            imgList.add(imgUrl);

        }
        JSONArray jsonArray = JSONUtil.parseArray(imgList);
        weekAdBean.setAdUrl(jsonArray.toString());

        mcWeekAdsRepo.save(weekAdBean);

    }

    private McStore parserStore(WebDriver driver) throws Exception {
        McStore mcStoreBean = new McStore();

        WebElement storeElement = driver.findElement(By.cssSelector("div.store-box-wrap"));
        if(storeElement==null){
            logger.error("Store div not found for url:"+driver.getCurrentUrl());
        }

        WebElement storeNameEle=storeElement.findElement(By.cssSelector("div.td-store-name.vcard.store span a"));
        String storeName = getWebElementText(storeNameEle);
        if (StrUtil.isNotEmpty(storeName)) {
            McStore mcStoreDb = mcStoreRepo.findStoreByStoreName(storeName);
            if (mcStoreDb != null) {
                return mcStoreDb;
            } else {
                mcStoreBean.setStoreName(storeName);
            }
        }

        WebElement storeLogoEle=storeElement.findElement(By.cssSelector("div.store-box-wrap a img"));
        mcStoreBean.setStoreLogo(getWebElementAttr(storeLogoEle, "src"));


        WebElement storeLinkEle = storeElement.findElement(By.cssSelector("div.td-store-url"));
        mcStoreBean.setStoreLink(getWebElementText(storeLinkEle));


        List<WebElement> descriptEles = storeElement.findElements(By.cssSelector("div.td-store-description p"));

        if (descriptEles != null && descriptEles.size() > 0) {
            List<String> descList = new ArrayList<>();
            for (WebElement webElement : descriptEles) {
                descList.add(getWebElementText(webElement));
            }
            JSONArray descArray = JSONUtil.parseArray(descList);
            mcStoreBean.setDescription(descArray.toString());
        }

        return mcStoreRepo.save(mcStoreBean);
    }
}
