import $axios from '@/request/request'
//店铺列表
export function ShopList(data) {
    return $axios({
        url: "/api/shop/shopList",
        method: "POST",
        data
    })
}
//添加店铺
export function AddShop(data) {
    return $axios({
        url: "/api/shop/shopAdd",
        method: "POST",
        data
    })
}
//删除店铺
export function deleteShop(data) {
    return $axios({
        url: "/api/shop/shopDelete",
        method: "POST",
        data
    })
}
//修改商品
export function updateShop(data) {
    return $axios({
        url: '/api/shop/shopUpdate',
        method: "post",
        data
    })
}
//店铺详情
export function getShopInfo(data) {
    return $axios({
        url: '/api/shop/shopDetail',
        method: "post",
        data
    })
}