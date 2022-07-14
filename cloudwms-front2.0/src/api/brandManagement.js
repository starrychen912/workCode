import $axios from '@/request/request'
//分类列表
export function GetBrandlist(data){
  return $axios({
        url:'/api/brand/brandList',
        method:"post",
        data
  })
}

// 添加品牌
export function brandAdd(data) {
    return $axios({
        url: '/api/brand/brandAdd',
        method: "post",
        data: data
    })
}
// 删除品牌
export function brandDelete(data) {
    return $axios({
        url: '/api/brand/brandDelete',
        method: "post",
        data: data
    })
}

// 修改品牌
export function brandUpdate(data) {
    return $axios({
        url: '/api/brand/brandUpdate',
        method: "post",
        data: data
    })
}