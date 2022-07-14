package com.ddtech.netspider.jpa.repo.spider;




import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.repo.BaseRepo;

import java.util.List;


public interface JobTaskRepo extends BaseRepo<JobTask, Long> {

    List<JobTask> findAllByCronJob(CronJob cronJob);

}
