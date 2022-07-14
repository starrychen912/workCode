import $axios from '@/request/request'

//新增Amzon商品
export function AddAmzonProduct(data) {
    return $axios({
        url: '/api/product_amazon/addProduct',
        method: "post",
        data: data
    })
}
//新增Amzon商品
export function GetAmzonProductList(data) {
    return $axios({
        url: '/api/product_amazon/productList',
        method: "post",
        data: data
    })
}
//删除Amzon商品
export function DeleteAmzonProduct(data) {
    return $axios({
        url: '/api/product_amazon/deleteOwnerList',
        method: "post",
        data: data
    })
}
//获取Amzon商品详情
export function GetAmzonProductDetail(data) {
    return $axios({
        url: '/api/product_amazon/productDetail',
        method: "post",
        data: data
    })
}
//获取Amzon商品详情
export function UpdateProduct(data) {
    return $axios({
        url: '/api/product_amazon/updateProduct',
        method: "post",
        data: data
    })
}