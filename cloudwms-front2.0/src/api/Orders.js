import $axios from '@/request/request'
// 订单列表
export function orderList(data) {
    return $axios({
        url: '/api/order/orderList',
        method: 'POST',
        data
    })
}
// 订单详情
export function orderDetail(data) {
    return $axios({
        url: '/api/order/orderDetail',
        method: 'POST',
        data
    })
}
//添加订单
export function deliverOrder(data) {
    return $axios({
        url: '/api/order/deliverOrder',
        method: 'POST',
        data
    })
}
//修改订单
export function cancelOrder(data) {
    return $axios({
        url: '/api/order/cancelOrder',
        method: 'POST',
        data
    })
}
//删除订单
export function deleteOrderList(data) {
    return $axios({
        url: '/api/order/deleteOrderList',
        method: 'POST',
        data
    })
}
//关联事务
export function withTransaction(data) {
    return $axios({
        url: '/api/order/withTransaction',
        method: 'POST',
        data
    })
}