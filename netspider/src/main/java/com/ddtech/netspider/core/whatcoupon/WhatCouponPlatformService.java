package com.ddtech.netspider.core.whatcoupon;

import cn.hutool.core.util.StrUtil;

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

import java.math.BigDecimal;

@Service("WhatCouponPlatformService")
public class WhatCouponPlatformService extends SpiderService {


    Logger logger = LoggerFactory.getLogger(WhatCouponPlatformService.class);

    @Autowired
    private CpCateRepo cpCateRepo;

    @Autowired
    private SpiderDBService spiderDBService;

    private static String domainName = "whatcoupon";



    @Async
    @Override
    public void startTask(JobTask jobTask) {
        String url = "https://coupons.slickdeals.net/stores/alpha/";
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
        Elements categoriesEl = doc.select("ul.storeListing li ul li");
        for (Element webElement : categoriesEl) {
            Element linkTag = webElement.selectFirst("a");


            Element imgTag = webElement.selectFirst("img");
            String imgLink = null;
            if (imgTag != null) {
                imgLink = imgTag.attr("data-original");

                if (imgLink.indexOf("http") < 0) {
                    imgLink = "https://coupons.slickdeals.net" + imgLink;
                }
                spiderDBService.insertResources(ResourcesType.RESOURCES.name(),domainName,LinkType.IMG.name(), imgLink,"","");


            }
            CpCate couponCategories = new CpCate();
            Element strongTag = webElement.selectFirst("strong");

            spiderDBService.insertResources(ResourcesType.LIST.name(), domainName,LinkType.URL.name(),linkTag.attr("href"),getElementText(strongTag),"Store");
            couponCategories.setName(getElementText(strongTag));
            couponCategories.setPid(0L);
            if (imgLink != null) {
                couponCategories.setImage(getUrlPathReplace(imgLink,"slickdeals",domainName));
            }
            couponCategories.setTypeId(3L);

            Element rateEle = webElement.selectFirst("span.ratings");
            if (rateEle != null) {
                Element rateScoreEle = rateEle.selectFirst("strong");
                if (rateScoreEle != null) {
                    couponCategories.setRate(new BigDecimal(rateScoreEle.text()));

                }
                String ratingCountStr = getElementText(rateEle);
                couponCategories.setRateCount(getRateCount(ratingCountStr));
            }

            logger.info("begin save platform:" + couponCategories.toString());
            couponCategories = cpCateRepo.save(couponCategories);
            logger.info("save platform:" + couponCategories.toString() + " Success!");

        }


    }

    public Integer getRateCount(String rateStr) {
        String indcateStr="based on";
        if (StrUtil.isNotEmpty(rateStr)) {
            int baseIndex=rateStr.indexOf(indcateStr);
            if(baseIndex>0){
                rateStr=rateStr.substring(baseIndex+indcateStr.length()+1);
            }
            rateStr = rateStr.replace("ratings", "");
            rateStr = rateStr.trim();
            return Integer.parseInt(rateStr);
        }
        return 0;


    }
//
//    public void downLoadFileToLocal(String imgLink,String baseDir){
//
//        try{
//            HttpUtil.downloadFile(imgLink, baseDir + getUrlPathReplace(imgLink,"slickdeals",domainName));
//        }catch (Exception es){
//            es.printStackTrace();
//        }
//
//    }


}
