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
@Entity(name = "h2in_app")
@EntityListeners(AuditingEntityListener.class)
public class H2inApp extends SyncEntity {


    public String appName;

    public String applogo;

    public String appVersion;

    public String tag;

    public BigDecimal rate=new BigDecimal(0);

    public int reviews=0;

    public String install;

    public String developer;

    public String contentRating;

    @Column(length = 6000)
    public String description;

    @Column(columnDefinition = "text")
    public String reviewContent;

    @Column(columnDefinition = "text")
    public String authorReview;

    @Column(length = 4000)
    public String screenShots;

    public String googleLink;

    public String apkLink;

    public String iosLink;

    @ToString.Exclude
    @JsonIgnore
    @OneToMany(fetch = FetchType.LAZY,mappedBy ="h2inApp")
    public List<H2inAppVersion> h2inAppVersions;


    @ToString.Exclude
    @JsonIgnore
    @OneToMany(fetch = FetchType.LAZY,mappedBy ="h2inApp")
    public List<H2inAppRelation> h2InAppRelations;

}
