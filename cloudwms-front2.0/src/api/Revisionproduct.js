
import $axios from '@/request/request'
//修改商品
export function UpdateProduct(data){
  return $axios({
      url:"/api/productimport/updateProduct",
      method:'POST',
      data
  })
}