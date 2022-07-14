<template>
  <div class="content--title">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
      <font><a>产品支持</a></font>
      <h1>
        <font style="vertical-align: inherit;">常见问题（FAQ）</font>
      </h1>
    </el-col>     
  </div>
  <div class="support--content">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="flex  support--list">
           <el-collapse v-model="activeNames" @change="handleChange" style="border:none;width:100%;">
              <el-collapse-item title="如何注册一个账户" name="1">
                <h1>进入登录界面</h1>
                <img src="@/assets/img/faq/login.png">
                <h1>进入注册界面，输入用户信息进行注册，注册成功，邮箱就是你登录用户名</h1>
                <img src="@/assets/img/faq/revision.png">
              </el-collapse-item>
              <el-collapse-item title="如果管理自己的所拥有的店铺" name="3">
                <h1>进入所有后台管理，点击店铺管理。对店铺进行一系列操作，如（新增店铺，删除店铺，修改店铺）等等。每一个店铺都关联了着每个所有商品管理，每个商品管理需要进入店铺单一的店铺管理等。</h1>
                <img src="@/assets/img/faq/storeshop.png">

              </el-collapse-item>
              <el-collapse-item title="如何进行管理所有的订单" name="2">
                <h1>进入所有后台管理，点击店铺管理。对订单的管理</h1>
                <img src="@/assets/img/faq/order.png">
              </el-collapse-item>
              
              <el-collapse-item title="其他" name="4">
                <div>以及设置跟帮助等操作！</div>
              </el-collapse-item>
            </el-collapse>
        </div>
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
  padding: 35px 10px 30px 10px;
  display: flex;
  justify-content: center;
}
.support--content{
  background-color: #fff;
  display: flex;
  // align-items: center;
  flex-wrap: wrap;
  justify-content: center;
  min-height: 400px;
  padding: 20px;
  height: auto;
}
.support--list{
  width: 100%;
  height: 100%;
  flex-wrap: wrap;
}
.support--list p{
  margin: 0px;
  margin-bottom: 10px;
  word-break: normal;
  white-space: pre-wrap;
  word-wrap: break-word;
  width: 100%;
  a{
    color: #409eff;
  }
}
</style>