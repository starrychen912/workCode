package com.ddtech.netspider.jpa.repo.whatcoupon;


import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.repo.BaseRepo;

import java.util.List;

public interface CpCateRepo extends BaseRepo<CpCate, Long> {
    CpCate findFirstByName(String name);
    CpCate findFirstByNameAndTypeId(String name,Long typeId);
    List<CpCate> findTop10BySyncStatusOrderByCreateDateAsc(Integer syncStatus);
}
