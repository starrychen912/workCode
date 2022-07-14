package com.ddtech.netspider.jpa.repo.marketscoupon;


import com.ddtech.netspider.jpa.entity.marketscoupon.McStore;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface McStoreRepo extends JpaRepository<McStore, Long> {

    McStore findStoreByStoreName(String storeName);

    List<McStore> findTop10BySyncStatusOrderByCreateDateAsc(Integer syncStatus);
}
