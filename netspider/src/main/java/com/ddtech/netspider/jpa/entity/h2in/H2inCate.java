package com.ddtech.netspider.jpa.entity.h2in;


import com.ddtech.netspider.jpa.entity.BaseEntity;
import com.ddtech.netspider.jpa.entity.SyncEntity;
import lombok.Data;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;

@Data
@Entity(name = "h2in_cate")
@EntityListeners(AuditingEntityListener.class)
@Table(uniqueConstraints = @UniqueConstraint(columnNames= {"name"}))
public class H2inCate extends SyncEntity {

    public Long pid=0L;
    public String icon="";
    public String name="";

}
