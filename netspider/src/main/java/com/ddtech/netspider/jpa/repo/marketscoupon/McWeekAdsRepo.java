package com.ddtech.netspider.jpa.repo.marketscoupon;


import com.ddtech.netspider.jpa.entity.marketscoupon.McWeekAds;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface McWeekAdsRepo extends JpaRepository<McWeekAds, Long> {

    McWeekAds findWeekAdsByTitle(String title);

    List<McWeekAds> findTop50BySyncStatusOrderByCreateDateAsc(Integer syncStatus);
}
