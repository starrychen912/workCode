import $axios from '@/request/request'
import { time } from 'echarts'
import { url } from 'stylus'

export function get(url,method,param){
    // return $axios.get(url,{
    //     paramt:data
    // })
    return $axios({
        method,
        url,
        params:param
    })
}

export function Post(url,method,data){
    return $axios({
        method,
        url,
        data:data
    })
    // return $axios.post(url,data,{timeout:1000})
}

