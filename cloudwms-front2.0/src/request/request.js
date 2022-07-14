import axios from 'axios';
import { netConfig } from '@/config/net.config';

const { baseURL, contentType, invalidCode, noPermissionCode, requestTimeout, successCode } =
netConfig;
import qs from 'qs';
import store from '@/store/index.js';
import { isNaLL } from '@/utils/utils.js'
import router from '@/router/index.js';
//这个文件你不用管
import { getItem } from '@/utils/storage.js'
import { shoElmessage } from '../utils/Elmessage';

// eslint-disable-next-line no-unused-vars
let tokenLose = true;
/**
 *
 * @description 处理code异常
 * @param {*} code
 * @param {*} msg
 */
axios.defaults.withCredentials = false;

const $axios = axios.create({
    baseURL,
    timeout: requestTimeout,
    headers: {
        'Content-Type': contentType,
    },
});
//请求拦截
$axios.interceptors.request.use(
    (config) => {
        //判断是否有token
        if (store.getters['userinfo/accessToken']) {
            config.headers.token = store.getters['userinfo/accessToken'];
        }
        // console.log(config);
        // if(config.method == 'get'){
        //    config.params['company_id'] = store.getters['userinfo/userinfo'].id;
        // }


        //判断是否有用户信息
        // if(store.getters['userinfo/userinfo'] && config.data){
        //   config.data['company_id'] = store.getters['userinfo/userinfo'].id;
        // }

        //是否为表单请求方式
        if (
            config.data &&
            config.headers['Content-Type'] === 'application/x-www-form-urlencoded;charset=UTF-8'
        )

            config.data = qs.stringify(config.data);
        // console.log(config.data);
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
)


//响应拦截
$axios.interceptors.response.use((response) => {
    return response.data
}, (error) => {
    console.log(error);
    // shoElmessage(true, `响应有问题，原因${error}`, 'error')
    return error;
})

export default $axios;