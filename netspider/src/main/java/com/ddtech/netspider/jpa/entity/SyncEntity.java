package com.ddtech.netspider.jpa.entity;

import cn.hutool.db.Db;
import cn.hutool.db.DbUtil;
import cn.hutool.db.Entity;
import cn.hutool.db.ds.simple.SimpleDataSource;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.entity.spider.SiteDomain;
import lombok.Data;
import org.hibernate.annotations.CreationTimestamp;
import org.hibernate.annotations.UpdateTimestamp;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import javax.sql.DataSource;
import java.util.Date;
import java.util.List;

@Data
@MappedSuperclass
@EntityListeners(AuditingEntityListener.class)
public abstract class SyncEntity {

    @Id
    @GeneratedValue(strategy= GenerationType.IDENTITY)
    public Long id;

    @OneToOne(optional = true)
    private LinkResource linkResource;

    private Integer syncStatus=0;

    @CreationTimestamp
    @CreatedDate
    private Date createDate;

    @UpdateTimestamp
    @LastModifiedDate
    private Date lastModifiedDate;

    public void syncData(SiteDomain siteDomain) throws Exception {

//        this.setId(null);
        this.setLinkResource(null);
        this.setSyncStatus(null);
        this.setCreateDate(null);
        this.setLastModifiedDate(null);
        Db db=null;
        DataSource ds =null;
        try {
            ds = new SimpleDataSource(siteDomain.getDbUrl(), siteDomain.getDbUser(), siteDomain.getDbPassword());
            db= DbUtil.use(ds);
            db.insert(Entity.parse(this,true,true));
        }catch (Exception es){
            es.printStackTrace();
            throw es;
        }finally {
            if(ds!=null) {
                DbUtil.close(ds);
                ds=null;
            }
            if(db!=null) {
                DbUtil.close(db);
                db=null;
            }
        }

    }


}