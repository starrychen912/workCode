package com.ddtech.netspider.core.whatcoupon;

import cn.hutool.core.util.StrUtil;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCoupon;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCateRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCouponRepo;
import com.ddtech.netspider.service.SpiderDBService;
import org.checkerframework.checker.units.qual.A;
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

import java.util.List;


@Service("WhatCouponUpdateBandService")
public class WhatCouponUpdateBandService{

    Logger logger = LoggerFactory.getLogger(this.getClass());

    @Autowired
    private SpiderDBService spiderService;

    @Autowired
    private CpCouponRepo cpCouponRepo;

    @Autowired
    private CpCateRepo cpCateRepo;

    private static String domainName="whatcoupon";

    public void startTask() {
        try {
            String queryString="%amazon%";
            List<CpCoupon> cpCouponList = cpCouponRepo.findAllByLinkLikeAndBrandNameIsNullOrderByLastModifiedDateAsc(queryString);
            int index=0;
            for (CpCoupon cpCoupon : cpCouponList) {
                index++;
                System.out.println("begin handle index:"+index);
                String dealLink = cpCoupon.getLink();
                if (dealLink.indexOf("amazon") < 0) {
                    continue;
                }
                try {
                    parserMain( dealLink, cpCoupon);
                    System.out.println(" handle index:"+index +" success");
                } catch (Exception es) {
                    es.printStackTrace();
                    continue;
                }


            }
        }catch (Exception es){
            es.printStackTrace();
        }


    }




    public void parserMain(String url,CpCoupon cpCoupon) throws Exception{
        Document doc = null;
        Connection connection = null;
        try {
            connection = Jsoup.connect(url);
            logger.info("Begin parser url:" + url);
            doc = connection.get();
            parserBand(doc,cpCoupon);
        } catch (Exception es) {
            logger.error("  error:" + es.getMessage() + " url:" + url);
            es.printStackTrace();
            throw es;

        } finally {

        }


    }

    public void parserBand(Document doc,CpCoupon cpCoupon) throws Exception{
        Elements elements=doc.select("tr.po-brand td");

        if(elements!=null && elements.size()>1){

            String eleTxt = getElementText(elements.get(0));
            String eleValue = getElementText(elements.get(1));
            if(eleTxt!=null && "Brand".equalsIgnoreCase(eleTxt) && StrUtil.isNotEmpty(eleValue)){
                saveData(cpCoupon,eleValue);

            }
            return;
        }
        elements=doc.select("#productDetails_techSpec_section_1 tr");
        if(elements!=null && elements.size()>1) {
            for (Element element : elements) {

                String eleTxt = getElementText(element.selectFirst("th"));
                String eleValue = getElementText(element.selectFirst("td"));
                if ("Brand".equals(eleTxt) && StrUtil.isNotEmpty(eleValue)) {

                    saveData(cpCoupon,eleValue);
                    break;
                }


            }
            return;
        }
        return;
    }

    public void saveData(CpCoupon cpCoupon,String brandValue){

        CpCate cpCate = cpCateRepo.findFirstByNameAndTypeId(brandValue, 2L);
        if (cpCate == null) {
            cpCate = new CpCate();
            cpCate.setTypeId(2L);
            cpCate.setName(brandValue);
            cpCate.setPid(0L);
            cpCate = cpCateRepo.save(cpCate);
        }
        cpCoupon.setBrandId(cpCate.getId());
        cpCoupon.setBrandName(cpCate.getName());
        System.out.println("Brand:" + cpCate.getName() + " id:" + cpCate.getId());
        cpCouponRepo.save(cpCoupon);

    }


    public String getElementText(Element element) {
        if (element == null) {
            return "";
        }
        return StrUtil.trim(element.text());
    }

}
