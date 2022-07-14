import $axios from '@/request/request'
//分类列表
export function GetSupplierList(data) {
    return $axios({
        url: '/api/supplier/supplierList',
        method: "post",
        data
    })
}

// 新增供应商
export function supplierAdd(data) {
    return $axios({
        url: '/api/supplier/supplierAdd',
        method: "post",
        data
    })
}
// 修改供应商
export function supplierUpdate(data) {
    return $axios({
        url: '/api/supplier/supplierUpdate',
        method: "post",
        data
    })
}
// 删除供应商
export function supplierDelete(data) {
    return $axios({
        url: '/api/supplier/supplierDelete',
        method: "post",
        data
    })
}