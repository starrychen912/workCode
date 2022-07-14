package com.ddtech.netspider.service.whatcoupon;

import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.entity.whatcoupon.CpComment;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCateRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCommentRepo;
import com.ddtech.netspider.service.ListDataService;
import org.springframework.beans.factory.annotation.Autowired;

public class CpCommentService implements ListDataService<CpComment, Long> {

    @Autowired
    private CpCommentRepo repo;

    @Override
    public BaseRepo<CpComment, Long> getRepo() {
        return repo;
    }

}
