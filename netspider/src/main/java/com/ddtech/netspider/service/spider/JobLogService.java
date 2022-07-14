package com.ddtech.netspider.service.spider;

import cn.hutool.core.date.DateUtil;
import cn.hutool.core.util.StrUtil;
import com.ddtech.netspider.enums.ResourcesType;
import com.ddtech.netspider.jpa.entity.spider.*;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import com.ddtech.netspider.jpa.repo.spider.CronJobRepo;
import com.ddtech.netspider.jpa.repo.spider.JobLogRepo;
import com.ddtech.netspider.service.BaseService;
import com.ddtech.netspider.vo.JobLogSearchVO;
import com.ddtech.netspider.vo.JobTaskVO;
import org.jsoup.internal.StringUtil;
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
public class JobLogService implements BaseService<JobLog,Long> {

    @Autowired
    private JobLogRepo jobLogRepo;

    @Override
    public BaseRepo<JobLog, Long> getRepo() {
        return jobLogRepo;
    }

    public Page<JobLog> findByPage(JobLogSearchVO searchVO){
        Pageable pageable = PageRequest.of(searchVO.getPageNumber() - 1, searchVO.getPageSize());
        return jobLogRepo.findAll(new Specification<JobLog>() {
            @Nullable
            @Override
            public Predicate toPredicate(Root<JobLog> root, CriteriaQuery<?> cq, CriteriaBuilder cb) {

                Path<String> statusField = root.get("jobStatus");
                Path<Date> createAtField = root.get("createDate");

                Path<String> jobLog = root.get("jobLog");
                // 添加您自定义条件

                Join<JobTask,JobLog> taskJoin=root.join("jobTask",JoinType.INNER);

                Join<CronJob,JobTask> cronJobJobTaskJoin=taskJoin.join("cronJob",JoinType.INNER);

                Join<LinkResource,JobLog> linkJoin=root.join("linkResource",JoinType.INNER);

                Path<ResourcesType> resType=linkJoin.get("resourceType");



                List<Predicate> list = new ArrayList<>();

                if(StrUtil.isNotEmpty(searchVO.getResourcesType())){
                    list.add(cb.equal(resType, searchVO.getResourcesType()));
                }

                if(searchVO.getCronJob()!= null){
                    list.add(cb.equal(cronJobJobTaskJoin, searchVO.getCronJob()));
                }


                if(StrUtil.isNotBlank(searchVO.getJobStatus())){
                    list.add(cb.equal(statusField, searchVO.getJobStatus()));
                }

                if(StrUtil.isNotBlank(searchVO.getKeyWord())){
                    list.add(cb.like(jobLog, '%'+searchVO.getKeyWord()+'%'));
                }


                if(StrUtil.isNotBlank(searchVO.getStartDate()) && StrUtil.isNotBlank(searchVO.getEndDate())){
                    Date start = DateUtil.parse(searchVO.getStartDate());
                    Date end = DateUtil.parse(searchVO.getEndDate());
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
