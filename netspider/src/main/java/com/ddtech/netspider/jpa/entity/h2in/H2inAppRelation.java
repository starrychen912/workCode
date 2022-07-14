package com.ddtech.netspider.jpa.entity.h2in;


import com.ddtech.netspider.jpa.entity.SyncEntity;
import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.ToString;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.math.BigDecimal;
import java.util.List;

@Data
@Entity(name = "h2in_app_relation")
@EntityListeners(AuditingEntityListener.class)
public class H2inAppRelation extends SyncEntity {


    public String relationType;

    @ManyToOne
    public H2inApp h2inApp;

    @ManyToOne
    public H2inApp h2inAppSimilar;


}
