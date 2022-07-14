import { setItem,getItem } from "../../utils/storage";
export default {
    namespaced: true,
    state: {
        shop_id: {} 
    },
    getters:{
        shop_id:(state) => state.shop_id
    },
    mutations:{
        SET_SHOP_ID:(state,data) =>{
          state.shop_id = data
        }
    },
    actions:{
        setShopId({commit},data){
          commit('SET_SHOP_ID',data)
        },
    }
}
