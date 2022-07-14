import $axios from '@/request/request'
//获取统计
export function GetStatistics(data){
  return $axios({
       url:'/api/order/Statistics',
       method:"post",
       data
  })
}
