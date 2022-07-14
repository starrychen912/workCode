import $axios from '@/request/request'
//获取验证码
export function Findersend(data) {
    return $axios({
        url: '/api/ems/findersend',
        method: 'POST',
        data: data
    })
}

//验证验证码
export function Findercheck(data) {
    return $axios({
        url: '/api/ems/findercheck',
        method: 'POST',
        data: data
    })
}
//注册账号
export function SetRegister(data) {
    return $axios({
        url: '/api/user/register',
        method: 'POST',
        data: data
    })
}