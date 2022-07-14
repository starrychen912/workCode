import { flyroutelist } from "../../utils/utils"
export default {
    state:{
        shopflyroutelist:[] 
    },
    getters:{
        flyroutelist:(state) => state.flyroutelist || flyroutelist()
    },
    mutations:{
        FLY_ROUTE_LIST:(state,item) =>{
            state.shopflyroutelist = item
        }
    },
    actions:{
        Getshopflyroutelist({commit},item){
            commit('FLY_ROUTE_LIST',item)
        } 
    }
}