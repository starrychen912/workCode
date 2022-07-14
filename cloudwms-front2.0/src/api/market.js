import $axios from '@/request/request'
// 市场列表
export function GetmarketList(data) {
    return $axios({
        url: '/api/market/marketList',
        method: 'POST',
        data
    })
}

//添加市场
export function marketAdd(data) {
    return $axios({
        url: '/api/market/marketAdd',
        method: 'POST',
        data
    })
}
//修改市场
export function marketUpdate(data) {
    return $axios({
        url: '/api/market/marketUpdate',
        method: 'POST',
        data
    })
}
//删除市场
export function marketDelete(data) {
    return $axios({
        url: '/api/market/marketDelete',
        method: 'POST',
        data
    })
}