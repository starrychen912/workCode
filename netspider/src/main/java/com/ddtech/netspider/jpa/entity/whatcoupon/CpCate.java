package com.ddtech.netspider.jpa.entity.whatcoupon;


import com.ddtech.netspider.jpa.entity.SyncEntity;
import com.ddtech.netspider.utils.SqlUtils;
import lombok.Data;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.math.BigDecimal;


@Data
@Entity(name = "cp_cate")
@EntityListeners(AuditingEntityListener.class)
@Table(uniqueConstraints = @UniqueConstraint(columnNames= {"name","typeId"}))
public class CpCate extends SyncEntity {


    public Long pid;
    public Long typeId;
    public String name;
    public BigDecimal rate=new BigDecimal(0);
    public int rateCount=0;
    public String image="";
    public Long createtime;
    public Long updatetime;
    public Long deletetime;


    public String getInsertSql(){
        StringBuffer sqlBuffer=new StringBuffer(" insert into cp_cate(name,type_id,rate,rate_count,image) ");
        sqlBuffer.append(" values('"+SqlUtils.filterSqlString(getName())+"',");
        sqlBuffer.append(getTypeId()+",");
        sqlBuffer.append(getRate()+",");
        sqlBuffer.append(getRateCount()+",");
        sqlBuffer.append("'"+getImage()+"')");

        return sqlBuffer.toString();

    };



}
