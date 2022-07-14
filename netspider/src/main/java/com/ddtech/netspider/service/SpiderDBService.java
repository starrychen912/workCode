package com.ddtech.netspider.service;


import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.repo.spider.LinkResourceRepo;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class SpiderDBService {

    @Autowired
    private LinkResourceRepo linkResourceRepo;

    Logger logger = LoggerFactory.getLogger(SpiderDBService.class);


    public LinkResource saveRes(LinkResource resBean) {

        try {
           logger.info("save resources:" + resBean.toString());
           return linkResourceRepo.save(resBean);
        } catch (Exception es) {
            es.printStackTrace();
            logger.error("save resources error:"+es.getMessage());
            return null;
        }
    }

    public LinkResource saveResStatus(LinkResource resBean,String status) {

        try {
            resBean.setStatus(status);
            return saveRes(resBean);
        } catch (Exception es) {
            es.printStackTrace();
            logger.error("save resources error:"+es.getMessage());
            return null;
        }
    }



    public LinkResource insertResources(String resType, String domainName, String linkType, String linkUrl) {
        return insertResources(resType,domainName,linkType,linkUrl,"","","");
    }


    public LinkResource insertResources(String resType, String domainName, String linkType, String linkUrl, String attachInfo) {
        return insertResources(resType,domainName,linkType,linkUrl,attachInfo,"","");
    }


    public LinkResource insertResources(String resType, String domainName, String linkType, String linkUrl, String attachInfo, String flag) {
        return insertResources(resType,domainName,linkType,linkUrl,attachInfo,"",flag);
    }

    public LinkResource insertResources(String resType, String domainName, String linkType, String linkUrl, String attachInfo, String remark, String flag) {

        try {
//            LinkResource resBean= linkResourceRepo.findFirstByLinkUrl(linkUrl);
//            if(resBean==null){
//                resBean=new LinkResource();
//            }
            LinkResource resBean=new LinkResource();
            resBean.setResourceType(resType);
            resBean.setDomainName(domainName);
            resBean.setLinkType(linkType);
            resBean.setLinkUrl(linkUrl);
            resBean.setStatus(JobStatus.PREPAIRE.name());
            resBean.setAttachedInfo(attachInfo);
            resBean.setRemark(remark);
            resBean.setLinkFlag(flag);
            logger.info("insert resources:" + resBean.toString());
            return linkResourceRepo.save(resBean);

        } catch (Exception es) {
            es.printStackTrace();
            logger.error("insert resources error:"+es.getMessage());
            return null;
        }
    }

    public List<LinkResource> findTop2Res(String domainName, String  resType) {

        try {
            return linkResourceRepo.findTop2ByDomainNameAndResourceTypeAndStatus(domainName,resType, JobStatus.PREPAIRE.name());
        } catch (Exception es) {
            logger.error("save WeekAds error:"+es.getMessage());
            return null;
        }
    }

    public List<LinkResource> findTop5Res(String domainName, String  resType) {

        try {
            return linkResourceRepo.findTop5ByDomainNameAndResourceTypeAndStatus(domainName,resType, JobStatus.PREPAIRE.name());
        } catch (Exception es) {
            logger.error("save WeekAds error:"+es.getMessage());
            return null;
        }
    }

    public List<LinkResource> findTop10Res(String domainName, String  resType) {

        try {
            return linkResourceRepo.findTop10ByDomainNameAndResourceTypeAndStatus(domainName,resType, JobStatus.PREPAIRE.name());
        } catch (Exception es) {
            logger.error("save WeekAds error:"+es.getMessage());
            return null;
        }
    }
}
