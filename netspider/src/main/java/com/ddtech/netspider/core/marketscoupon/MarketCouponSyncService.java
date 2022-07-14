package com.ddtech.netspider.core.marketscoupon;

import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.jpa.entity.marketscoupon.McStore;
import com.ddtech.netspider.jpa.entity.marketscoupon.McWeekAds;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import com.ddtech.netspider.jpa.repo.marketscoupon.McStoreRepo;
import com.ddtech.netspider.jpa.repo.marketscoupon.McWeekAdsRepo;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import java.util.List;


@Service("MarketCouponSyncService")
public class MarketCouponSyncService extends SpiderService {


    Logger logger = LoggerFactory.getLogger(this.getClass());
    @Autowired
    private McWeekAdsRepo mcWeekAdsRepo;

    @Autowired
    private McStoreRepo mcStoreRepo;

    public String driverName = "com.mysql.cj.jdbc.Driver";


    @Override
    @Async
    public void startTask(JobTask jobTask) {
        SiteDomain siteDomain= jobTask.getCronJob().getSiteDomain();
        initDriver(driverName);
        syncCoupon(jobTask,siteDomain);
    }


    public void syncCoupon(JobTask jobTask, SiteDomain siteDomain)  {

        List<McWeekAds> mcWeekAdsList = mcWeekAdsRepo.findTop50BySyncStatusOrderByCreateDateAsc(0);

        saveWeekAds(mcWeekAdsList,siteDomain, jobTask);

        List<McStore> mcStoreList = mcStoreRepo.findTop10BySyncStatusOrderByCreateDateAsc(0);
        saveStore(mcStoreList,siteDomain, jobTask);

    }

    public void saveWeekAds(List<McWeekAds> mcWeekAdsList, SiteDomain siteDomain, JobTask jobTask)  {

            // 执行非查询语句，返回影响的行数
            for (McWeekAds mcWeekAds : mcWeekAdsList) {
                try {
                    saveTaskLog(jobTask, JobStatus.PROCESSING.name(),"Begin sync WeekAds:"+ mcWeekAds);
                    mcWeekAds.syncData(siteDomain);
                    mcWeekAds.setSyncStatus(1);
                    mcWeekAdsRepo.save(mcWeekAds);
                    saveTaskLog(jobTask, JobStatus.COMPLETE.name()," sync WeekAds:"+ mcWeekAds +" succeed.");
                }catch (Exception es){
                    saveTaskLog(jobTask, JobStatus.FAILED.name()," sync WeekAds error:"+ es.getMessage());
                    logger.error("failed:",es);
                    mcWeekAds.setSyncStatus(2);
                    mcWeekAdsRepo.save(mcWeekAds);
                    es.printStackTrace();
                    continue;
                }

            }



    }

    public void saveStore(List<McStore> mcStoreList, SiteDomain siteDomain, JobTask jobTask)  {

        // 执行非查询语句，返回影响的行数
        for (McStore mcStore : mcStoreList) {
            try {
                saveTaskLog(jobTask, JobStatus.PROCESSING.name(),"Begin sync store:"+ mcStore);
                mcStore.syncData(siteDomain);
                mcStore.setSyncStatus(1);
                mcStoreRepo.save(mcStore);
                saveTaskLog(jobTask, JobStatus.COMPLETE.name()," sync store:"+ mcStore +" succeed.");
            }catch (Exception es){
                saveTaskLog(jobTask, JobStatus.PROCESSING.name()," sync store error:"+es.getMessage());
                logger.error("failed:",es);
                mcStore.setSyncStatus(2);
                mcStoreRepo.save(mcStore);
                es.printStackTrace();
                continue;
            }

        }



    }




}
