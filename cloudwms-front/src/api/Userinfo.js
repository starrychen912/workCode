import $axios from '@/request/request'
import { getAccessToken } from '../utils/AccessToken'
import { isNaLL } from '../utils/utils'
export function login(data){
    return $axios({
        url:'/api/finderuser/login',
        method:'POST',
        data:data
    })
}
export function Logout(data){
    return $axios({
        url:'/api/finderuser/logout',
        method:'POST',
    })
}
//修改邮箱
export function Changeemail(data){
    return $axios({
        url:'/api/finderuser/changeemail',
        method:'POST',
        data
    })
}
// 重置密码
export function Resetpwd(data){
    return $axios({
        url:'/api/finderuser/resetpwd',
        method:'POST',
    })
}
//获取用户信息
export function getUserInfoByToken(token){
    return $axios({
        url:'/api/finderuser/getUserInfoByToken',
        method:'POST',
        data:{
            token: token || getAccessToken(),
        }
    })
}


