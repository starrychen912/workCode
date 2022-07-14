package com.ddtech.netspider.controller;


import cn.hutool.extra.spring.SpringUtil;
import com.ddtech.netspider.beans.PageData;
import com.ddtech.netspider.core.SpiderService;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.JobLog;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import com.ddtech.netspider.service.spider.CronJobService;
import com.ddtech.netspider.service.spider.JobLogService;
import com.ddtech.netspider.service.spider.JobTaskService;
import com.ddtech.netspider.vo.JobLogSearchVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

import javax.servlet.http.HttpServletRequest;
import java.util.List;

@Controller
@RequestMapping("/joblogs")
public class JoblogController {


    @Autowired
    private CronJobService cronJobService;

    @Autowired
    private JobLogService jobLogService;


    @RequestMapping("/index")
    public String jobLog(HttpServletRequest request, Model model) {

        List<CronJob> cronJobs = cronJobService.findAll();
        model.addAttribute("cronJobs", cronJobs);
        model.addAttribute("jobStatus", JobStatus.values());
        model.addAttribute("resourcesTypes", ResourcesType.values());
        return "joblogs";
    }


    @ResponseBody
    @RequestMapping("/list")
    public PageData list(@ModelAttribute JobLogSearchVO jobLogSearchVO) {
        Page<JobLog> tasksPage = jobLogService.findByPage(jobLogSearchVO);
        PageData pageData = new PageData();
        pageData.setTotal(tasksPage.getTotalElements());
        pageData.setRows(tasksPage.getContent());
        return pageData;
    }


}
