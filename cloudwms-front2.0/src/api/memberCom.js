import $axios from '@/request/request'
export function companyUserList(data) {
    return $axios({
        url: '/api/user/companyUserList',
        method: 'POST',
        data
    })
}
//公司用户详情
export function companyUserDetail(data) {
    return $axios({
        url: '/api/user/companyUserDetail',
        method: 'POST',
        data
    })
}
//公司用户添加
export function companyUserAdd(data) {
    return $axios({
        url: '/api/user/companyUserAdd',
        method: 'POST',
        data
    })
}
//公司用户编辑
export function companyUserUpdate(data) {
    return $axios({
        url: '/api/user/companyUserUpdate',
        method: 'POST',
        data
    })
}
//公司用户删除
export function companyUserDelete(data) {
    return $axios({
        url: '/api/user/companyUserDelete',
        method: 'POST',
        data
    })
}