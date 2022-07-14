<template>
  <div class="content--title">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
      <h1>
        <font style="vertical-align: inherit;">关于我们</font>
      </h1>
    </el-col>     
  </div>
  <div class="support--content">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="support_content--corporate">
          <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
            <div class="corporate_logo">
              <div class="corporate_logo--img">
                <img src="https://www.pdfannotator.com/images/pdfannotator/Logo.png">
              </div>
              <div class="corporate_logo--detial">帮助企业利用大数据，指定更精准的营销策略</div>
              <div class="corporate_contact">
                <div class="Short_message">
                  <img src="http://www.okai.tech/static/images/www/email.png">
                  <img src="http://www.okai.tech/static/images/www/our_wechat.png">
                </div>
              </div>
            </div>
          </el-col>
          <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
            <div class="corporate_content">
              <h1>公司介绍</h1>
              <p class="line"></p>
              <p class="">町町信息是一家集软硬件开发一体的互联网公司。以为用户提供极优体验的产品为宗旨！我 们对产品规划， 设计， 生产， 销售， 售后有完善的监督管理机制， 保证产品质量和生产 成本最小化。并将产品深入融合互联网和人工智能， 让科技更好服务欧凯用户。</p>
            </div>
          </el-col>
        </div>
        <div class="support_content--Partner">
            <h1>
              <font style="vertical-align: inherit;">合作伙伴</font>
            </h1>
            <div class="Partner_list">
              <el-col :xs="24" :sm="24" :md="5" :lg="6" :xl="6" class="Partner_l--list">
                  <div class="Partner_list--content">
                      <div class="Partner_list--content--img">
                        <img src="../../assets/img/fujitsu.gif">
                      </div>
                      <div class="title">自 2015 年起成为 <a>PDF 协会会员</a></div>
                  </div>
              </el-col>
              <el-col :xs="24" :sm="24" :md="5" :lg="6" :xl="6" class="Partner_l--list">
                  <div class="Partner_list--content">
                      <div class="Partner_list--content--img">
                        <img src="../../assets/img/fujitsu.gif">
                      </div>
                      <div class="title">自 2015 年起成为 <a>PDF 协会会员</a></div>
                  </div>
              </el-col>
              <el-col :xs="24" :sm="24" :md="5" :lg="6" :xl="6" class="Partner_l--list">
                  <div class="Partner_list--content">
                      <div class="Partner_list--content--img">
                        <img src="../../assets/img/fujitsu.gif">
                      </div>
                      <div class="title">自 2015 年起成为 <a>PDF 协会会员</a></div>
                  </div>
              </el-col>
              <el-col :xs="24" :sm="24" :md="5" :lg="6" :xl="6" class="Partner_l--list">
                  <div class="Partner_list--content">
                      <div class="Partner_list--content--img">
                        <img src="../../assets/img/fujitsu.gif">
                      </div>
                      <div class="title">自 2015 年起成为 <a>PDF 协会会员</a></div>
                  </div>
              </el-col>
              <el-col :xs="24" :sm="24" :md="5" :lg="6" :xl="6" class="Partner_l--list">
                  <div class="Partner_list--content">
                      <div class="Partner_list--content--img">
                        <img src="../../assets/img/fujitsu.gif">
                      </div>
                      <div class="title">自 2015 年起成为 <a>PDF 协会会员</a></div>
                  </div>
              </el-col>
            </div>
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
  padding: 35px 0 30px 0;
  display: flex;
  justify-content: center;
}
.support--content{
  background-color: #fff;
  display: flex;
  // align-items: center;
  flex-wrap: wrap;
  justify-content: center;
 
  padding: 20px;
  height: auto;
}
.support--list{
  width: 100%;
  height: 100%;
  flex-wrap: wrap;
}
.support_content--corporate{
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}
.corporate_logo{
  background: rgba(229, 229, 229, 1);
  padding: 20px;
}
.corporate_logo--img{
  padding: 40px 40px 0px 40px;
  box-sizing: border-box;
  margin-top: 100px;
  img{
    width: 100%;
    height: 100%;
  }
}
.corporate_logo--detial{
  font-size: 20px;
  font-family: Microsoft YaHei;
  color: rgba(102, 102, 102, 1);
  // margin: 9px 0 0 102px;
  text-align: center;
}
.Short_message{
  text-align: center;
  margin-top: 50px;
  img{
    margin:0px 10px;
  }
}
.Partner_list{
  display: flex;
  align-items: center;
  flex-wrap: wrap;
}
.corporate_content{
  padding: 20px;
  h1{
    font-size: 30px;
  }
  .line{
    width: 13px;
    height: 2px;
    background: rgba(153, 153, 153, 1);
    margin-top: 27px;
    margin-bottom: 29px;
  }
}
.Partner_list--content{
  padding: 20px;
  background-color: #f5f5f5;
}
.Partner_l--list{
  padding-left: 15px;
  padding-right: 15px;
  margin-top: 20px;
  .title{
    margin-top: 20px;
  }
}
.Partner_list--content--img{
  display: block;
  height: 140px;
  line-height: 140px;
  text-align: center;
  padding: 12px;
  background-color: #fff;
  
}

</style>