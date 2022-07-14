import { setItem,getItem } from "../../utils/storage";


export default {
    namespaced: true,
    state: {
        routers: getItem('routers') || [],
        shoprouters:getItem('ShopRoutes') || {},
        addRouters: [],
        SET_SETTIN_GROUTERS:[]
    },
    mutations:{
        SET_ROUTERS: (state, data) => {
            state.routers = data
        },
        SET_SETTINGROUTERS: (state, data) => {
            state.SET_SETTIN_GROUTERS = data
        },
        SET_SHOPROUTERS:(state,data) =>{
            state.shoprouters = data
        }
    },
    actions:{
        setRouter({ commit },data){
            setItem('routers',data)
            commit('SET_ROUTERS',data)
        },
        setSettingRouter({ commit },data){
            commit('SET_SETTINGROUTERS',data)
        },
        setShopRouters({commit},data){
            setItem('ShopRoutes',data)
            commit('SET_SHOPROUTERS',data)
        }
    }
}
