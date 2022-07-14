<template>
  <el-menu
    :default-active="activePath"
    class="el-menu-vertical-demo el-menu-vertical-deoms"
    :collapse="false"
    @open="handleOpen"
    @close="handleClose"
    :router="true"
    mode="vertical"
  >
    <el-menu-item :index="item.path" v-for="(item,index) in data.routeslist" :key="index">
        <span slot="title">{{item.name}}</span>
        <div class="setting-menu-ico">
            <i class="el-icon-arrow-right"></i>
        </div>
    </el-menu-item>
  </el-menu>
</template>

<script>

import { useStore } from 'vuex'
import { useRoute } from 'vue-router'
import {computed, ref,reactive} from 'vue'
export default {
  created(){
     
  },
  setup(props,context){
      const route = useRoute();
      const store = useStore();
      const data = reactive({
            routeslist:computed(()=>store.state.permission.SET_SETTIN_GROUTERS)
      })
      return {
          data,
          activePath: computed(() => route.path),
      }
  }
}
</script>

<style scoped lang="scss">
    .el-menu{
        background-color: rgb(255,255,255,0);
        border-right: none;
    }
    .el-menu-item{
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: bold;
    }
    .is-active{
        background-color: #fff;
    }
    .setting-menu-ico{
        width: auto;
        i{
             font-weight: bold;
        }
    }
    .el-menu-item .setting-menu-ico i{
        display: none;
    }
    .is-active .setting-menu-ico i{
        display: inherit;
    }
</style>