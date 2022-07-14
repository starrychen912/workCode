import router from '@/router';
import store from '@/store';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import { setting } from './setting.js'
const { loginInterception, progressBar, routesWhiteList, routeAuth } = setting
import { FilterRouter, addRoutes } from '@/utils/utils.js';
// import routes from '../router/routes.js'
import { isNaLL } from '../utils/utils.js';
// import { getUserInfoByToken } from '../api/Userinfo.js';

NProgress.configure({
    easing: 'ease',
    speed: 500,
    trickleSpeed: 200,
    showSpinner: false,
});
router.beforeEach(async(to, from, next) => {
    //判断是否要进度条
    if (progressBar) {
        NProgress.start();
    }
    //链接token是否存在
    // if (isNaLL(to.query.token) && (to.path.indexOf('/index/home') != -1 || to.path.indexOf('/shop/shophome') != -1)) {
    //     store.commit('userinfo/setAccessToken', to.query.token)
    //     store.commit('userinfo/setAuthentication', false)

    //     //防止没有删除缓存跨度
    //     await getUserInfoByToken(to.query.token).then(res => {
    //         if (res.code == 1) {
    //             store.commit('userinfo/setUserinfo', res.data)
    //         }
    //     })
    // }

    //获取token
    let UseToken = store.getters['userinfo/accessToken'];
    let Useinfo = store.getters['userinfo/userinfo']

    //不验证token
    if (loginInterception) { UseToken = true };

    if (UseToken) {
        //直接登录没有用户信息在来请求的
        if (!isNaLL(Useinfo)) {
            // await getUserInfoByToken().then(res => {
            //     if (res.code == 1) {
            //         store.commit('userinfo/setUserinfo', res.data)
            //     }
            // })
            next();
        }
        //最高级获取角色
        let routeAuth = store.getters['userinfo/roles'] && store.getters['userinfo/roles'].length > 0
            //先判断角色
        if (routeAuth) {
            if (to.path == '/logins') {
                next({ path: '/' })
            } else {
                next()
            }
        } else {
            //获取用户角色
            const roles = await store.dispatch('userinfo/getinfo')
                //获取所在的路由
            const accessRoutes = await store.dispatch('permission/generateRoutes', roles);

            //动态添加路由
            addRoutes(accessRoutes)
                //重定向
            next({...to, replace: true });
        }
    } else {
        //判断router白名单
        if (routesWhiteList.indexOf(to.path) != -1) {
            next();
        } else {
            if (to.path == '/logins') {
                next();
            } else {
                next({ path: '/logins' });
            }
        }
    }
    if (progressBar) {
        NProgress.done();
    }
})

//前置后置钩子
router.afterEach((to, from) => {
    console.log('afterEach钩子');
})