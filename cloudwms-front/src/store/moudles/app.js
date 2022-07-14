import { getItem, setItem, removeItem } from '@/utils/storage' 
export default {
    namespaced: true,
    state: {
        collapse:true,
        device:'mobile',
    },
    mutations:{
        setCollapse(state,data){
            state.collapse = data
        },
        setDevice(state, device) {
            state.device = device
        },
    },
    actions:{
       
    }
}
