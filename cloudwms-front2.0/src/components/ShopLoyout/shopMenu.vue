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
      <vite-menu-item @vitemenu="Elmenu" :iscollapse="isCollapse" :MenuStatus="`${index}`" v-for="(item,index) in routeslist" :context="item.meta.title" :key="index" :ActionIndex="item.path" :title="item.meta.title" :Elicon="item.meta.icon" ></vite-menu-item>
  </el-menu>
</template>

<script>
import {  reactive,computed } from 'vue'
import { useRoute } from 'vue-router'
import ViteMenuItem from '../Loyout/Menu/ViteMenuItem.vue';
import ViteSubMenu from '../Loyout/Menu/ViteSubMenu.vue';
import store from '@/store'
import i18n from '../../locale';
import router from '../../router';
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
        },
        routeslist:{
            type:[Array,Object],
            default:[]
        }
    },
    setup(props,context) {
        const route = useRoute();
        const shop_id = route.query.id;
        const { global } = i18n
        function Elmenu(e){
            if(e.index === '/Officialwebsite/Officialwebsite'){ 
                let url = router.resolve({path:e.index,query:{}})
                window.open(url .href, '_blank');
            }else{
                router.push({
                    path:e.index,
                    query:{
                        id:shop_id,
                    }
                })
            }
            if(store.state.setting.device.mode == 'mobile'){
                store.commit('setting/SAVE_SETTINGS',{
                    collapse:!store.state.setting.collapse
                })  
            }
        }
        
        // const data = reactive({
        //     routeslist:computed(()=>store.state.permission.shoprouters.shoplist)
        // })
        const handleOpen = (key, keyPath) => {
            console.log(key, keyPath)
        }
        const handleClose = (key, keyPath) => {
            console.log(key, keyPath)
        }
        return {
            handleOpen,
            handleClose,
            // data,
            global,
            Elmenu,
            activePath: computed(() => {
                if(route.path.indexOf('Addproduct') != -1 || route.path.indexOf('Revisionproduct') != -1){
                    return '/shop/Products'
                }else if(route.path.indexOf('Addstoreshop') != -1){
                    return '/index/Storeshop'
                }else if(route.path.indexOf('/Amazonshop/AmazonProducts') != -1){
                    return '/Amazonshop/AmazonProducts'
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