package com.ddtech.netspider.jpa.entity.spider;

import cn.hutool.core.util.URLUtil;
import com.ddtech.netspider.jpa.entity.BaseEntity;
import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.ToString;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;


@Data
@Entity(name = "sp_link_resources")
@Table(uniqueConstraints = @UniqueConstraint(columnNames= {"linkUrl"}))
@EntityListeners(AuditingEntityListener.class)
public class LinkResource extends BaseEntity {


    public Long pid;

    @ToString.Exclude
    @JsonIgnore
    @ManyToOne
    public JobTask jobTask;

    public String domainName;
    public String resourceType;
    public String attachedInfo;

    public String linkUrl;
    public String linkType;
    public String linkFlag;
    public String remark;

    public void setLinkUrl(String url){
       this.linkUrl= URLUtil.decode(url);
    }

}
