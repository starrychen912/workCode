package com.ddtech.netspider.controller;


import cn.hutool.extra.spring.SpringUtil;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import com.ddtech.netspider.service.spider.CronJobService;
import com.ddtech.netspider.service.spider.JobTaskService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;

import javax.servlet.http.HttpServletRequest;
import java.util.List;

@Controller
@RequestMapping("/cronjob")
public class CronJobController {


    @Autowired
    private CronJobService cronJobService;

    @Autowired
    private JobTaskService jobTaskService;


    @RequestMapping("/index")
    public String jobList(HttpServletRequest request, Model model,@ModelAttribute SiteDomain siteDomain) {

        List<CronJob> cronJobList = null;
        if (siteDomain!=null && siteDomain.getId()!=null) {
            cronJobList = cronJobService.findBySiteDomain(siteDomain);

        } else {
            cronJobList = cronJobService.findAll();
        }

        model.addAttribute("cronJobList", cronJobList);

        return "cronjob";
    }


    @RequestMapping("/updateJobstatus")
    public String updateJobstatus(Long jobId, String status) {
        CronJob cronJob = cronJobService.findById(jobId);
        if (cronJob!=null) {
            cronJob.setStatus(status);
            cronJobService.save(cronJob);
        }

        return "redirect:/cronjob/index";
    }

    @RequestMapping("/startJob")
    public String updateJobstatus(Long jobId) {
        CronJob cronJob = cronJobService.findById(jobId);
        if (cronJob!=null) {
            JobTask jobTask = new JobTask();
            jobTask.setCronJob(cronJob);
            jobTask = jobTaskService.save(jobTask);
            SpiderService spiderService = SpringUtil.getBean(cronJob.getJobCode());
            spiderService.startTask(jobTask);
        }

        return "redirect:/cronjob/index";
    }


}
