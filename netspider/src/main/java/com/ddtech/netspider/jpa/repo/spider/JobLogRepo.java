package com.ddtech.netspider.jpa.repo.spider;




import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.JobLog;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.repo.BaseRepo;

import java.util.List;


public interface JobLogRepo extends BaseRepo<JobLog, Long> {

//    List<JobLog> findAllByCronJob(CronJob cronJob);

}
