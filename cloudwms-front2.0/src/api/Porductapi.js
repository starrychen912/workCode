import $axios from '@/request/request'
//获取商品
export function GetProductlist(data) {
    return $axios({
        url: '/api/productimport/produtList',
        method: 'POST',
        data
    })
}
//添加导入商品
export function addToImportList(data) {
    return $axios({
        url: '/api/productimport/addToImportList',
        method: 'POST',
        data
    })
}
//删除导入商品
export function DeleteImportList(data) {
    return $axios({
        url: '/api/productimport/deleteImportList',
        method: 'POST',
        data
    })
}
//已导入产品列表
export function GetshopifyProdutList(data) {
    return $axios({
        url: '/api/productimport/shopifyProdutList',
        method: 'POST',
        data
    })
}
//商品店铺导入亚马逊
export function importToSohpifyDirect(data) {
    return $axios({
        url: '/api/productimport/importToSohpifyDirect',
        method: 'POST',
        data
    })
}
//shoppify导入到本地
export function importToLocalDirect(data) {
    return $axios({
        url: '/api/productimport/importToLocalDirect',
        method: 'POST',
        data
    })
}

//同步商品
export function LoadPorduct(data) {
    return $axios({
        url: '/api/productimport/shopifyProductLoad',
        method: 'POST',
        data
    })
}
// 删除产品
export function deleteOwnerProduct(data) {
    return $axios({
        url: '/api/product/deleteOwnerList',
        method: 'POST',
        data
    })
}
//删除商品
export function deleteOwnerList(data) {
    return $axios({
        url: '/api/productimport/deleteOwnerList',
        method: 'POST',
        data
    })
}
//删除店铺商品
export function deleteShopProduct(data) {
    return $axios({
        url: '/api/productimport/deleteShopProduct',
        method: 'POST',
        data
    })
}
//供应商
export function getSupplierList() {
    return $axios({
        url: '/api/inventory/getSupplierList',
        method: 'POST'
    })
}
//商品城市
export function getCountryList() {
    return $axios({
        url: '/api/inventory/getCountryList',
        method: 'POST'
    })
}

//产品列表
export function GetProductList(data) {
    return $axios({
        url: '/api/product/productList',
        method: 'POST',
        data
    })
}