package com.ddtech.netspider.jobs;

import cn.hutool.extra.spring.SpringUtil;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobType;
import com.ddtech.netspider.enums.Status;
import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.repo.spider.CronJobRepo;
import com.ddtech.netspider.jpa.repo.spider.JobTaskRepo;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.scheduling.TaskScheduler;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.scheduling.concurrent.ThreadPoolTaskScheduler;
import org.springframework.stereotype.Component;

import java.util.List;

@Component
@EnableScheduling
public class NetSpiderJob {

    Logger logger = LoggerFactory.getLogger(NetSpiderJob.class);

    @Autowired
    private CronJobRepo cronJobRepo;

    @Autowired
    private JobTaskRepo JobTaskRepo;


//    @Scheduled(cron = "0/20 * * * * ?")
//    private void parserList() {
//        List<CronJob> cronJobList = cronJobRepo.findAllByJobTypeAndStatus(JobType.LIST.name(), Status.ENABLE.name());
//        for (CronJob cronJob : cronJobList) {
//            logger.info(cronJob.getJobName() + " parserList job started ");
//            JobTask JobTask = new JobTask();
//            JobTask.setCronJob(cronJob);
//            JobTask = JobTaskRepo.save(JobTask);
//            SpiderService spiderService = SpringUtil.getBean(cronJob.getJobCode());
//            spiderService.startTask(JobTask);
//            logger.info(cronJob.getJobName() + " parserList job end ");
//        }
//
//    }

//    @Scheduled(cron = "0/25 * * * * ?")
//    private void parserDetail() {
//        List<CronJob> cronJobList = cronJobRepo.findAllByJobTypeAndStatus(JobType.DETAIL.name(), Status.ENABLE.name());
//        for (CronJob cronJob : cronJobList) {
//                logger.info(cronJob.getJobName() + " parserDetail job started ");
//                JobTask JobTask = new JobTask();
//                JobTask.setCronJob(cronJob);
//                JobTask = JobTaskRepo.save(JobTask);
//                SpiderService spiderService = SpringUtil.getBean(cronJob.getJobCode());
//                spiderService.startTask(JobTask);
//                logger.info(cronJob.getJobName() + " parserDetail job end ");
//
//        }
//    }
//
//    @Scheduled(cron = "0/20 * * * * ?")
//    private void parserDownload() {
//        List<CronJob> cronJobList = cronJobRepo.findAllByJobTypeAndStatus(JobType.DOWNLOAD.name(), Status.ENABLE.name());
//        for (CronJob cronJob : cronJobList) {
//            logger.info(cronJob.getJobName() + " downloadService job started ");
//            JobTask JobTask = new JobTask();
//            JobTask.setCronJob(cronJob);
//            JobTask = JobTaskRepo.save(JobTask);
//            SpiderService spiderService = SpringUtil.getBean(cronJob.getJobCode());
//            spiderService.startTask(JobTask);
//            logger.info(cronJob.getJobName() + " downloadService job end ");
//        }
//    }

//
//    @Scheduled(cron = "0/20 * * * * ?")
//    private void syncDataJob() {
//        List<CronJob> cronJobList = cronJobRepo.findAllByJobTypeAndStatus(JobType.SYNC.name(), Status.ENABLE.name());
//
//        for (CronJob cronJob : cronJobList) {
//            logger.info(cronJob.getJobName() + " syncDataJob started ");
//            JobTask jobTasks = new JobTask();
//            jobTasks.setCronJob(cronJob);
//            jobTasks = JobTaskRepo.save(jobTasks);
//            SpiderService spiderService = SpringUtil.getBean(cronJob.getJobCode());
//            spiderService.startTask(jobTasks);
//            logger.info(cronJob.getJobName() + " syncDataJob job end ");
//        }
//    }

//
//    @Scheduled(cron = "0 0 0/4 * * ?")
//    private void updateDataJob() {
//        List<CronJob> cronJobList = cronJobRepo.findAllByJobTypeAndStatus(JobType.UPDATE.name(), Status.ENABLE.name());
//
//        for (CronJob cronJob : cronJobList) {
//            logger.info(cronJob.getJobName() + " updateDataJob started ");
//            JobTask jobTasks = new JobTask();
//            jobTasks.setCronJob(cronJob);
//            jobTasks = JobTaskRepo.save(jobTasks);
//            SpiderService spiderService = SpringUtil.getBean(cronJob.getJobCode());
//            spiderService.startTask(jobTasks);
//            logger.info(cronJob.getJobName() + " updateDataJob job end ");
//        }
//    }


}
