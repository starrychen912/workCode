package com.ddtech.netspider.core.whatcoupon;


import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.service.SpiderDBService;
import org.jsoup.Connection;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import java.util.List;


@Service("WhatCouponListService")
public class WhatCouponListService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(WhatCouponListService.class);



    private static String domainName = "whatcoupon";


    @Async
    @Override
    public void startTask(JobTask jobTask) {
        List<LinkResource> linkResourceList = spiderService.findTop5Res(domainName, ResourcesType.LIST.name());
        for (LinkResource linkResource : linkResourceList) {
            if (linkResource != null) {

                try {
                    saveResStatus(linkResource,JobStatus.PROCESSING.name());
                    saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass() + " begin parser", linkResource);
                    if ("store".equals(linkResource.getLinkFlag())) {
                        parserStoreList(linkResource);
                    } else {
                        parserCateList(linkResource);

                    }
                    saveResStatus(linkResource,JobStatus.COMPLETE.name());
                    saveTaskLog(jobTask, JobStatus.COMPLETE.name(), this.getClass() + " parser succeed.", linkResource);
                } catch (Exception es) {
                    saveResStatus(linkResource,JobStatus.FAILED.name());
                    saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass() + " failed:" + es.getMessage(), linkResource);
                    logger.error("failed:",es);
                    es.printStackTrace();
                    continue;
                }
            } else {
                saveResStatus(linkResource,JobStatus.FAILED.name());
                saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass() + " parser Get link resource for list failed:" + linkResource);
                logger.warn(" parser Get link resource for list failed...");
                continue;
            }

        }
    }

    @Async
    public void parserCateList(LinkResource linkResource) throws Exception {
        String url = linkResource.getLinkUrl();
        Document doc = null;
        Connection connection = null;
        try {
            connection = getJsoupConnect(url);
            logger.info("parserCateList Begin parser url:" + url);
            doc = connection.get();
            parserMain(doc, linkResource);
        } catch (Exception es) {
            es.printStackTrace();
            throw es;
        } finally {
            doc = null;
            connection = null;
        }

    }

    @Async
    public void parserStoreList(LinkResource linkResource) throws Exception {

        String url = linkResource.getLinkUrl();
        Document doc = null;
        Connection connection = null;
        try {
            connection = getJsoupConnect(url);
            logger.info("parserStoreList Begin parser url:" + url);
            doc = connection.get();
            parserStore(doc, linkResource);
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
//        linkResource.setAttachedInfo("Autos");
        linkResource.setLinkUrl("https://coupons.slickdeals.net/3-day-blinds/");
        String url = linkResource.getLinkUrl();
        Document doc = null;
        Connection connection = null;
        try {
            connection = getJsoupConnect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserStore(doc, linkResource);
        } catch (Exception es) {
            logger.error("parserDetail error:" + es.getMessage() + " url:" + url);
        } finally {

        }

    }


    public void parserMain(Document doc, LinkResource linkResource) throws Exception {


        Elements listEles = doc.select("li.fpGridBox");
        for (Element listEle : listEles) {
            Element itemEle = listEle.selectFirst("a.itemTitle");
            String detailLink = getElementAttr(itemEle,"href");
            if (detailLink.indexOf("http") < 0) {
                detailLink = "https://slickdeals.net" + detailLink;
            }
            spiderService.insertResources(ResourcesType.DETAIL.name(), domainName, LinkType.URL.name(), detailLink, linkResource.getAttachedInfo());
        }
        //for next page
        Element pageEles = doc.selectFirst("a[data-role=next-page]");
        if (pageEles != null) {

            String linkUrl2 = getElementAttr(pageEles,"href");
            if (linkUrl2.indexOf("page") < 0) {
                return;
            }
            if (linkUrl2.indexOf("http") < 0) {
                linkUrl2 = "https://slickdeals.net" + linkUrl2;
            }

            spiderService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), linkUrl2, linkResource.getAttachedInfo());
        }


    }


    public void parserStore(Document doc, LinkResource linkResource) {

        Elements selectionListEles = doc.select("section.bp-p-storeContent_section");
        for (Element seListEle : selectionListEles) {
            Elements sourceEles = seListEle.select("ul li");
            for (Element sourceEle : sourceEles) {
                Element btnEle = sourceEle.selectFirst("button");
                String detailLink =getElementAttr(btnEle,"data-href2");
                spiderService.insertResources(ResourcesType.DETAIL.name(), domainName, LinkType.URL.name(), detailLink, linkResource.getAttachedInfo(), "store");
            }
        }

    }


}
