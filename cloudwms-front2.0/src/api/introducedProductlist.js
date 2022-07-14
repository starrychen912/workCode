import $axios from '@/request/request'
//
export function Porductlist(data) {
    return $axios({
        url: '/api/productimport/getImportList',
        method: "post",
        data
    })
}