package com.ddtech.netspider.jpa.entity.h2in;

import com.ddtech.netspider.jpa.entity.SyncEntity;
import lombok.Data;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.util.Date;


@Data
@Entity(name = "h2in_app_version")
@EntityListeners(AuditingEntityListener.class)
public class H2inAppVersion extends SyncEntity {


    @ManyToOne
    public H2inApp h2inApp;

    public String appVersion;

    public String versionCode;

    public String appType;

    public String fileSize;

    public String packageName;

    public Date updateTime;

    public String sysRequirement;

    public String signature;

    public String downloadUrl;


}
