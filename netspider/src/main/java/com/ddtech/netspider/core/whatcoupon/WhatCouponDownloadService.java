package com.ddtech.netspider.core.whatcoupon;

import cn.hutool.http.HttpUtil;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.service.SpiderDBService;
import com.ddtech.netspider.utils.SftpUtils;
import com.jcraft.jsch.ChannelSftp;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import java.util.List;

@Service("WhatCouponDownloadService")
public class WhatCouponDownloadService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(WhatCouponDownloadService.class);


    @Autowired
    private SpiderDBService spiderService;

    @Value("${resource.download.root}")
    private String downloadRoot;

    private static String baseDir = "/whatcoupon";

    private static String domainName = "whatcoupon";

    @Override
    @Async
    public void startTask(JobTask jobTask) {
        List<LinkResource> linkResourceList = spiderService.findTop10Res(domainName, ResourcesType.RESOURCES.name());
            for (LinkResource linkResource : linkResourceList) {
                if (linkResource != null) {

                    try {
                        saveResStatus(linkResource, JobStatus.PROCESSING.name());
                        saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass() + " begin download", linkResource);
                        downloadImg(linkResource);
                        saveTaskLog(jobTask, JobStatus.COMPLETE.name(), this.getClass() + " download succeed.", linkResource);
                        saveResStatus(linkResource, JobStatus.COMPLETE.name());
                    } catch (Exception es) {
                        saveResStatus(linkResource, JobStatus.FAILED.name());
                        saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass() + "  download failed:" + es.getMessage(), linkResource);
                        logger.error("failed:",es);
                        es.printStackTrace();
                        continue;

                    }
                } else {
                    saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass() + " Get link resource for list failed:" + linkResource);
                    logger.error("Get IMG resource failed...");
                    continue;
                }

            }

    }

    @Async
    public void downloadImg(LinkResource linkResource) throws Exception {
        try {
            HttpUtil.downloadFile(linkResource.getLinkUrl(), downloadRoot+baseDir + getUrlPath(linkResource.getLinkUrl()));
//            sftpUtils.upload(linkResource.getLinkUrl(), downloadRoot + baseDir);
            logger.info(linkResource.getLinkUrl() + " downloaded success!");
        } catch (Exception es) {
            es.printStackTrace();
            throw es;
        }
    }


}
