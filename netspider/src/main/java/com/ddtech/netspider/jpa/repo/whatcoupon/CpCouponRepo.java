package com.ddtech.netspider.jpa.repo.whatcoupon;


import com.ddtech.netspider.jpa.entity.whatcoupon.CpCoupon;
import com.ddtech.netspider.jpa.repo.BaseRepo;

import java.util.List;

public interface CpCouponRepo extends BaseRepo<CpCoupon, Long> {

    List<CpCoupon> findTop50BySyncStatusOrderByCreateDateAsc(Integer syncStatus);

    CpCoupon findFirstByTitle(String title);

    List<CpCoupon> findAllByLinkLikeAndBrandNameIsNullOrderByLastModifiedDateAsc(String link);


}
