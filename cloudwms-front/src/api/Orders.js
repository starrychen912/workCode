import $axios from '@/request/request'

export function GetOrderlist(data){
    return $axios({
        url:'/api/order/orderList',
        method:'POST',
        data
    })
}

