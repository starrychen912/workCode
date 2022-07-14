package com.ddtech.netspider.jpa.entity.whatcoupon;


import com.ddtech.netspider.jpa.entity.SyncEntity;
import com.ddtech.netspider.utils.SqlUtils;
import lombok.Data;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.math.BigDecimal;

@Data
@Entity(name = "cp_coupon")
@EntityListeners(AuditingEntityListener.class)
@Table(uniqueConstraints = @UniqueConstraint(columnNames= {"title"}))
public class CpCoupon extends SyncEntity {


    @Column(unique=true)
    public String title;

    @Column(columnDefinition = "text")
    public String content;
    public String currency;
    public String type;
    public String dealPrice;
    public String dealExtraDetails;
    public String oldListPrice;

    @Column(length = 6000)
    public String images;


    @Column(length = 4000)
    public String link;
    public Long cateId;
    public String cateName;
    public Long brandId;
    public String brandName;
    public Long platformId;
    public String platformName;
    public String status;
    public Long userId;


    public int count;
    public int praise;
    public int views;
    
    public Long createtime;
    public Long updatetime;
    public Long deletetime;


    public String getInsertSql(){
        StringBuffer sqlBuffer=new StringBuffer(" insert into cp_coupon(title,content,deal_price,deal_extra_details,old_list_price,images,link,cate_Id,cate_name,count,praise,views) ");
        sqlBuffer.append(" values('"+SqlUtils.filterSqlString(getTitle())+"',");
        sqlBuffer.append("'"+SqlUtils.filterSqlString(getContent())+"',");
        sqlBuffer.append("'"+getDealPrice()+"',");
        sqlBuffer.append("'"+getDealExtraDetails()+"',");
        sqlBuffer.append("'"+getOldListPrice()+"',");
        sqlBuffer.append("'"+getImages()+"',");
        sqlBuffer.append("'"+getLink()+"',");
        sqlBuffer.append(getCateId()+",");
        sqlBuffer.append("'"+getCateName()+"',");
        sqlBuffer.append(getCount()+",");
        sqlBuffer.append(getPraise()+",");
        sqlBuffer.append(getViews()+")");

        return sqlBuffer.toString();

    };




}
