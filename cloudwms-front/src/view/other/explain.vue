<template>
  <div class="content--title">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
      <h1>
        <font style="vertical-align: inherit;">登录、注册操作流程</font>
      </h1>
    </el-col>     
  </div>
  <div class="support--content">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <h1>注册操作流程</h1>
        <div class="title">需要输入用户名、号码、手机号码、邮箱（有些必填有些不用输入）验证码等注册账号。</div>
        <img src="../../assets/img/faq/revision.png" >
        <h1>登录操作流程</h1>
        <div class="title">需要输入注册的邮箱跟密码登录</div>
        <img src="../../assets/img/faq/login.png" >
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