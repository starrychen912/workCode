<template>
  <el-container>
      <el-header>
          <sidebar LogoName="设置"></sidebar>
      </el-header>
      <el-main>
         <el-row>
              <el-col :xs="24" :sm="24" :md="8" :lg="6" :xl="4" >
                <setting-sidebar></setting-sidebar>
              </el-col>
              <el-col :xs="24" :sm="24" :md="16" :lg="18" :xl="18">
                <!-- <settings></settings> -->
                <router-view></router-view>
              </el-col>
         </el-row>
      </el-main>
  </el-container>
</template>

<script>

import SettingSidebar from '@/components/Loyout/SettingSidebar/SettingMenu.vue'
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
// import Settings from './Settings.vue'
export default {
    components:{
    SettingSidebar,
    Sidebar,
    // Settings
}

}
</script>

<style lang="scss" scoped>
  @media only screen and (max-width: 990px){
      .el-col-sm-24 {
         margin-bottom: 20px;
         background-color: #fff;
      }
  }

</style>