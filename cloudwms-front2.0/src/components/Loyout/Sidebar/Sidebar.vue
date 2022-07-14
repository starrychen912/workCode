<template>
    <div class="header">
      <div class="nav--logo">
        <sidebarlogo :LogoName="LogoName" @FoldBtn="FoldBtn"></sidebarlogo>
      </div>
      <div class="seacrch--input">
        <slot name="Seacrch"></slot>
      </div>
      <div class="nav_userinfo-userinfo">
        <sidebar-user :Username="userinfo || {}">
          <template #pav><slot name="pav" /></template>
          <template #userinfo-pav><slot name="userinfo-pav"></slot></template>
        </sidebar-user>
      </div>
    </div>
    <div class="" v-if="tagview">
        <tags-view></tags-view>
    </div>
</template>

<script>
import { computed } from 'vue-demi'
import { useStore } from 'vuex'
import { getItem } from '../../../utils/storage'
import Sidebarlogo from '../Sidebar/Sidebarlogo.vue'
import SidebarUser from '../Sidebar/SidebarUser.vue'
import TagsView from '../TagsView/index.vue'
export default {
  components: { Sidebarlogo, SidebarUser,TagsView },
    name:"Sidebar",
    props:{
      LogoName:{
          type:String,
          default:'首页'
      },
      tagview:{
        type:Boolean,
        default:true,
      }
    },
    setup(props,context){
      const store = useStore();
      const userinfo = computed(() => store.getters['userinfo/userinfo'])
       function FoldBtn(data){
          store.commit('setting/SAVE_SETTINGS',{collapse:!store.state.setting.collapse}) 
       }
       return {
         FoldBtn,
         userinfo
       }
    }
}
</script>

<style lang="scss" scoped>
.haeder_bg{
  width: 100%;
  height: auto;
  background-color: #fff;
}
.header{
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  padding: var(--el-header-padding);
  border-bottom:1px solid #d6d6d6;
}
.fold-btn{
  line-height: 48px;
  padding: 0 10px;
  font-size: 18px;
  cursor: pointer;
}
.header .navigation{
  height: 100%;
  display: grid;
  grid-row: 4px;
  grid-template-columns: auto auto;
}
.header .navigation i:hover{
  background-color: rgb(204,204,204);
}
.header .navigation i{
  font-size: 25px;
}
.el-dropdown{
  display: inline-block;
  position: relative;
  color: #606266;
  font-size: 14px;
  line-height: 1;
}
.userinfo{
  padding: 0 16px;
  line-height: 48px;
  cursor: pointer;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
}
.userinfo img{
  margin-right: 8px;
  width: 32px;
  height: 32px;
  border-radius: 50%;
}
.seacrch--input{
  grid-row: 2/2;
  grid-column: 1/span 3;
  width: 50%;
}
@media only screen and(max-width:1400px){
  :deep(.el-header){
    padding: 0px;
  }
  .header {
    height: auto;
    display: grid;
    grid-row: 4px;
    grid-template-columns: auto auto;
  }
  .seacrch--input{
    grid-row: 2/2;
    grid-column: 1/span 3;
    width: 100%;
  }
}

.nav--logo{
  grid-row: 1/1;
  grid-column: 1/span 2;
  .navigation{
    justify-content: flex-start;
  }
}

.nav_userinfo-userinfo{
   grid-column: 3/3;
   grid-row: 1/span 1;
   display: flex;
   justify-content: flex-end;
}
</style>