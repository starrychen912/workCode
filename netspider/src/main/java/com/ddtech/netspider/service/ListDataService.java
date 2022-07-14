package com.ddtech.netspider.service;

import com.ddtech.netspider.jpa.entity.BaseEntity;
import com.ddtech.netspider.jpa.entity.SyncEntity;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import org.springframework.beans.factory.annotation.Autowired;

import javax.persistence.Entity;
import java.io.Serializable;
import java.util.List;

public interface ListDataService<E extends SyncEntity, ID extends Serializable>{

    @Autowired
    BaseRepo<E, ID> getRepo();

}
