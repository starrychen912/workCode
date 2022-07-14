package com.ddtech.netspider.controller;


import cn.hutool.json.JSONUtil;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import com.ddtech.netspider.jpa.repo.spider.CronJobRepo;
import com.ddtech.netspider.jpa.repo.spider.LinkResourceRepo;
import com.ddtech.netspider.jpa.repo.spider.SiteDomainRepo;
import com.ddtech.netspider.service.spider.JobLogService;
import com.ddtech.netspider.service.spider.JobTaskService;
import org.hibernate.SQLQuery;
import org.hibernate.transform.Transformers;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

import javax.persistence.EntityManager;
import javax.persistence.PersistenceContext;
import javax.persistence.Query;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

@Controller
@RequestMapping("/")
public class IndexController {

    @Autowired
    private CronJobRepo cronJobRepo;

    @Autowired
    private SiteDomainRepo siteDomainRepo;

    @Autowired
    private JobTaskService jobTaskService;

    @Autowired
    private LinkResourceRepo linkResourceRepo;


    @Autowired
    private JobLogService jobLogService;

    @PersistenceContext
    EntityManager em;


    @RequestMapping("/")
    public String index(Model model) {
//        Long siteCount= siteDomainRepo.count();
//        Long jobCount=  cronJobRepo.count();
//        Long resCount = linkResourceRepo.count();
//        Long joblogCount = jobLogService.count();
//
//        model.addAttribute("siteCount",siteCount);
//        model.addAttribute("jobCount",jobCount);
//        model.addAttribute("resCount",resCount);
//        model.addAttribute("joblogCount",joblogCount);
        return "redirect:/index";
    }

    @RequestMapping("/index")
    public String index1(Model model) {
       Long siteCount= siteDomainRepo.count();
       Long jobCount=  cronJobRepo.count();
       Long resCount = linkResourceRepo.count();
       Long joblogCount = jobLogService.count();

       String sql="SELECT TABLE_NAME,TABLE_ROWS FROM information_schema.`TABLES` " +
               "WHERE TABLE_SCHEMA = (SELECT database()) " +
               "ORDER BY TABLE_ROWS DESC";
        Query query = em.createNativeQuery(sql);
        List<Object[]> dataList= query.getResultList();
        List<String> tableList=new ArrayList<>();
        List<Integer> countList=new ArrayList<>();
        for(Object[] obj:dataList){
            tableList.add(obj[0].toString());
            countList.add(Integer.parseInt(obj[1].toString()));
        }

        model.addAttribute("siteCount",siteCount);
        model.addAttribute("jobCount",jobCount);
        model.addAttribute("resCount",resCount);
        model.addAttribute("joblogCount",joblogCount);
        model.addAttribute("tableList", JSONUtil.toJsonStr(tableList));
        model.addAttribute("countList", JSONUtil.toJsonStr(countList));
        return "dashboard";
    }


    @RequestMapping("/siteList")
    public String siteList(Model model) {
        List<SiteDomain> siteDomainList = siteDomainRepo.findAll();

        model.addAttribute("siteDomainList", siteDomainList);
        return "siteList";
    }


//
//
//    @RequestMapping("/jobTasks")
//    public String joblogs(Model model, @ModelAttribute JobTaskVO jobTaskVO) {
////        List<JobTasks> jobTasks = null;
////        if (jobId != null) {
////            jobTasks = jobTasksService.findAllByCronJob(cronJobService.findById(jobId));
////        } else {
////            jobTasks = jobTasksService.findAll();
////        }
////        jobTasksService.findAll();
//        Page<JobTasks> tasksPage= jobTasksService.findByPage(jobTaskVO);
//        model.addAttribute("pageResult", tasksPage);
//        model.addAttribute("queryVO", jobTaskVO);
//        return "jobtasks";
//    }





}
