package com.ddtech.netspider.service.whatcoupon;

import com.ddtech.netspider.jpa.entity.whatcoupon.CpCate;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import com.ddtech.netspider.jpa.repo.whatcoupon.CpCateRepo;
import com.ddtech.netspider.service.BaseService;
import com.ddtech.netspider.service.ListDataService;
import com.ddtech.netspider.vo.PageVO;
import org.springframework.beans.factory.annotation.Autowired;

import java.util.List;

public class CpCateService implements ListDataService<CpCate, Long> {

    @Autowired
    private CpCateRepo cpCateRepo;

    @Override
    public BaseRepo<CpCate, Long> getRepo() {
        return cpCateRepo;
    }

}
