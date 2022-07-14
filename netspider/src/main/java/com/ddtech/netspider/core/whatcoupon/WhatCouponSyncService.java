package com.ddtech.netspider.core.whatcoupon;

import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCoupon;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpComment;
import com.ddtech.netspider.jpa.repo.spider.JobTaskRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCateRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCommentRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCouponRepo;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import java.util.List;


@Service("WhatCouponSyncService")
public class WhatCouponSyncService extends SpiderService {


    Logger logger = LoggerFactory.getLogger(this.getClass());
    @Autowired
    private CpCouponRepo cpCouponRepo;

    @Autowired
    private CpCateRepo cpCateRepo;

    @Autowired
    private CpCommentRepo couponCommentRepo;

    @Autowired
    private JobTaskRepo jobTaskRepo;

    public String driverName = "com.mysql.cj.jdbc.Driver";


    @Override
    @Async
    public void startTask(JobTask jobTask) {
        SiteDomain siteDomain= jobTask.getCronJob().getSiteDomain();
        initDriver(driverName);
        syncCoupon(jobTask,siteDomain);
    }


    public void syncCoupon(JobTask jobTask, SiteDomain siteDomain)  {

        List<CpCoupon> couponList = cpCouponRepo.findTop50BySyncStatusOrderByCreateDateAsc(0);

        saveCoupon(couponList,siteDomain, jobTask);

        List<CpCate> cpCates = cpCateRepo.findTop10BySyncStatusOrderByCreateDateAsc(0);
        saveCate(cpCates,siteDomain, jobTask);
        List<CpComment> cpComments = couponCommentRepo.findTop10BySyncStatusOrderByCreateDateAsc(0);
        saveComment(cpComments,siteDomain, jobTask);

    }


    public void saveCoupon(List<CpCoupon> cpCoupons, SiteDomain siteDomain, JobTask jobTask)  {
        for (CpCoupon cpCoupon : cpCoupons) {

            try {
                saveTaskLog(jobTask, JobStatus.PROCESSING.name(),"Begin sync cpCoupons:"+cpCoupon);
                cpCoupon.syncData(siteDomain);
                cpCoupon.setSyncStatus(1);
                cpCouponRepo.save(cpCoupon);
                saveTaskLog(jobTask, JobStatus.COMPLETE.name()," sync cpCoupons:"+cpCoupon+" succeed.");
            }catch (Exception es){
                saveTaskLog(jobTask, JobStatus.FAILED.name()," sync cpCoupons error:"+ es.getMessage());
                cpCoupon.setSyncStatus(2);
                cpCouponRepo.save(cpCoupon);
                es.printStackTrace();
                continue;
            }

        }

    }

    public void saveCate(List<CpCate> cpCates, SiteDomain siteDomain, JobTask jobTask)  {
        for (CpCate cpCate : cpCates) {

            try {
                saveTaskLog(jobTask, JobStatus.PROCESSING.name(),"Begin sync cpCate:"+cpCate);
                cpCate.syncData(siteDomain);
                cpCate.setSyncStatus(1);
                cpCateRepo.save(cpCate);
                saveTaskLog(jobTask, JobStatus.COMPLETE.name()," sync cpCate:"+cpCate+" succeed.");
            }catch (Exception es){
                saveTaskLog(jobTask, JobStatus.FAILED.name()," sync cpCate error:"+ es.getMessage());
                cpCate.setSyncStatus(2);
                cpCateRepo.save(cpCate);
                es.printStackTrace();
                continue;
            }

        }

    }


    public void saveComment(List<CpComment> cpComments, SiteDomain siteDomain, JobTask jobTask)  {
        for (CpComment cpComment : cpComments) {

            try {
                saveTaskLog(jobTask, JobStatus.PROCESSING.name(),"Begin sync cpComment:"+cpComment);
                cpComment.syncData(siteDomain);
                cpComment.setSyncStatus(1);
                couponCommentRepo.save(cpComment);
                saveTaskLog(jobTask, JobStatus.COMPLETE.name()," sync cpComment:"+cpComment+" succeed.");
            }catch (Exception es){
                saveTaskLog(jobTask, JobStatus.FAILED.name()," sync cpComment error:"+ es.getMessage());
                cpComment.setSyncStatus(2);
                couponCommentRepo.save(cpComment);
                es.printStackTrace();
                continue;
            }
        }
    }



}
