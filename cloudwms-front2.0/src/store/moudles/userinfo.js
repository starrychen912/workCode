import { getAccessToken,setAccessToken,RemoveAccessToken } from "@/utils/AccessToken"
import { getUserinfo ,setUserinfo,setAuthentication,getAuthentication,removeUserinfo,RemoveAuthentication} from "@/utils/userinfo";
import { ElMessage, ElNotification } from 'element-plus';

export default {
    namespaced: true,
    state: {
        accessToken: getAccessToken(),
        userinfo:getUserinfo(),
        username: '',
        avatar: '',
        permissions: [],
        Authentication:getAuthentication() || false,
        roles:[],
    },
    getters:{
        accessToken:(state) => state.accessToken,
        username:(state) => state.username,
        avatar:(state) =>  state.avatar,
        permissions: (state) => state.permissions,
        userinfo:(state) => state.userinfo,
        Authentication:(state) => state.Authentication,
        roles:(state) => state.roles,
    },
    mutations:{
        setAccessToken(state,accessToken){
             state.accessToken = accessToken
             setAccessToken(accessToken);
        },
        setUsername(state,username){
            state.username = username
        },
        setAvatar(state,avatar){
            state.avatar = avatar
        },
        setUserinfo(state,userinfo){
            state.userinfo = userinfo
            setUserinfo(userinfo);
        },
        setAuthentication(state,Authentication){
            state.Authentication = Authentication
            setAuthentication(Authentication)
        },
        Set_Roles(state,roles){
            state.roles = roles
        }
    },
    actions:{
        async login({commit},userinfo){
            const accessToken = userinfo['token'];
            if(accessToken){
                commit('setAccessToken',accessToken)
                commit('setUserinfo',userinfo)
                commit('setAuthentication',true)
                // const hour = new Date().getHours();
                // const thisTime =
                //     hour < 8
                //     ? global.t('Hello.early')
                //     : hour <= 11
                //     ? global.t('Hello.morning')
                //     : hour <= 13
                //     ? global.t('Hello.noon')
                //     : hour < 18
                //     ? global.t('Hello.afternoon')
                //     : global.t('Hello.evening');
                
                ElNotification({
                    title: '??????',
                    message: '????????????',
                    type: 'success',
                });
                
            }
        },
        async loginout({dispatch}){
            await dispatch('resetAccessToken');
        },
        resetAccessToken({ commit }) {
            commit('setAccessToken', '');
            commit('setUserinfo','');
            commit('setAuthentication','')
            
            RemoveAuthentication();
            removeUserinfo();
            RemoveAccessToken();
        },
        getinfo({commit}){
           return new Promise((resolve,reject) =>{
               let data = ['editor']
               commit('Set_Roles',data)
               resolve(data)
           }).catch(error =>{
               reject(error)
           })
        }
    }
}
