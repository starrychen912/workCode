<template>
  <div class="content--title">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
      <h1>
        <font style="vertical-align: inherit;">如何对店铺进行一系列管理操作</font>
      </h1>
    </el-col>     
  </div>
  <div class="support--content">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        
        <!-- <div class="title">新增店铺、修改店铺、删除店铺等操作</div> -->
        <div class="title">
          <h3>首页</h3>
          <p>大致展示了，数据多数据分析图，分析所有商品的总销售额，总销售订单，总成本，总利润等一切明白如初</p>
        </div>
        <img src="@/assets/img/faq/home.png">
        <div class="title">
          <h3>店铺操作</h3>
          <p>每个店铺都存在独立一个平台，为了不能操作者去熟悉新的平台，直接防止你原始平台的操作习惯，就是为了方便用户对商品的操作。</p>
        </div>
        <img src="@/assets/img/faq/storeshop.png">
        <img src="@/assets/img/faq/editstore.png">
        <img src="@/assets/img/faq/removestore.png">
        <div class="title">
          <h3>所有店铺的订单操作</h3>
          <p>订单管理的操作就是我为了整合所有订单进行归类，方便用户不用进入单个店铺进行操作等。</p>
        </div>
        <img src="@/assets/img/faq/order.png">
    </el-col>
  </div>
</template>

<script>
import { reactive,toRefs } from 'vue-demi'
export default {
  setup(props,content){
    const data = reactive({
    })
    return{

    }
  }
}
</script>
<style>
.version_history .el-dialog__header{
  border-bottom: 1px solid #e5e5e5;
}
</style>
<style scoped lang="scss">
.content--title{
  width: 100%;
  height: auto;
  background: #f5f5f5;
  padding: 35px 0 30px 0;
  display: flex;
  justify-content: center;
}
.support--content{
  display: flex;
  align-items: center;
  justify-content: center;
  img{
    width: 100%;
    height: 600px;
    object-fit: cover;
  }
   .title{
    margin:10px 0px;
  }
}
</style>