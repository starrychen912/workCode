<template>
  <el-menu
    :default-active="activePath"
    :class="[{'el-menu--collapse':isCollapse},{'el-menu--collapese':mode === 'mobile'}]"
    :collapse="false"
    @open="handleOpen"
    @close="handleClose"
    :router="false"
    mode="vertical"
  >
      <vite-menu-item @vitemenu="Elmenu" :iscollapse="isCollapse" :MenuStatus="`${index}`" v-for="(item,index) in data.routeslist" :context="item.meta.title" :key="index" :ActionIndex="item.path" :title="item.meta.title" :Elicon="item.meta.icon" ></vite-menu-item>
      <!-- <div :class="[mode === 'mobile'?'interval':'nointerval']"  ></div> -->
      <!-- <vite-menu-item :iscollapse="isCollapse" MenuStatus="/Settings/Settings" ActionIndex="/Settings/Settings" :title="global.t('route.setting')" Elicon="el-icon-s-tools" context="设置"></vite-menu-item> -->
      <vite-menu-item @vitemenu="Elmenu" :iscollapse="isCollapse" MenuStatus="/Officialwebsite/Officialwebsite" ActionIndex="/Officialwebsite/Officialwebsite" :Help="true" :title="global.t('route.help')" Elicon="el-icon-thumb" context="帮助"></vite-menu-item>
  </el-menu>
</template>

<script>
import {  reactive,computed } from 'vue'
import { useRoute } from 'vue-router'
// import routes from '../../../router/routes'
import ViteMenuItem from './ViteMenuItem.vue';
import ViteSubMenu from './ViteSubMenu.vue';
import store from '@/store'
import i18n from '../../../locale';
import router from '../../../router';

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


        const data = reactive({
            routeslist:computed(()=>store.state.permission.routers)
        })
        const handleOpen = (key, keyPath) => {
            console.log(key, keyPath)
        }
        const handleClose = (key, keyPath) => {
            console.log(key, keyPath)
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
        return {
            handleOpen,
            handleClose,
            data,
            global,
            Elmenu,
            activePath: computed(() => {
                if(route.path.indexOf('Settings') != -1){
                      return '/index/Settings'
                }else if(route.path.indexOf('Addproduct') != -1){
                     return '/index/Products'
                }else if(route.path.indexOf('Addstoreshop') != -1){
                        return '/index/Storeshop'
                }else if(route.path.indexOf('Revisionproduct') != -1){
                        return '/index/Products'
                }else{
                     return route.path;
                }
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
.interval{
    height: 100px;
}
.nointerval{
    height: 145px;
}
.el-menu--collapese{
    border-right: 0px;
}
.el-menu-vertical-deoms{
    transition: all 0.5s;
}
:deep(.el-sub-menu__title){
    display: flex;
    align-items: center;
}

</style>