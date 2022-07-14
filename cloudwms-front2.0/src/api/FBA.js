import $axios from '@/request/request'

//获取FBA列表
export function fbaList(data) {
    return $axios({
        url: '/api/fulfillment_by_amazon/fbaList',
        method: "post",
        data
    })
}
//获取FBA详情
export function fbaDetail(data) {
    return $axios({
        url: '/api/fulfillment_by_amazon/fbaDetail',
        method: "post",
        data
    })
}
//添加FBA计划
export function fbaPlanAdd(data) {
    return $axios({
        url: '/api/fulfillment_by_amazon/fbaPlanAdd',
        method: "post",
        data
    })
}
//添加FBA
export function fbaAdd(data) {
    return $axios({
        url: '/api/fulfillment_by_amazon/fbaAdd',
        method: "post",
        data
    })
}
//删除FBA
export function deletefba(data) {
    return $axios({
        url: '/api/fulfillment_by_amazon/deletefba',
        method: "post",
        data
    })
}