package com.ddtech.netspider.controller;


import com.ddtech.netspider.beans.PageData;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.service.spider.LinkResourceService;
import com.ddtech.netspider.vo.LinkResVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

@Controller
@RequestMapping("/linkres")
public class LinkResourceController {

    @Autowired
    private LinkResourceService linkResourceService;

    @ResponseBody
    @RequestMapping("/list")
    public PageData list(@ModelAttribute LinkResVO linkResVO){
        Page<LinkResource> tasksPage= linkResourceService.findByPage(linkResVO);
        PageData pageData=new PageData();
        pageData.setTotal(tasksPage.getTotalElements());
        pageData.setRows(tasksPage.getContent());
        return pageData;

    }


    @RequestMapping("/index")
    public String list(@ModelAttribute LinkResVO linkResVO, Model model){
        model.addAttribute("queryVO",linkResVO);
        return "linkres";

    }
}
