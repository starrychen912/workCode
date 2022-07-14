import $axios from '@/request/request'

//获取部门列表
export function GetdepartmentList(data) {
    return $axios({
        url: '/api/department/departmentList',
        method: "post",
        data
    })
}

//添加部门列表
export function Adddepartment(data) {
    return $axios({
        url: '/api/department/departmentAdd',
        method: "post",
        data
    })
}

//修改部门列表
export function Updatdepartmente(data) {
    return $axios({
        url: '/api/department/departmentUpdate',
        method: "post",
        data
    })
}

//删除部门列表
export function Deletedepartment(data) {
    return $axios({
        url: '/api/department/departmentDelete',
        method: "post",
        data
    })
}

//部门详情
export function GetdepartmentDetail(data) {
    return $axios({
        url: '/api/department/departmentDetail',
        method: "post",
        data
    })
}