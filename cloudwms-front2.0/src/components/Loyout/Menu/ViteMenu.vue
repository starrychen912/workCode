<template>
  <el-menu
    :default-active="activePath"
    class="el-menu-vertical-demo"
    :collapse="isCollapse"
    @open="handleOpen"
    @close="handleClose"
    :router="true"
    :unique-opened="true"
  >
    <vite-sub-menu v-for="(item,index) in data.routeslist"  :key="index"  :dataItem="item" :base-path="item.path" :isCollapse="isCollapse"></vite-sub-menu>
  </el-menu>
</template>

<script>
import {  reactive,computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import ViteMenuItem from './ViteMenuItem.vue';
import ViteSubMenu from './ViteSubMenu.vue';
import store from '@/store'
import i18n from '../../../locale';
import router from '../../../router';
import { Filterdata } from '../../../utils/utils';
export default {
    components:{
        ViteSubMenu,
        ViteMenuItem
    },
    props:{
        //PC折叠
        isCollapse:{
            type:Boolean,
            default:false,
        }
    },
    setup(props,context) {
        const { global } = i18n
        const route = useRoute();
        const routers = useRouter();
        const data = reactive({
            routeslist:computed(() => Filterdata(store.state.permission.routes))
        })
        const handleOpen = (key, keyPath) => {
            // console.log(key, keyPath)
        }
        const handleClose = (key, keyPath) => {
            // console.log(key, keyPath)
        }
        function Elmenu(e){
            if(e.index === '/Officialwebsite/Officialwebsite'){ 
                let url = router.resolve({path:e.index,query:{}})
                window.open(url .href, '_blank');
            }else{
                router.push({
                    path:e.index,
                    query:{}
                })
            }
            if(store.state.setting.device.mode == 'mobile'){
                store.commit('setting/SAVE_SETTINGS',{
                    collapse:!store.state.setting.collapse
                })  
            }
        }
        watch(() =>{
            routers.currentRoute.value,(newvalue,oldvalue)=>{
                console.log(newvalue,oldvalue)
            }
        },{immediate:true})
        return {
            handleOpen,
            handleClose,
            data,
            global,
            Elmenu,
            activePath: computed(() => {
                if(router.currentRoute.value.meta && router.currentRoute.value.meta.hidden){
                //     let path =  router.currentRoute.value.path.split('/')
                //     let list = path.splice(path.length-1,1)
                //     let str = ''
                //     path.forEach((el,index)=>{
                //         console.log(index)
                //         str += ('/' + el)
                //     })
                //    console.log(str)
                //    return str;
                    return router.currentRoute.value.meta.activeurl
                }
                return router.currentRoute.value.path
            }),
            mode:computed(() => store.state.setting.device.mode)
        }
    },
    
    methods:{
      GetRouter(){
        
      }
    }
    
}
</script>

<style lang="scss" scoped>

.dark{
    .el-menu-vertical-demo{
        background-color: var(--sidebar-nav-background--color);
    }
}
:deep(.el-sub-menu__title){
    display: flex;
    align-items: center;
}

</style>
