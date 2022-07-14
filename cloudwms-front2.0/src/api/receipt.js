import $axios from '@/request/request'
//入库列表
export function inboundList(data) {
    return $axios({
        url: '/api/inbound/inboundList',
        method: "post",
        data: data
    })
}

//入库详情
export function inboundDetail(data) {
    return $axios({
        url: '/api/inbound/inboundDetail',
        method: "post",
        data: data
    })
}

// 添加入库
export function inboundAdd(data) {
    return $axios({
        url: '/api/inbound/inboundAdd',
        method: "post",
        data: data
    })
}
// 确认入库
export function inboundCheck(data) {
    return $axios({
        url: '/api/inbound/inboundCheck',
        method: "post",
        data: data
    })
}


//驳回入库
export function inboundRefuse(data) {
    return $axios({
        url: '/api/inbound/inboundRefuse',
        method: "POST",
        data: data
    })
}
//删除入库
export function deleteInbound(data) {
    return $axios({
        url: '/api/inbound/deleteinbound',
        method: "POST",
        data
    })
}