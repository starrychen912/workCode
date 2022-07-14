import $axios from '@/request/request'
//新增商品
export function Addproduct(data){
  return $axios({
        url:'/api/productimport/addProduct',
        method:"post",
        data:data
  })
}

//商品调价
export function updateProductPrice(data){
  return $axios({
        url:'/api/productimport/updateProductPrice',
        method:"post",
        data:data
  })
}

// 商品分类
export function GetproductCategoryList(data){
  return $axios({
        url:'/api/productimport/productCategoryList',
        method:"post",
        data:data
  })
}
// 商品标签
export function GetproductTagsList(data){
  return $axios({
        url:'/api/productimport/productTagsList',
        method:"post",
        data:data
  })
}