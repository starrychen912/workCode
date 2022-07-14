package com.ddtech.netspider.jpa.entity.spider;


import com.ddtech.netspider.jpa.entity.BaseEntity;
import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.ToString;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.util.Date;
import java.util.List;

@Data
@Entity(name = "sp_cron_jobs")
@EntityListeners(AuditingEntityListener.class)
public class CronJob extends BaseEntity {


    @ManyToOne
    public SiteDomain siteDomain;

    public String jobName;
    public String jobCode;
    public String jobType;
    public String remark;

    @ToString.Exclude
    @JsonIgnore
    @OneToMany(fetch = FetchType.LAZY,mappedBy ="cronJob")
    private List<JobTask> jobTasks;



}
