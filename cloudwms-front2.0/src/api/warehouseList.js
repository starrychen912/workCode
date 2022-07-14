import $axios from '@/request/request'
//仓库列表
export function GetwarehouseList(data) {
    return $axios({
        url: '/api/warehouse/warehouseList',
        method: 'POST',
        data
    })
}
// 新增仓库
export function warehouseAdd(data) {
    return $axios({
        url: '/api/warehouse/warehouseAdd',
        method: 'POST',
        data
    })
}