import $axios from '@/request/request'
// 物料列表
export function materialList(data) {
    return $axios({
        url: '/api/material/materialList',
        method: "post",
        data: data
    })
}
// 详情物料
export function materialDetail(data) {
    return $axios({
        url: '/api/material/materialDetail',
        method: "post",
        data: data
    })
}
// 添加物料
export function materialAdd(data) {
    return $axios({
        url: '/api/material/materialAdd',
        method: "post",
        data: data
    })
}
// 修改物料
export function materialUpdate(data) {
    return $axios({
        url: '/api/material/materialUpdate',
        method: "post",
        data: data
    })
}
// 删除物料
export function materialDelete(data) {
    return $axios({
        url: '/api/material/materialDelete',
        method: "post",
        data: data
    })
}
