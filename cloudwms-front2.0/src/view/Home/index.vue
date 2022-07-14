<template>
  <el-container class="el-cotainer">
        <el-aside  :class="[{'el-menu--collapse':!collapse},theme]" v-if="device == 'PC'" >
          <sidebar-nav :Showvariable="collapse"></sidebar-nav>
        </el-aside>
        <moblie-menu v-else></moblie-menu>
        <el-container>
          <el-header :class="{'el_header--bg':mode === 'mobile' }"><sidebar ></sidebar></el-header>
          <el-main>
            <router-view v-slot="{ Component }">
                <transition>
                  <keep-alive :include="cachedViews">
                    <component :is="Component" />
                  </keep-alive>
                </transition>
            </router-view>
          </el-main>
        </el-container>
    </el-container>
</template>

<script>
import { reactive,computed, toRefs} from 'vue'
import { useStore } from 'vuex'
import SidebarNav from '../../components/Loyout/SidebarNav/SidebarNav.vue'
import MoblieMenu from '../../components/Loyout/moblieMenu/index.vue'
import Sidebar from "../../components/Loyout/Sidebar/Sidebar.vue"
import i18n from "../../locale"
import { useRouter } from 'vue-router'
export default {
    components:{
        SidebarNav,
        MoblieMenu,
        Sidebar,
    },

    setup(props,context){
      const store = useStore();
      const route = useRouter();
      const data = reactive({
        device:computed(() => store.state.setting.device.mode),
        collapse:computed(()=>store.state.setting.collapse),
        t:i18n.global.t,
        logoname:computed(() => route.currentRoute.value.meta.title),
        cachedViews:computed(() => store.state.tagsView.cachedViews),
        theme:computed(() => store.state.setting.theme),
      })
      
      return {
        ...toRefs(data)
      }
    },
    

}
</script>

<style scoped lang="scss">

.el-cotainer{
   height: 100vh;
}
.el-header{
  background-color: $navBg;
  height: auto;
  padding: 0px;
}
  .el-aside{
    --el-aside-width:200px;
    background-color: $menuBg;
    color: var(--el-text-color-primary);
    text-align: center;
    &::-webkit-scrollbar {display:none}
  }

  .el-main {
    color: var(--el-text-color-primary);
    padding: 15px;
  }
  .el-main .el-main_content{
      width: 100%;
      height: 100%;
      background-color: #fff;
  }
  body > .el-container {
    margin-bottom: 40px;
  }

  .el-container:nth-child(5) .el-aside,
  .el-container:nth-child(6) .el-aside {
    line-height: 260px;
  }

  .el-container:nth-child(7) .el-aside {
    line-height: 320px;
    
  }
   .el-aside{
   // 侧边栏折叠动画速度
      transition: width 0.25s;
      -webkit-transition: width 0.25s;
      -moz-transition: width 0.25s;
      -webkit-transition: width 0.25s;
      -o-transition: width 0.25s;
      background-color: #fff;
      &.dark{
        background-color: var(--sidebar-nav-background--color);
        transition: all 2s;
      }
  }
</style>