package com.ddtech.netspider.jpa.entity.spider;


import com.ddtech.netspider.jpa.entity.BaseEntity;
import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.ToString;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.util.List;

@Data
@Entity(name = "sp_job_tasks")
@EntityListeners(AuditingEntityListener.class)
public class JobTask extends BaseEntity {



    @ManyToOne
    private CronJob cronJob;

    @ToString.Exclude
    @JsonIgnore
    @OneToMany(fetch = FetchType.LAZY,mappedBy ="jobTask")
    private List<JobLog> jobLogs;


}
