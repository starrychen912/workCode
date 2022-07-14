package com.ddtech.netspider.service.spider;

import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import com.ddtech.netspider.jpa.repo.spider.CronJobRepo;
import com.ddtech.netspider.service.BaseService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;


@Service
public class CronJobService  implements BaseService<CronJob,Long> {

    @Autowired
    private CronJobRepo cronJobRepo;

    @Override
    public BaseRepo<CronJob, Long> getRepo() {
        return cronJobRepo;
    }

    public List<CronJob> findBySiteDomain(SiteDomain siteDomain){
        return cronJobRepo.findAllBySiteDomain(siteDomain);
    }

}
