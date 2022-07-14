import $axios from '@/request/request'
// 发货列表
export function deliverList(data) {
    return $axios({
        url: '/api/deliver/deliverList',
        method: 'POST',
        data
    })
}
// 发货详情
export function deliverDetail(data) {
    return $axios({
        url: '/api/deliver/deliverDetail',
        method: 'POST',
        data
    })
}
//确认发货
export function outboundCheck(data) {
    return $axios({
        url: '/api/deliver/outboundCheck',
        method: 'POST',
        data
    })
}
//驳回发货
export function deliverRefuse(data) {
    return $axios({
        url: '/api/deliver/deliverRefuse',
        method: 'POST',
        data
    })
}
//删除发货
export function deleteOutbound(data) {
    return $axios({
        url: '/api/deliver/deleteOutbound',
        method: 'POST',
        data
    })
}
