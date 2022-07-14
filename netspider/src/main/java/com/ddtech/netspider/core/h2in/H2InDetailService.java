package com.ddtech.netspider.core.h2in;


import cn.hutool.core.date.DateUtil;
import cn.hutool.core.util.StrUtil;
import cn.hutool.json.JSONUtil;
import com.beust.ah.A;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.h2in.H2inApp;
import com.ddtech.netspider.jpa.entity.h2in.H2inAppVersion;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpComment;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCoupon;
import com.ddtech.netspider.jpa.repo.h2in.H2inAppRepo;
import com.ddtech.netspider.jpa.repo.h2in.H2inAppVersionRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCateRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCommentRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCouponRepo;
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

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;

@Service("H2InDetailService")
public class H2InDetailService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(this.getClass());

    @Autowired
    private H2inAppRepo h2inAppRepo;

    @Autowired
    private H2inAppVersionRepo h2inAppVersionRepo;


    @Autowired
    private SpiderDBService spiderDBService;

    @Autowired
    private CpCateRepo cpCateRepo;

    @Autowired
    private CpCommentRepo couponCommentRepo;



    private static String domainName = "h2in";


    @Async
    @Override
    public void startTask(JobTask jobTask) {
        List<LinkResource> linkResourceList = spiderDBService.findTop5Res(domainName, ResourcesType.DETAIL.name());
        for (LinkResource linkResource : linkResourceList) {
            if (linkResource != null) {

                try {
                    saveResStatus(linkResource,JobStatus.PROCESSING.name());
                    saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass()+" begin parser",linkResource);
                    parserCateDetail(linkResource);
                   saveResStatus(linkResource,JobStatus.COMPLETE.name());
                    saveTaskLog(jobTask, JobStatus.COMPLETE.name(), this.getClass()+" parser succeed.",linkResource);

                }catch (Exception es){
                   saveResStatus(linkResource,JobStatus.FAILED.name());
                    saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass()+" failed:" + es.getMessage(),linkResource);
                    logger.error("failed:",es);
                    es.printStackTrace();
                    continue;
                }
            } else {
               saveResStatus(linkResource,JobStatus.FAILED.name());
                saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" parser Get link resource for list failed:"+ linkResource);
                logger.warn(" WhatCouponDetailService Get link resource for detail failed...");
                continue;
            }

        }
    }

    @Async
    public void parserCateDetail(LinkResource linkResource) throws Exception{

        Document doc = null;
        Connection connection = null;
        String url = linkResource.getLinkUrl();
        try {
            connection = Jsoup.connect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserDetailCate(doc, linkResource);
        } catch (Exception es) {
           es.printStackTrace();
           throw es;
        } finally {
            doc = null;
            connection = null;
        }

    }



    public void parserTest() {
        LinkResource linkResource = new LinkResource();
        linkResource.setLinkUrl("https://slickdeals.net/f/15787726-super-thin-open-end-wrench-set-8-piece-27-54-free-shipping\n");
        linkResource.setAttachedInfo("test");

        Document doc = null;
        Connection connection = null;
        String url = linkResource.getLinkUrl();
        try {
            connection = Jsoup.connect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserDetailCate(doc, linkResource);

        } catch (Exception es) {
            logger.error("parserDetail error:" + es.getMessage() + " url:" + url);

        } finally {

        }

    }


    public void parserDetailCate(Document doc, LinkResource linkResource) throws Exception {

        Element detailEle = doc.selectFirst("div.app-detail-box");
        H2inApp h2inApp=new H2inApp();

        String appName=getElementText(detailEle.selectFirst("div.app-detail-title"));
        h2inApp.setAppName(appName);
        String appLogo=getElementAttr(detailEle.selectFirst("img.app-detail-image"),"src");
        h2inApp.setApplogo(getUrlPath(appLogo));
        spiderDBService.insertResources(ResourcesType.RESOURCES.name(),domainName, LinkType.IMG.name(), appLogo);
        Elements appDetailItemEls=detailEle.select("div.app-detail-item");
        for(Element detailItemEl:appDetailItemEls){
            Element lableEl=detailItemEl.selectFirst("div.app-detail-label");
            Element lableTextEl=detailItemEl.selectFirst("div.app-detail-text");
            String lableTag=getElementText(lableEl);
            String lableText=getElementText(lableTextEl);
            if("Version".equalsIgnoreCase(lableTag)){
                h2inApp.setAppVersion(lableText);
                continue;
            }
            if("Tag".equalsIgnoreCase(lableTag)){
                h2inApp.setTag(lableText);
                continue;
            }
            if("Rate".equalsIgnoreCase(lableTag)){
                h2inApp.setRate(new BigDecimal(lableText));
                continue;
            }
            if("Reviews".equalsIgnoreCase(lableTag)){
                h2inApp.setReviews(str2Integer(lableText));
                continue;
            }
            if("Installs".equalsIgnoreCase(lableTag)){
                h2inApp.setInstall(lableText);
                continue;
            }
            if("Developer".equalsIgnoreCase(lableTag)){
                h2inApp.setDeveloper(lableText);
                continue;
            }

            if("Content Rating".equalsIgnoreCase(lableTag)){
                h2inApp.setContentRating(lableText);
                continue;
            }
        }

        String appDetailDescript=getElementText(detailEle.selectFirst("div.app-detail-description"));
        h2inApp.setDescription(appDetailDescript);
        Elements reviewEls=doc.select("div.app-article_content-tab-content content-collpase");
        for(Element reviewEle:reviewEls){
            String id=reviewEle.attr("id");
            if("appstoriesTabContent".equalsIgnoreCase(id)){
                h2inApp.setReviewContent(reviewEle.html());
                continue;
            }
            if("authorTabContent".equalsIgnoreCase(id)){
                h2inApp.setAuthorReview(reviewEle.html());
                continue;
            }
        }

        Elements screenShotsEle=doc.select("div.screenshots-image-box img");

        List<String> imgList=new ArrayList<>();
        for(Element screenShotEle:screenShotsEle){
            String imgSrc=getElementAttr(screenShotEle,"src");
            imgList.add(getUrlPath(imgSrc));
            spiderDBService.insertResources(ResourcesType.RESOURCES.name(),domainName, LinkType.IMG.name(), imgSrc);
        }

        h2inApp.setScreenShots(JSONUtil.toJsonStr(imgList));

        Elements downloadEls=doc.select("div.download-box-content div.download-item");

        for(Element downloadEle:downloadEls){
            String downloadType=getElementText(downloadEle.selectFirst("div.download-type"));
            String downloadLink=getElementAttr(downloadEle.selectFirst("a"),"href");
            if("Google Play".equalsIgnoreCase(downloadType)){
                h2inApp.setGoogleLink(downloadLink);
                continue;
            }

            if("APK".equalsIgnoreCase(downloadType)){
                h2inApp.setApkLink("https://am5.com"+downloadLink);
                continue;
            }
            if("IOS".equalsIgnoreCase(downloadType)){
                h2inApp.setGoogleLink(downloadLink);
                continue;
            }

        }
        h2inApp=h2inAppRepo.save(h2inApp);
        Elements versionEles=doc.select("div.version-item");
        for(Element versionEle:versionEles) {
            String downloadUrl=getElementAttr(versionEle.selectFirst("a.version-download"),"href");
            Elements versionPopEles=versionEle.select("div.version-props");
            H2inAppVersion h2inAppVersion=new H2inAppVersion();
            h2inAppVersion.setH2inApp(h2inApp);
            h2inAppVersion.setDownloadUrl(downloadUrl);
            for(Element versionPopEle:versionPopEles){
                String versionLable=getElementText(versionPopEle.selectFirst("div.version-label"));
                String versionValue=getElementText(versionPopEle.selectFirst("div.version-value"));
                if("Package Name".equalsIgnoreCase(versionLable)){
                    h2inAppVersion.setPackageName(versionValue);
                    continue;
                }
                if("Version Name".equalsIgnoreCase(versionLable)){
                    h2inAppVersion.setAppVersion(versionValue);
                    continue;
                }
                if("Version Code".equalsIgnoreCase(versionLable)){
                    h2inAppVersion.setVersionCode(versionValue);
                    continue;
                }
                if("File Size".equalsIgnoreCase(versionLable)){
                    h2inAppVersion.setFileSize(versionValue);
                    continue;
                }

                if("Update time".equalsIgnoreCase(versionLable)){
                    h2inAppVersion.setUpdateTime(DateUtil.parseDateTime(versionValue));
                    continue;
                }

                if("System Requirements".equalsIgnoreCase(versionLable)){
                    h2inAppVersion.setSysRequirement(versionValue);
                    continue;
                }
                if("Signature".equalsIgnoreCase(versionLable)){
                    h2inAppVersion.setSignature(versionValue);
                    continue;
                }

            }
            h2inAppVersionRepo.save(h2inAppVersion);


        }





    }



    public static Integer getViews(String views) {
        if (StrUtil.isEmpty(views)) {
            return 0;
        }
        views = views.replace("Views", "");
        views = views.replace(",", "");
        views = views.trim();
        try {
            return Integer.parseInt(views);
        } catch (Exception es) {
            return 0;
        }

    }

    public static Integer getComments(String views) {
        if (StrUtil.isEmpty(views)) {
            return 0;
        }
        views = views.replace("Comments", "");
        views = views.trim();
        try {
            return Integer.parseInt(views);
        } catch (Exception es) {
            return 0;
        }

    }


    public static void main(String[] args) {
        String tempStr = "4,742 Views";
        System.out.println(getViews(tempStr));
    }


}
