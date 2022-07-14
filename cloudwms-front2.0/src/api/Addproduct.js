import $axios from '@/request/request'
//新增商品
export function Addproduct(data) {
    return $axios({
        url: '/api/productimport/addProduct',
        method: "post",
        data: data
    })
}

//商品调价
export function updateProductPrice(data) {
    return $axios({
        url: '/api/productimport/updateProductPrice',
        method: "post",
        data: data
    })
}

// 商品分类
export function GetproductCategoryList(data) {
    return $axios({
        url: '/api/productimport/productCategoryList',
        method: "post",
        data: data
    })
}
// 商品标签
export function GetproductTagsList(data) {
    return $axios({
        url: '/api/productimport/productTagsList',
        method: "post",
        data: data
    })
}


//产品分类
export function GetProductCategoryList(data) {
    return $axios({
        url: '/api/product_category/productCategoryList',
        method: "POST",
        data: data
    })
}
//添加产品
export function AddingProduct(data) {
    return $axios({
        url: '/api/product/addProduct',
        method: "POST",
        data
    })
}
//产品详情
export function GetProductDetail(data) {
    return $axios({
        url: '/api/product/productDetail',
        method: "POST",
        data
    })
}
//修改产品
export function UpdateProduct(data) {
    return $axios({
        url: '/api/product/updateProduct',
        method: "POST",
        data
    })
}
//统一事请求
export function GetAllProductlist(item) {
    return $axios({
        url: item.url,
        method: item.method,
        data: item.data,
    })
}