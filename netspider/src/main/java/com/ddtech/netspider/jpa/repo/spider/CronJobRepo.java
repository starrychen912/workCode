package com.ddtech.netspider.jpa.repo.spider;




import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import com.ddtech.netspider.jpa.repo.BaseRepo;

import java.util.List;


public interface CronJobRepo extends BaseRepo<CronJob, Long> {

    List<CronJob> findAllByJobTypeAndStatus(String jobType, String status);

    List<CronJob> findAllBySiteDomain(SiteDomain siteDomain);
}
