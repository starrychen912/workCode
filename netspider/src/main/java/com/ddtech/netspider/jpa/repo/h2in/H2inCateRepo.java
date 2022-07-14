package com.ddtech.netspider.jpa.repo.h2in;



import com.ddtech.netspider.jpa.entity.h2in.H2inCate;
import org.springframework.data.jpa.repository.JpaRepository;

public interface H2inCateRepo extends JpaRepository<H2inCate, Long> {
    public H2inCate findFirstByName(String name);
   
}
