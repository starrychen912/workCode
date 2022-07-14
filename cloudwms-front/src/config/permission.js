import router from '@/router';
import store from '@/store';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import {setting} from './setting.js'
const { loginInterception ,progressBar,routesWhiteList} = setting
import {FilterRouter} from '@/utils/utils.js';
import routes from '../router/routes.js'
import { isNaLL } from '../utils/utils.js';
import { getUserInfoByToken } from '../api/Userinfo.js';


NProgress.configure({
    easing: 'ease',
    speed: 500,
    trickleSpeed: 200,
    showSpinner: false,
});

router.beforeResolve((to,from ,next) => {
    
    FilterRouter(routes,store).then(res=>{
        if(progressBar){
            NProgress.start();
        }
        //链接token是否存在
        if(isNaLL(to.query.token) && (to.path.indexOf('/index/home') != -1 || to.path.indexOf('/shop/shophome') != -1) ){
            store.commit('userinfo/setAccessToken',to.query.token)
            store.commit('userinfo/setAuthentication',false)

            //防止没有删除缓存跨度
            getUserInfoByToken(to.query.token).then(res =>{
                if(res.code == 1){
                    store.commit('userinfo/setUserinfo',res.data)
                }
            })
        }

        
        //获取token
        let UseToken = store.getters['userinfo/accessToken'];
        let Useinfo = store.getters['userinfo/userinfo']
        
        //不验证token
        if (loginInterception) {UseToken = true};
        
        if(UseToken){
            //直接登录没有用户信息在来请求的
            if(!isNaLL(Useinfo)){
                getUserInfoByToken().then(res =>{
                   if(res.code == 1){
                        store.commit('userinfo/setUserinfo',res.data)
                   }
                })
            }
            //生成路由，项目有点急。路由没有给权限设定
            if(to.path == '/logins'){
                next({ path: '/' });
            }else{
                next();
            }
        }else{
            if(routesWhiteList.indexOf(to.path) != -1){
                next();
            }else{
                if(to.path =='/logins'){
                    next();
                }else{
                    next({path:'/logins'});
                }
            }
        }
        if(progressBar){
            NProgress.done();
        }
    })
})
//前置后置钩子
router.afterEach((to,from) =>{
    console.log('afterEach钩子');
})