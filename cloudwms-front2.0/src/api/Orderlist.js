import $axios from '@/request/request'
//删除产品列表的产品
export function Deleteproduct(id){
     return $axios({
          url:'/api/shopifyimpl/delete',
          methods:'POST',
          data:{
            id
          }
      })
}
//产品导入到shopify
export function importToSohpify(data){
  return $axios({
       url:'/api/productimport/importToSohpify',
       method:'POST',
       data
   })
}

// 改变选中图片状态
export function updateImageStatus(data){
  return $axios({
    url:'/api/productimport/updateImageStatus',
        method:'POST',
        data
    })
}
//修改导入列表
export function updateImportList(data){
   return $axios({
     url:'/api/productimport/updateImportList',
     method:'POST',
     data
   })
}