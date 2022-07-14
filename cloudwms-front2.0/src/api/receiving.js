import $axios from '@/request/request'
// 收货列表
export function receivingList(data) {
    return $axios({
        url: '/api/receiving/receivingList',
        method: "post",
        data: data
    })
}
// 详情列表
export function purchaseDetail(data) {
    return $axios({
        url: '/api/receiving/purchaseDetail',
        method: "post",
        data: data
    })
}
// 确认收货
export function purchaseUpdate(data) {
    return $axios({
        url: '/api/receiving/receivingUpdate',
        method: "post",
        data: data
    })
}
// 删除收货
export function deleteReceiving(data) {
    return $axios({
        url: '/api/receiving/deleteReceiving',
        method: "post",
        data: data
    })
}
