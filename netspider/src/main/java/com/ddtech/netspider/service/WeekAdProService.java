package com.ddtech.netspider.service;


import com.ddtech.netspider.jpa.entity.marketscoupon.McStore;
import com.ddtech.netspider.jpa.entity.marketscoupon.McWeekAds;
import com.ddtech.netspider.jpa.repo.marketscoupon.McStoreRepo;
import com.ddtech.netspider.jpa.repo.marketscoupon.McWeekAdsRepo;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class WeekAdProService {

    Logger logger = LoggerFactory.getLogger(WeekAdProService.class);

    @Autowired
    private McStoreRepo mcStoreRepo;

    @Autowired
    private McWeekAdsRepo mcWeekAdsRepo;



    public McWeekAds saveAd(McWeekAds weekAdBean) {

        try {
            logger.info("save WeekAds:"+weekAdBean.toString());
            return mcWeekAdsRepo.save(weekAdBean);
        } catch (Exception es) {
            logger.error("save WeekAds error:"+es.getMessage());
            return null;
        }
    }


    public McWeekAds findAdByTitle(String title) {

        try {
            logger.info("findAdByTitle title:"+title);
            return mcWeekAdsRepo.findWeekAdsByTitle(title);
        } catch (Exception es) {
            logger.error("findAdByTitle error:"+es.getMessage()+" title:"+title);
            return new McWeekAds();
        }
    }

    public McStore saveStore(McStore mcStore) {

        try {
            logger.info("save store:"+ mcStore.toString());
            return mcStoreRepo.save(mcStore);
        } catch (Exception es) {
            logger.error("save store error:"+es.getMessage());
            return null;
        }
    }

    public McStore findStoreByName(String storeName) {
        return mcStoreRepo.findStoreByStoreName(storeName);
    }
}
