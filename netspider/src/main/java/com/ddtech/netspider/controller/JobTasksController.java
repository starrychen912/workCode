package com.ddtech.netspider.controller;


import com.ddtech.netspider.beans.PageData;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.service.spider.JobTaskService;
import com.ddtech.netspider.vo.JobTaskVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
@RequestMapping("/jobtasks")
public class JobTasksController {

    @Autowired
    private JobTaskService jobTaskService;

    @ResponseBody
    @RequestMapping("/list")
    public PageData list(@ModelAttribute JobTaskVO jobTaskVO){
        Page<JobTask> tasksPage= jobTaskService.findByPage(jobTaskVO);
        PageData pageData=new PageData();
        pageData.setTotal(tasksPage.getTotalElements());
        pageData.setRows(tasksPage.getContent());
        return pageData;

    }


    @RequestMapping("/index")
    public String list(@ModelAttribute JobTaskVO jobTaskVO, Model model){
        model.addAttribute("queryVO",jobTaskVO);
        return "jobtasks";

    }
}
