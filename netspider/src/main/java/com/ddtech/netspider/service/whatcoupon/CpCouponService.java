package com.ddtech.netspider.service.whatcoupon;

import com.ddtech.netspider.jpa.entity.whatcoupon.CpCoupon;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCouponRepo;
import com.ddtech.netspider.service.ListDataService;
import org.springframework.beans.factory.annotation.Autowired;

public class CpCouponService implements ListDataService<CpCoupon, Long> {

    @Autowired
    private CpCouponRepo repo;

    @Override
    public BaseRepo<CpCoupon, Long> getRepo() {
        return repo;
    }

}
