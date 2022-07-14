import $axios from '@/request/request'
// 退货列表
export function GetcancelList(data) {
    return $axios({
        url: '/api/cancel/cancelList',
        method: 'POST',
        data
    })
}
// 退货详情
export function cancelDetail(data) {
    return $axios({
        url: '/api/cancel/cancelDetail',
        method: 'POST',
        data
    })
}
// 删除退货
export function deleteCancelList(data) {
    return $axios({
        url: '/api/cancel/deleteCancelList',
        method: 'POST',
        data
    })
}