
import $axios from '@/request/request'

export function GetshopifyProdutList(data){
  return $axios({
      url:"/api/productimport/shopifyProdutList",
      method:'POST',
      data
  })
}