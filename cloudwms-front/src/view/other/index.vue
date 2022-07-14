<template>
  <el-container>
    <Otherheader></Otherheader>
    <el-main>
      <router-view>
        
      </router-view>
    </el-main>
    <el-footer class="el-footer--content">
      <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18" >
        <div class="footer--content">
          <!-- <div class="footer--content--logo flex align-center">
            <img src="../../assets/img/logo.png" width="50" height="50">
            <div style="font-size:30px;font-family:'楷体';font-weight:600;margin-left:10px;color:#fff;">町町信息科技</div>
          </div> -->
          <div class="footer--content--list flex align-center">
              <div class="footer_list--li">
                <div class="title">相关资源</div>
                <ul><li><a>项目管理器</a></li></ul>
              </div>
              <div class="footer_list--li">
                <div class="title">帮助</div>
                <ul><li><a>怎么使用我们的产品</a></li></ul>
              </div>
              <div class="footer_list--li">
                <div class="title">联系我们</div>
                <ul><li><a>联系作者：201186668</a></li></ul>
              </div>
              <div class="footer_list--li">
                <div class="title">更多产品</div>
                <ul><li><a>跨境电商商品整合管理器</a></li></ul>
              </div>
          </div>
        </div>
      </el-col>
      <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
          <div class="copyright">
            <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18" >
              <div class="copyright--content">版权所有 © 2022 Amani 软件设计 · 保留所有权利。</div>
            </el-col>
          </div>
      </el-col>
    </el-footer>
  </el-container>
</template>

<script>
import Otherheader from "./otherheader.vue";
export default {
    components: { Otherheader }
}
</script>

<style scoped lang="scss">
.el-container{
  flex-direction: column;
}
.el-main{
  background-color: #fff;
  padding: 0px;
}
.el-footer--content{
    width: 100%;
    height: 100%;
    flex-shrink: 0;
    text-align: center;
    background-color: #fff;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    border-bottom: 1px solid #eeeeee;
    background: url('../../assets/img/footer.png') no-repeat;
    // background-color: #333;
    background-size: 100% 100%;
     padding: 0px;
}
.footer--content{
  padding: 20px;
}
.footer--content--logo{
  padding: 50px 0px;
}
.footer--content--list{
  justify-content: space-between;
  color: #eeeeee;
  font-size: 20px;
  .title{
    text-align: left;
    font-size: 20px;
  }
  ul{
    list-style: none;
    padding-left: 0px;
    font-size: 14px;
    margin-top: 20px;
    li{
      text-align: left;
    }
    a{
      color: #aaa;
      cursor: pointer;
    }
  }
}
.copyright{
  height: 100px;
  color: #fff;
  // background-color: #333;
  border: 1px solid rgba(78, 78, 78, 1);
  display: flex;
  align-items: center;
  justify-content: center;
}
.copyright--content{
  width: 100%;
  height: 100%;
}
</style>