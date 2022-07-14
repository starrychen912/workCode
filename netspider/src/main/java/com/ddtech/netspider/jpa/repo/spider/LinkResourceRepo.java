package com.ddtech.netspider.jpa.repo.spider;



import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.repo.BaseRepo;


import java.util.List;

public interface LinkResourceRepo extends BaseRepo<LinkResource, Long> {

    List<LinkResource> findTop5ByLinkTypeAndStatus(String linkType, String status);

    LinkResource findFirstByLinkTypeAndStatus(String linkType, String status);

    LinkResource findFirstByDomainNameAndLinkTypeAndStatus(String domain, String linkType, String status);

    List<LinkResource> findTop5ByDomainNameAndResourceTypeAndStatus(String domain, String resType, String status);

    List<LinkResource> findTop10ByDomainNameAndResourceTypeAndStatus(String domain, String resType, String status);

    List<LinkResource> findTop2ByDomainNameAndResourceTypeAndStatus(String domain, String resType, String status);

    LinkResource findFirstByLinkUrl(String linkUrl);

//
//    @Query("SELECT new map( count(1) as totalCount,a.status as status) FROM linkResources a where a.cronJob=?1 group by a.status order by totalCount desc")
//    List<Map<Integer,String>> getStatusGroup(CronJob cronJob);
}
