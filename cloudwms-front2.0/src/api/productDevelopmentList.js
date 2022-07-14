import $axios from '@/request/request'
//获取产品研发列表
export function GetproductDevelopmentList(data) {
    return $axios({
        url: '/api/product_development/productDevelopmentList',
        method: 'POST',
        data
    })
}
//获取产品研发详情
export function GetproductDetail(data) {
    return $axios({
        url: '/api/product_development/productDetail',
        method: 'POST',
        data
    })
}
//添加产品研发
export function AddProductDevelopment(data) {
    return $axios({
        url: '/api/product_development/addProductDevelopment',
        method: 'POST',
        data
    })
}
//修改产品研发
export function UpdateProductDevelopment(data) {
    return $axios({
        url: '/api/product_development/updateProductDevelopment',
        method: 'POST',
        data
    })
}
//删除产品研发
export function DeleteProductDevelopment(data) {
    return $axios({
        url: '/api/product_development/deleteProductDevelopment',
        method: 'POST',
        data
    })
}