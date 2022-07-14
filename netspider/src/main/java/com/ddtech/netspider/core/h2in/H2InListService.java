package com.ddtech.netspider.core.h2in;


import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.LinkType;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import org.jsoup.Connection;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import java.util.List;


@Service("H2InListService")
public class H2InListService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(this.getClass());



    private static String domainName="H2IN";


    @Async
    @Override
    public void startTask(JobTask jobTask) {
        List<LinkResource> linkResourceList = spiderService.findTop5Res(domainName, ResourcesType.LIST.name());
        for (LinkResource linkResource : linkResourceList) {
            if (linkResource != null) {

                try {
                    saveResStatus(linkResource,JobStatus.PROCESSING.name());
                    saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass() + " begin parser", linkResource);

                        parserList(linkResource);

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
    public void parserList(LinkResource linkResource) throws Exception {
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


    public void parserMain(Document doc, LinkResource linkResource) throws Exception {


        Elements listEles = doc.select("div.games-box a");
        for (Element listEle : listEles) {
            String detailLink = getElementAttr(listEle,"href");
            if (detailLink.indexOf("http") < 0) {
                detailLink = "https://am5.com" + detailLink;
            }
            spiderService.insertResources(ResourcesType.DETAIL.name(), domainName, LinkType.URL.name(), detailLink, linkResource.getAttachedInfo());
        }
        //for next page
        Elements pageEles = doc.select("div.pagination ul li");
        for (Element pageEle : pageEles) {
            String linkUrl=getElementAttr(pageEle,"href");
            if(linkUrl.indexOf("script")>0){
                continue;
            }
            linkUrl="https://am5.com" + linkUrl;
            spiderService.insertResources(ResourcesType.LIST.name(), domainName, LinkType.URL.name(), linkUrl, linkResource.getAttachedInfo(),"once");
        }


    }


}
