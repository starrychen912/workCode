<template>
  <div id="userLayout" class="user-layout-wrapper">
      <sidebar-navheader :Showvariable="Showvariable"></sidebar-navheader>
      <vite-menu :isCollapse="!Showvariable"></vite-menu>
  </div>
</template>

<script>
import {computed, reactive} from 'vue'
import { useRoute } from 'vue-router'
import ViteMenu from '../Menu/ViteMenu.vue'
import SidebarNavheader from '../SidebarNav/SidebarNavheader.vue'
import { useStore } from 'vuex'

  export default {
  components: { ViteMenu, SidebarNavheader },
    name: "UserLayout",
    props:{
       Showvariable:{
         type:Boolean,
         default:true
       }
    },
    setup(){
      const store = useStore();
      const route = useRoute();
      return{
      }
    }
  }
</script>

<style lang="scss" scoped>
 

 .el-menu li{
  display: flex !important;
  justify-content: center;
}
.el-menu{
  border-right: none;
}

.el-menu  .is-active{
  border-right:5px solid #409eff !important;
  padding-right: 15px !important;
  transition: all 0.1s;
}

.el-menu-div{
  width: 100%;
  height: auto;
}
.el-menu-div i{
  font-size: 20px;
}
</style>