<template>
  <el-container class="el-cotainer">
        <el-aside width="200px"  :class="{'el-menu--collapse':!data.collapse}" v-if="data.device == 'PC'">
          <shop-sidebarnav :Showvariable="data.collapse" :title="data.shop_info.name" :routeslist="data.routeslist"></shop-sidebarnav>
        </el-aside>
        <!-- <moblie-menu v-else></moblie-menu> -->
        <el-container>
            <router-view>
            </router-view>
        </el-container>
    </el-container>
</template>

<script>
import { reactive,computed, onMounted} from 'vue'
import { useStore } from 'vuex'
import ShopSidebarnav from '../../../components/ShopLoyout/shopSidebarnav.vue';
import { useRoute } from 'vue-router';
import { getShopInfo } from '../../../api/shoplist';
    export default {
        components:{
        ShopSidebarnav
    },
    setup(props,context){
      const store = useStore();
      const data = reactive({
        device:computed(() => store.state.setting.device.mode),
        collapse:computed(()=>store.state.setting.collapse),
        shop_info:"",
        //单个router
        routeslist:computed(()=>store.state.permission.shoprouters.shoplist)
      })
      
      onMounted(() =>{
        getShopInfo({
          shop_id:useRoute().query.id
          }).then(res =>{
              if(res.code === 1){
                  data.shop_info = res.data
              }
        })
      })
      return {
        data
      }
    },
    

}
</script>

<style scoped lang="scss">
.el-cotainer{
   height: 100vh;
}
  .el-aside {
    background-color: $menuBg;
    color: var(--el-text-color-primary);
    text-align: center;
    
  }

  .el-main {
    color: var(--el-text-color-primary);
    padding: 20px;
    text-align: center;
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
  }
</style>