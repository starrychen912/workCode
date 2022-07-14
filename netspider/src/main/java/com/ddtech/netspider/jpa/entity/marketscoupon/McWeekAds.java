package com.ddtech.netspider.jpa.entity.marketscoupon;

import com.ddtech.netspider.jpa.entity.SyncEntity;
import com.ddtech.netspider.utils.SqlUtils;
import lombok.Data;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;

@Entity(name = "mc_week_ads")
@Data
@EntityListeners(AuditingEntityListener.class)
@Table(uniqueConstraints = @UniqueConstraint(columnNames= {"title"}))
public class McWeekAds extends SyncEntity {

    public String title;
    public String titleImg;
    public Long storeId;
    @Column(columnDefinition = "text")
    public String content;
    @Column(length = 6000)
    public String adUrl;
    public String createTime;


    public String getInsertSql(){
        StringBuffer sqlBuffer=new StringBuffer(" insert into mc_week_ads(title,title_img,store_id,content,ad_url,create_date) ");
        sqlBuffer.append(" values('"+ SqlUtils.filterSqlString(getTitle())+"',");
        sqlBuffer.append("'"+SqlUtils.filterSqlString(getTitleImg())+"',");
        sqlBuffer.append("'"+getStoreId()+"',");
        sqlBuffer.append("'"+getContent()+"',");
        sqlBuffer.append("'"+getAdUrl()+"',");
        sqlBuffer.append(getCreateTime()+")");

        return sqlBuffer.toString();

    };

}
