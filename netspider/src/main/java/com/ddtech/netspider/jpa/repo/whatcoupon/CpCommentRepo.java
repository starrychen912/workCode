package com.ddtech.netspider.jpa.repo.whatcoupon;


import com.ddtech.netspider.jpa.entity.whatcoupon.CpComment;
import com.ddtech.netspider.jpa.repo.BaseRepo;

import java.util.List;

public interface CpCommentRepo extends BaseRepo<CpComment, Long> {


    List<CpComment> findTop10BySyncStatusOrderByCreateDateAsc(Integer syncStatus);
}
