package com.ddtech.netspider.jpa.repo;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.repository.NoRepositoryBean;

import java.io.Serializable;
import java.util.List;

/**
 * JPA访问DAO
 *
 * @author Funsonli
 * Date 2019-08-16
 */
@NoRepositoryBean
public interface BaseRepo<E, ID extends Serializable> extends JpaRepository<E, ID>, JpaSpecificationExecutor<E> {


}
