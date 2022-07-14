package com.ddtech.netspider.task;

import com.ddtech.netspider.core.whatcoupon.WhatCouponDetailService;
import com.ddtech.netspider.core.whatcoupon.WhatCouponListService;
import com.ddtech.netspider.core.whatcoupon.WhatCouponUpdateBandService;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.utils.SftpUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.boot.ApplicationArguments;
import org.springframework.boot.ApplicationRunner;
import org.springframework.core.annotation.Order;
import org.springframework.stereotype.Component;

@Component
@Order(1)
public class WhatCouponTask  implements ApplicationRunner {



    @Autowired
    private WhatCouponDetailService whatCouponDetailService;

    @Autowired
    WhatCouponListService whatCouponListService;

    @Autowired
    WhatCouponUpdateBandService whatCouponUpdateBandService;


    @Value("${resource.download.root}")
    private static String downloadRoot;

    @Override
    public void run(ApplicationArguments args) {

        whatCouponUpdateBandService.startTask();
//        whatCouponDetailService.parserTest();

//        whatCouponListService.parserTest();
//        String url="https://www.weeklyadpro.com/wp-content/uploads/2022/05/Karns-Quality-Foods_0517_0613_7.jpg";
//        try {
//            SftpUtils.upload(url,"/www/wwwroot/spider1");
//        }catch (Exception es){
//            es.printStackTrace();
//        }
//        testSync.startTask(new JobTask());
//        whatCouponDetailService.parserTest();
//        SpiderService spiderService= SpringUtil.getBean("WhatCouponPlatformJsoupService");
//        spiderService.startTask(new CronJob());
    }
}
