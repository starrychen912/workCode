import $axios from '@/request/request'
//采购列表
export function purchaseList(data) {
    return $axios({
        url: '/api/purchase/purchaseList',
        method: "post",
        data
    })
}

// 采购详情接口
export function purchaseDetail(data) {
    return $axios({
        url: '/api/purchase/purchaseDetail',
        method: "post",
        data
    })
}
// 添加采购订单
export function purchaseAdd(data) {
    return $axios({
        url: '/api/purchase/purchaseAdd',
        method: "post",
        data
    })
}
// 修改采购订单
export function purchaseUpdate(data) {
    return $axios({
        url: '/api/purchase/purchaseUpdate',
        method: "post",
        data
    })
}
// 删除供应商
export function deletePurchaseList(data) {
    return $axios({
        url: '/api/purchase/deletePurchaseList',
        method: "post",
        data
    })
}