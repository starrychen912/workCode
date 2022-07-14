<template>
    <el-drawer
                v-model="data.drawer"
                :direction="data.direction"
                :before-close="beforeClose"
                :show-close="false"
                :size="'53%'"
                :withHeader="false"
            >
            <div id="userLayout" class="user-layout-wrapper">
                <sidebar-navheader :SiderStatus="true" :Showvariable="isCollapse"></sidebar-navheader>
                <vite-menu></vite-menu>
            </div>
        </el-drawer>  
</template>

<script>
import { defineComponent, reactive, ref,computed } from 'vue'
import { useRoute } from 'vue-router'
import routes from '../../../router/routes'
import store from '@/store'
import {FilterRouter} from '@/utils/utils';
import SidebarNavheader from '../SidebarNav/SidebarNavheader.vue';
import ViteMenu from '../Menu/ViteMenu.vue';
import { useStore } from 'vuex';

export default defineComponent({
    components:{
        SidebarNavheader,
        ViteMenu
    },
    props:{
         
    },
    created(){

    },
    setup(props,context) {
        const usestore = useStore();
        const route = useRoute();
        
        // FilterRouter(routes)
        const data = reactive({
            routeslist:computed(()=>store.state.permission.routers),
            drawer:computed(() => store.state.setting.collapse),
            direction:'ltr'
        })

        const isCollapse = computed(()=>!store.state.app.collapse);
        function beforeClose(done){
            usestore.commit('setting/SAVE_SETTINGS',{
               collapse:!store.state.setting.collapse
            })
        }
        return {
            isCollapse,
            beforeClose,
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