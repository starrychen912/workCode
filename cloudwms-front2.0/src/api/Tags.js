import $axios from '@/request/request'

//tag列表
export function GetproductTagsList(data) {
    return $axios({
        url: '/api/product_tags/productTagsList',
        method: "post",
        data
    })
}

//tag详情
export function GetproductTagsDetail(data) {
    return $axios({
        url: '/api/product_tags/productTagsDetail',
        method: "post",
        data
    })
}

//添加tag
export function AddproductTags(data) {
    return $axios({
        url: '/api/product_tags/productTagsAdd',
        method: "post",
        data
    })
}
//修改tag
export function UpdateproductTags(data) {
    return $axios({
        url: '/api/product_tags/productTagsUpdate',
        method: "post",
        data
    })
}
//删除tag
export function DeleteproductTags(data) {
    return $axios({
        url: '/api/product_tags/productTagsDelete',
        method: "post",
        data
    })
}