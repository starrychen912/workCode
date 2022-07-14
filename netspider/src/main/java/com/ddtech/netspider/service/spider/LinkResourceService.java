package com.ddtech.netspider.service.spider;



import cn.hutool.core.date.DateUtil;
import cn.hutool.core.util.StrUtil;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import com.ddtech.netspider.jpa.repo.spider.LinkResourceRepo;
import com.ddtech.netspider.service.BaseService;
import com.ddtech.netspider.vo.LinkResVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.lang.Nullable;
import org.springframework.stereotype.Service;

import javax.persistence.criteria.*;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

@Service
public class LinkResourceService implements BaseService<LinkResource,Long> {

    @Autowired
    private LinkResourceRepo linkResourceRepo;

    @Override
    public BaseRepo<LinkResource, Long> getRepo() {
        return linkResourceRepo;
    }


    public Page<LinkResource> findByPage(LinkResVO linkResVO){
        Pageable pageable = PageRequest.of(linkResVO.getPageNumber() - 1, linkResVO.getPageSize());
        return linkResourceRepo.findAll(new Specification<LinkResource>() {
            @Nullable
            @Override
            public Predicate toPredicate(Root<LinkResource> root, CriteriaQuery<?> cq, CriteriaBuilder cb) {

                Path<String> domainName = root.get("domainName");

                Path<String> linkUrl = root.get("linkUrl");
                Path<Date> createAtField = root.get("createDate");
                // 添加您自定义条件

                List<Predicate> list = new ArrayList<>();

                if(linkResVO.getKeyWord()!= null){
                    Predicate onePredicate = cb.like(domainName, "%"+linkResVO.getKeyWord()+"%");
                    Predicate towPredicate = cb.like(linkUrl, "%"+linkResVO.getKeyWord()+"%");

                    list.add(cb.or(onePredicate,towPredicate));
//                    list.add(cb.like(linkUrl, "%"+linkResVO.getKeyWord()+"%"));
                }

                if(StrUtil.isNotBlank(linkResVO.getStartDate()) && StrUtil.isNotBlank(linkResVO.getEndDate())){
                    Date start = DateUtil.parse(linkResVO.getStartDate());
                    Date end = DateUtil.parse(linkResVO.getEndDate());
                    list.add(cb.between(createAtField, start, DateUtil.endOfDay(end)));
                }

                Predicate[] arr = new Predicate[list.size()];
                cq.where(list.toArray(arr));
                cq.orderBy(cb.desc(createAtField));
                return cq.getRestriction();
            }
        }, pageable);

    }
}
