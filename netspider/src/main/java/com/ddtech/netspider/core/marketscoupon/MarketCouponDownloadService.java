package com.ddtech.netspider.core.marketscoupon;

import cn.hutool.http.HttpUtil;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.repo.spider.JobTaskRepo;
import com.ddtech.netspider.service.SpiderDBService;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import java.util.List;

@Service("MarketCouponDownloadService")
public class MarketCouponDownloadService extends SpiderService {

    Logger logger = LoggerFactory.getLogger(MarketCouponDownloadService.class);


    @Autowired
    private SpiderDBService spiderService;

    @Value("${resource.download.root}")
    private String downloadRoot;

    @Autowired
    private JobTaskRepo jobTaskRepo;

    private static String baseDir = "/marketscoupon";

    private static String domainName = "marketsCoupon";

    @Override
    @Async
    public void startTask(JobTask jobTask) {
        List<LinkResource> linkResourceList = spiderService.findTop5Res(domainName, ResourcesType.RESOURCES.name());

            for (LinkResource linkResource : linkResourceList) {
                if (linkResource != null) {

                    try {
                        saveResStatus(linkResource,JobStatus.PROCESSING.name());
                        saveTaskLog(jobTask, JobStatus.PROCESSING.name(), this.getClass()+" begin download",linkResource);
                        downloadImg(linkResource);
                        saveResStatus(linkResource,JobStatus.COMPLETE.name());
                        saveTaskLog(jobTask, JobStatus.COMPLETE.name(), this.getClass()+" download succeed.",linkResource);

                    } catch (Exception es) {
                        saveResStatus(linkResource,JobStatus.FAILED.name());
                        saveTaskLog(jobTask, JobStatus.FAILED.name(), this.getClass()+"  download failed:"+es.getMessage(),linkResource);
                        logger.error("failed:",es);
                        es.printStackTrace();
                    }
                } else {
                    saveResStatus(linkResource,JobStatus.FAILED.name());
                    saveTaskLog(jobTask, JobStatus.FAILED.name(),this.getClass()+" Get link resource for list failed:"+ linkResource);
                    logger.error(" Get IMG resource failed...");
                    return;
                }

            }

    }

    public void downloadImg(LinkResource linkResource) throws Exception {

        try {
            HttpUtil.downloadFile(linkResource.getLinkUrl(), downloadRoot+baseDir + getUrlPath(linkResource.getLinkUrl()));
//            SftpUtils sftpUtils=new SftpUtils();
//            sftpUtils.upload(linkResource.getLinkUrl(),downloadRoot+baseDir);
        } catch (Exception es) {
            spiderService.saveResStatus(linkResource,JobStatus.FAILED.name());
            es.printStackTrace();
            throw es;
        }
    }


}
