package com.ddtech.netspider.jpa.entity.spider;


import com.ddtech.netspider.jpa.entity.BaseEntity;
import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.ToString;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;

@Data
@Entity(name = "sp_job_logs")
@EntityListeners(AuditingEntityListener.class)
public class JobLog extends BaseEntity {


    @ManyToOne
    private JobTask jobTask;

    private String jobStatus;

    @Column(columnDefinition = "text")
    private String jobLog;

    @ManyToOne
    private LinkResource linkResource;


}
