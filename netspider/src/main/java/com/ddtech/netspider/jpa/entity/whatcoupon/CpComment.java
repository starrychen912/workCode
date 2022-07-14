package com.ddtech.netspider.jpa.entity.whatcoupon;


import com.ddtech.netspider.jpa.entity.SyncEntity;
import com.ddtech.netspider.utils.SqlUtils;
import lombok.Data;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;

@Data
@Entity(name = "cp_comment")
@EntityListeners(AuditingEntityListener.class)
public class CpComment extends SyncEntity {
     //Need run sql: ALTER TABLE cp_comment DEFAULT CHARACTER SET utf8mb4;

    public Long cid;
    public Long uid;

    @Column(length = 6000)
    public String comment;
    public Long pid;
    
    public Long createtime;
    public Long updatetime;
    public Long deletetime;


    public String getInsertSql(){
        StringBuffer sqlBuffer=new StringBuffer(" insert into cp_comment(cid,uid,comment) ");
        sqlBuffer.append(" values("+getCid()+",");
        sqlBuffer.append(getUid()+",");
        sqlBuffer.append("'"+SqlUtils.filterSqlString(getComment())+"')");

        return sqlBuffer.toString();

    };

}
