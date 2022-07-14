package com.ddtech.netspider.service;

import com.ddtech.netspider.jpa.entity.BaseEntity;
import com.ddtech.netspider.jpa.repo.BaseRepo;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.domain.Specification;

import java.io.Serializable;
import java.util.Date;
import java.util.List;

/**
 * 基础Service，包含一些通用的方法
 *
 * @author Funsonli
 * @date 2019/10/31
 */
public interface BaseService<E extends BaseEntity, ID extends Serializable> {
    @Autowired
    BaseRepo<E, ID> getRepo();

//    E beforeSave(E entity);

    default E save(E entity) {
//        entity = beforeSave(entity);
        return getRepo().save(entity);
    }

    default Iterable<E> saveAll(Iterable<E> entities) {
        for (E e : entities) {
//            e = beforeSave(e);
        }
        return getRepo().saveAll(entities);
    }

//    default E beforeSaveDefault(E entity) {
//        if (entity.getId() == null) {
//            entity.setId(String.valueOf(SnowFlake.getInstance().nextId()));
//        }
//
//        if (entity.getStatus() == null) {
//            entity.setStatus(CommonConstant.STATUS_ENABLE);
//        }
//        if (entity.getCreateDate() == null) {
//            entity.setCreateDate(new Date());
//        }
//        if (entity.getLastModifiedDate() == null) {
//            entity.setLastModifiedDate(new Date());
//        }
//        if (entity.getCreatedBy() == null) {
//            entity.setCreatedBy("");
//        }
//        if (entity.getUpdatedBy() == null) {
//            entity.setUpdatedBy("");
//        }
//        return entity;
//    }

    default E saveAndFlush(E entity) {

        return getRepo().saveAndFlush(entity);
    }


    default E update(E entity) {

        return getRepo().saveAndFlush(entity);
    }

    default void delete(ID id) {
        if (getRepo().existsById(id)) {
            getRepo().deleteById(id);
        }
    }


    default void delete(E entity) {
        getRepo().delete(entity);
    }

    default long count() {
        return getRepo().count();
    }

    default long count(Specification<E> specification) {
        return getRepo().count(specification);
    }

    default List<E> findAll() {
        return getRepo().findAll();
    }

    default E findById(ID id) {
        return getRepo().findById(id).orElse(null);
    }

    default Page<E> findAll(Pageable pageable){
        return getRepo().findAll(pageable);
    }

    default Page<E> findAll(Specification<E> specification, Pageable pageable) {
        return getRepo().findAll(specification, pageable);
    }

    default void flush() {
        getRepo().flush();
    }
}
