import $axios from '@/request/request'
//出库列表
export function outboundList(data) {
    return $axios({
        url: '/api/outbound/outboundList',
        method: "post",
        data: data
    })
}
//出库详情
export function outboundDetail(data) {
    return $axios({
        url: '/api/outbound/inboundDetail',
        method: "post",
        data: data
    })
}
//出库状态
export function outboundCheck(data) {
    return $axios({
        url: '/api/outbound/outboundCheck',
        method: "post",
        data: data
    })
}

//确认出库
export function outboundRefuse(data) {
    return $axios({
        url: '/api/outbound/outboundRefuse',
        method: "post",
        data: data
    })
}

//删除出库
export function deleteOutbound(data) {
    return $axios({
        url: '/api/outbound/deleteOutbound',
        method: "post",
        data: data
    })
}