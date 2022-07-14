import $axios from '@/request/request'
//获取商品类型
export function AddproductCategory(data) {
    return $axios({
        url: '/api/product_category/productCategoryAdd',
        method: 'POST',
        data
    })
}
//商品类型修改
export function UpdatePorductType(data) {
    return $axios({
        url: '/api/product_category/productCategoryUpdate',
        method: 'POST',
        data
    })
}
//删除商品类型
export function DeleteCategoryid(data) {
    return $axios({
        url: '/api/product_category/productCategoryDelete',
        method: 'POST',
        data
    })
}
export function GetproductCategoryDetail(data) {
    return $axios({
        url: '/api/product_category/productCategoryDetail',
        method: "POSt",
        data
    })
}