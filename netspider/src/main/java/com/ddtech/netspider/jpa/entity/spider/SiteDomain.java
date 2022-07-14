package com.ddtech.netspider.jpa.entity.spider;


import com.ddtech.netspider.jpa.entity.BaseEntity;
import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.ToString;

import javax.persistence.*;
import java.util.Date;
import java.util.List;

@Data
@Entity(name = "sp_site_domain")

public class SiteDomain extends BaseEntity {

    @Column(unique = true)
    public String domainName;

    public String domainUrl;

    public String description;

    public String dbUrl;

    public String dbUser;

    public String dbPassword;

    @ToString.Exclude
    @JsonIgnore
    @OneToMany(fetch = FetchType.EAGER,mappedBy ="siteDomain")
    public List<CronJob> cronJobs;

}
