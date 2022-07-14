package com.ddtech.netspider.service.spider;

import cn.hutool.core.date.DateUtil;
import cn.hutool.core.util.StrUtil;
import com.ddtech.netspider.jpa.entity.spider.CronJob;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import com.ddtech.netspider.jpa.repo.spider.JobTaskRepo;
import com.ddtech.netspider.service.BaseService;
import com.ddtech.netspider.vo.JobTaskVO;
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
public class JobTaskService implements BaseService<JobTask,Long> {


    @Autowired
    private JobTaskRepo jobTaskRepo;

    @Override
    public BaseRepo<JobTask, Long> getRepo() {
        return jobTaskRepo;
    }

    public List<JobTask> findAllByCronJob(CronJob cronJob){
        return jobTaskRepo.findAllByCronJob(cronJob);
    }

    public Page<JobTask> findByPage(JobTaskVO jobTaskVO){
        Pageable pageable = PageRequest.of(jobTaskVO.getPageNumber() - 1, jobTaskVO.getPageSize());
        return jobTaskRepo.findAll(new Specification<JobTask>() {
            @Nullable
            @Override
            public Predicate toPredicate(Root<JobTask> root, CriteriaQuery<?> cq, CriteriaBuilder cb) {

                // 默认搜索条件
//                Path<String> nameField = root.get("name");
//                Path<Integer> typeField = root.get("type");
                Path<CronJob> cronJobField = root.get("cronJob");
                Path<Date> createAtField = root.get("createDate");
                // 添加您自定义条件

                List<Predicate> list = new ArrayList<>();

                if(jobTaskVO.getCronJob()!= null){
                    list.add(cb.equal(cronJobField, jobTaskVO.getCronJob()));
                }

                if(StrUtil.isNotBlank(jobTaskVO.getStartDate()) && StrUtil.isNotBlank(jobTaskVO.getEndDate())){
                    Date start = DateUtil.parse(jobTaskVO.getStartDate());
                    Date end = DateUtil.parse(jobTaskVO.getEndDate());
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
