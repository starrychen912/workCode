package com.ddtech.netspider.service.spider;

import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import com.ddtech.netspider.jpa.repo.spider.SiteDomainRepo;
import com.ddtech.netspider.service.BaseService;
import org.springframework.beans.factory.annotation.Autowired;

public class SiteDomainService  implements BaseService<SiteDomain,Long> {

    @Autowired
    private SiteDomainRepo siteDomainRepo;


    @Override
    public BaseRepo<SiteDomain, Long> getRepo() {
        return siteDomainRepo;
    }
}
