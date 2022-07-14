<template>
  <div id="userLayout" class="user-layout-wrapper">
      <shopsidebarnavheader :Showvariable="Showvariable" :title="title"></shopsidebarnavheader>
      <shop-menu :isCollapse="!Showvariable" :routeslist="routeslist"></shop-menu>
  </div>
</template>

<script>
import {computed, reactive,toRefs} from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'
import ShopMenu from './shopMenu.vue'
import Shopsidebarnavheader from './ShopSidebarNavHeader.vue'

  export default {
  components: {  ShopMenu, Shopsidebarnavheader },
    name: "UserLayout",
    props:{
       Showvariable:{
         type:Boolean,
         default:true
       },
       title:{
          type:String,
          default:"町町信息"
       },
       routeslist:{
            type:[Array,Object],
            default:[]
        }
    },
    setup(props,content){
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