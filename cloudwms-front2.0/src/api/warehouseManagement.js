import $axios from '@/request/request'

//仓库列表
export function warehouseList(data){
    return $axios({
          url:'/api/warehouse/warehouseList',
          method:"post",
          data
    })
  }

// 增加仓库
export function warehouseAdd(data){
    return $axios({
          url:'/api/warehouse/warehouseAdd',
          method:"post",
          data
    })
  }

// 删除仓库
export function warehouseDelete(data){
    return $axios({
          url:'/api/warehouse/warehouseDelete',
          method:"post",
          data
    })
  }
// 更新仓库
export function warehouseUpdate(data){
    return $axios({
          url:'/api/warehouse/warehouseUpdate',
          method:"post",
          data
    })
  }
  