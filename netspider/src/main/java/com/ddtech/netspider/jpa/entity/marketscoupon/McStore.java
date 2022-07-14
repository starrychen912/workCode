package com.ddtech.netspider.jpa.entity.marketscoupon;

import com.ddtech.netspider.jpa.entity.SyncEntity;
import com.ddtech.netspider.utils.SqlUtils;
import lombok.Data;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import java.util.Date;

import javax.persistence.*;

@Entity(name = "mc_stores")
@Data
@EntityListeners(AuditingEntityListener.class)
@Table(uniqueConstraints = @UniqueConstraint(columnNames= {"storeName"}))
public class McStore extends SyncEntity {


    public String storeName;
    public String storeLogo;
    public String storeLink;
    @Column(columnDefinition = "text")
    public String description;
    public Date createTime;

}
