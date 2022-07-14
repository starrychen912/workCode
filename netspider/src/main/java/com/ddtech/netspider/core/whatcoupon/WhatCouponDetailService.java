package com.ddtech.netspider.core.whatcoupon;


import cn.hutool.core.date.DateUtil;
import cn.hutool.core.util.StrUtil;

import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCoupon;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpComment;
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

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Locale;

@Service("WhatCouponDetailService")
public class WhatCouponDetailService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(WhatCouponDetailService.class);

    @Autowired
    private CpCouponRepo cpCouponRepo;

    @Autowired
    private SpiderDBService spiderDBService;

    @Autowired
    private CpCateRepo cpCateRepo;

    @Autowired
    private CpCommentRepo couponCommentRepo;



    private static String domainName = "whatcoupon";


    @Async
    @Override
    public void startTask(JobTask jobTask) {
        List<LinkResource> linkResourceList = spiderDBService.findTop5Res(domainName, ResourcesType.DETAIL.name());
        for (LinkResource linkResource : linkResourceList) {
            if (linkResource != null) {

                try {
                    saveResStatus(linkResource,JobStatus.PROCESSING.name());
                    saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass()+" begin parser",linkResource);
                    if("store".equals(linkResource.getLinkFlag())){
                        parserStoreDetail(linkResource);
                    }else{
                        parserCateDetail(linkResource);
                    }
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

    @Async
    public void parserBrand(CpCoupon cpCoupon) throws Exception{
        String url=cpCoupon.getLink();
        if(StrUtil.isEmpty(url) || url.indexOf("amazon")<0){
            return;
        }
        Document doc = null;
        Connection connection = null;
        try {
            connection = Jsoup.connect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserBrandMain(doc,cpCoupon);
        } catch (Exception es) {
            es.printStackTrace();
            throw es;
        } finally {
            doc = null;
            connection = null;
        }

    }


    @Async
    public void parserStoreDetail(LinkResource linkResource) throws Exception{

        Document doc = null;
        Connection connection = null;
        String url = linkResource.getLinkUrl();
        try {
            connection = Jsoup.connect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserDetailStore(doc, linkResource);
        } catch (Exception es) {
            logger.error("parserDetail error:" + es.getMessage() + " url:" + url);
            es.printStackTrace();
            throw es;
        } finally {
            doc = null;
            connection = null;
        }

    }


    public void parserTest() {
        LinkResource linkResource = new LinkResource();
        linkResource.setLinkUrl("https://slickdeals.net/f/15812176-traveler-s-club-luggage-ridgewood-ii-20-inch-spinner-carry-on-suitcase-23-99-beyond-otherwise-29-99?src=jfy&prop=rcmid-20cc09552c2dda478a64d6a7ed2a8e5e");
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

        Element titleEle = doc.selectFirst("#dealTitle h1");
        String title = titleEle.text();
        Element detailEle = doc.selectFirst("#detailsArea");

        Elements imagesList = detailEle.select("div.dealDetailsImages  li img");
        StringBuffer imgBuffer = new StringBuffer("");

        for (Element imageEle : imagesList) {
            String imagUrl = imageEle.attr("data-fullsize");
            if (imagUrl.indexOf("http") < 0) {
                imgBuffer.append(imagUrl + ",");
                imagUrl = "https://slickdeals.net" + imagUrl;
            }
            spiderDBService.insertResources(ResourcesType.RESOURCES.name(),domainName, LinkType.IMG.name(), imagUrl, linkResource.getAttachedInfo());
        }

        Element dealPriceEle = detailEle.selectFirst("div.dealPrice");
        String dealPriceStr = "";
        if (dealPriceEle != null) {
            dealPriceStr = dealPriceEle.text();
        }


        Element oldPriceEle = detailEle.selectFirst("span.oldListPrice");
        String oldPriceStr = "";
        if (oldPriceEle != null) {
            oldPriceStr = oldPriceEle.text();
        }

        Element dealExtraDetailsEle = detailEle.selectFirst("#dealExtraDetails");
        String dealExtraDetails = "";
        if (dealExtraDetailsEle != null) {
            dealExtraDetails = dealExtraDetailsEle.text();
        }

        Element dealStatsNewEle = detailEle.selectFirst("#dealStatsNew");

        String views = "0";
        Elements commentEles = dealStatsNewEle.select("span");
        for (Element commentEle : commentEles) {
            String commentText = commentEle.text();
            if (commentText.indexOf("Views") > -1) {
                views = commentText;
                break;
            }
        }
        int viewCount = getViews(views);

        Element scoreSignEle = dealStatsNewEle.selectFirst("div.dealScore span[role=thread.sign]");
        Element scoreEle = dealStatsNewEle.selectFirst("div.dealScore span[role=thread.score]");

        String socreStr = getElementText(scoreSignEle) + getElementText(scoreEle);

        int socreInt = Integer.parseInt(socreStr);

        Element commentEle = dealStatsNewEle.selectFirst("a label");

        String commentStr = getElementText(commentEle);

        int commentInt = getComments(commentStr);

        Element detailDescEle = detailEle.selectFirst("#detailsDescription");
        filterSlick(detailDescEle);

        Element postAttachments = detailDescEle.selectFirst("div.postAttachments");
        if (postAttachments != null) {
            postAttachments.html("");
        }
        Element linkEle = detailEle.selectFirst("#largeBuyNow");

        String linkUrl = getJumpUrl(linkEle.attr("href"));

        StringBuffer contentBuffer = new StringBuffer("");
        contentBuffer.append(detailDescEle.html());

        Element notesAndResearch = detailEle.selectFirst("#notesAndResearch");
        if (notesAndResearch != null) {
            notesAndResearch.html("<h2>Editor's Notes & Price Research</h2>");
            contentBuffer.append(notesAndResearch.html());
        }


        Element editorsNotes = detailEle.selectFirst("div.editorsNotes");
        if (editorsNotes != null) {
            filterSlick(editorsNotes);
            contentBuffer.append(editorsNotes.html());
        }


        CpCate cpCate = cpCateRepo.findFirstByName(linkResource.getAttachedInfo());

        CpCoupon cpCoupon =cpCouponRepo.findFirstByTitle(title);
        if(cpCoupon==null){
            cpCoupon=new CpCoupon();
        }
        cpCoupon.setTitle(title);

        if (cpCate != null) {
            cpCoupon.setCateId(cpCate.getId());
        }
        Element editedDateTimeEl=detailEle.selectFirst("span.editedDateTime");
        if(editedDateTimeEl!=null) {
            String dateString = getElementText(editedDateTimeEl.selectFirst("span.date")) + " " + getElementText(editedDateTimeEl.selectFirst("span.time"));
            SimpleDateFormat df = new SimpleDateFormat("MM-dd-yyyy hh:mm a",
                    Locale.ENGLISH);
            cpCoupon.setCreatetime(df.parse(dateString).getTime());
        }


        cpCoupon.setCateName(linkResource.getAttachedInfo());
        cpCoupon.setDealPrice(dealPriceStr);
        cpCoupon.setOldListPrice(oldPriceStr);
        cpCoupon.setDealExtraDetails(dealExtraDetails);
        cpCoupon.setLink(linkUrl);
        cpCoupon.setLinkResource(linkResource);
        cpCoupon.setImages(imgBuffer.toString());
        cpCoupon.setContent(contentBuffer.toString().replace("Slickdeals", ""));
        cpCoupon.setCount(commentInt);
        cpCoupon.setPraise(socreInt);
        cpCoupon.setViews(viewCount);
        cpCoupon = cpCouponRepo.save(cpCoupon);
        parserBrand(cpCoupon);
        saveComment(cpCoupon,doc);

    }


    public void saveComment(CpCoupon cpCoupon, Document doc) throws Exception{

        Elements elements=doc.select("div.postTextContent");
        if(elements!=null && elements.size()>0) {
            for (Element element : elements) {

                CpComment cpComment = new CpComment();
                cpComment.setCid(cpCoupon.getId());
                String commentContent = getElementText(element);
                commentContent = filterEmoji(commentContent);
                cpComment.setComment(commentContent);
                cpComment.setUid(0L);
                couponCommentRepo.save(cpComment);
            }
        }
    }



    public void parserDetailStore(Document doc, LinkResource linkResource) throws Exception {

        Element detailEle = doc.selectFirst("div.bp-p-storeCouponModal.df-u-showable");
        Element imgEle=detailEle.selectFirst("img");


        Element titleEle=detailEle.selectFirst("a.bp-p-storeCouponModal_titleLink.bp-c-link");

        StringBuffer contentBuffer=new StringBuffer("");
        Element contentEle1=detailEle.selectFirst("span.bp-p-storeCouponModal_details");
        contentBuffer.append(getElementText(contentEle1));

        Element contentEle2=detailEle.selectFirst("div.bp-p-storeCouponModal_details");
        contentBuffer.append(getElementText(contentEle2));

        Element codeBlockEle=detailEle.selectFirst("div.bp-p-storeCouponModal_codeBlock");
        if(codeBlockEle!=null) {
            Element contentEle3 = codeBlockEle.selectFirst("span.bp-p-storeCouponModal_code");

            contentBuffer.append("<span class='coupon_code'>" + getElementText(contentEle3) + "</span>");
        }else{
            contentBuffer.append("<span class='coupon_code'>No Coupon Code Required</span>");
        }

        Element linkEle=detailEle.selectFirst("a.bp-p-storeCouponModal_titleLink.bp-c-link");

        String linkUrl=getElementAttr(linkEle,"href");

        if(StrUtil.isNotEmpty(linkUrl)){
            linkUrl="https://coupons.slickdeals.net"+linkUrl;
            linkUrl=getJumpUrl(linkUrl);
        }

        String imagUrl=getElementAttr(imgEle,"src");
        String dbImgLink=imagUrl;
        if (imagUrl.indexOf("http") < 0) {
            imagUrl = "https://slickdeals.net" + imagUrl;
        }
        spiderDBService.insertResources(ResourcesType.RESOURCES.name(),domainName, LinkType.IMG.name(), imagUrl, linkResource.getAttachedInfo());


        CpCate cpCate = cpCateRepo.findFirstByName(linkResource.getAttachedInfo());
        String title=getElementText(titleEle);
        CpCoupon cpCoupon =cpCouponRepo.findFirstByTitle(title);
        if(cpCoupon==null){
            cpCoupon=new CpCoupon();
        }

        cpCoupon.setTitle(title);
        if (cpCate != null) {
            cpCoupon.setPlatformId(cpCate.getId());
        }
        cpCoupon.setPlatformName(linkResource.getAttachedInfo());
        cpCoupon.setDealPrice("");
        cpCoupon.setOldListPrice("");
        cpCoupon.setDealExtraDetails("");
        cpCoupon.setLink(linkUrl);
        cpCoupon.setImages(dbImgLink);
        cpCoupon.setContent(contentBuffer.toString().replace("Slickdeals", ""));
        cpCoupon = cpCouponRepo.save(cpCoupon);
    }


    public void parserBrandMain(Document doc,CpCoupon cpCoupon) throws Exception{

        Elements elements=doc.select("#productDetails_techSpec_section_1 tr");

        for(Element element:elements){
            String eleTxt=getElementText(element.selectFirst("th"));
            String eleValue=getElementText(element.selectFirst("td"));
            if("Brand".equals(eleTxt) && StrUtil.isNotEmpty(eleValue)){

                CpCate cpCate=cpCateRepo.findFirstByNameAndTypeId(eleValue,2L);
                if(cpCate==null){
                    cpCate=new CpCate();
                    cpCate.setTypeId(2L);
                    cpCate.setName(eleValue);
                    cpCate.setPid(0L);
                    cpCateRepo.save(cpCate);
                }
                cpCoupon.setBrandId(cpCate.getId());
                cpCoupon.setBrandName(cpCate.getName());
                cpCouponRepo.save(cpCoupon);
                break;
            }


        }
        return;
    }

    public void filterSlick(Element elementNode) throws Exception {
        if (elementNode == null) {
            return;
        }
        Elements linkElements = elementNode.select("a");
        for (Element element : linkElements) {
            String linkUrl = getElementAttr(element,"href");
            try {
                linkUrl = getJumpUrl(linkUrl);
                if (linkUrl.indexOf("slickdeals") > -1) {
                    element.attr("href", "#");
                } else {
                    element.attr("href", linkUrl);
                }
            } catch (Exception es) {
                element.attr("href", "#");
            }


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
