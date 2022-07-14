<template>
    <el-drawer
                v-model="data.drawer"
                :direction="data.direction"
                :before-close="beforeClose"
                :show-close="false"
                :size="'50%'"
            >
            
        </el-drawer>  
</template>

<script>
import { defineComponent, reactive, ref,computed } from 'vue'
import { useRoute } from 'vue-router'
import routes from '../../../router/routes'
import ViteMenuItem from '../Menu/ViteMenuItem.vue';
import ViteSubMenu from '../Menu/ViteSubMenu.vue';
import store from '@/store'
import {FilterRouter} from '@/utils/utils';

export default defineComponent({
    components:{
        ViteSubMenu,
        ViteMenuItem
    },
    props:{
        
    },
    created(){

    },
    setup(props,context) {

        const route = useRoute();
        
        FilterRouter(routes)

        const data = reactive({
            routeslist:computed(()=>store.state.permission.routers),
            drawer:true,
            direction:'ltr'
        })
        const isCollapse = computed(()=>!store.state.app.collapse);
        const handleOpen = (key, keyPath) => {
            console.log(key, keyPath)
        }
        const handleClose = (key, keyPath) => {
            console.log(key, keyPath)
        }
        return {
            isCollapse,
            
            handleOpen,
            handleClose,
            data,
            activePath: computed(() => {
                if(route.path.indexOf('/Settings') == 0){
                    return '/Settings/Settings'
                    
                }else{
                      return route.path;
                }
            }),
        }
    },
    methods:{
      GetRouter(){
        
      }
    }
})
</script>

<style lang="scss" scoped>
.el-menu-vertical-demo:not(.el-menu--collapse) {
  width: 200px;
  min-height: 400px;
}
.el-menu-vertical-deoms{
    transition: all 0.5s;
}
:deep(.el-sub-menu__title){
    display: flex;
    align-items: center;
}


</style>