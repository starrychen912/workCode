<template>
  <el-container>
      <el-header>
        <sidebar LogoName="查找商品"></sidebar>
      </el-header>
      <el-main>
          <div class="product-search-container">
              <div class="landing-page">
                  <svg class="landing-page-icon" viewBox="0 0 100 100" style="top: 60px;"><g id="CreateAProduct" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><path d="M22,49.7608696 C23.4,49.7608696 23.75,49.4347826 23.75,48 C23.75,49.4347826 24.1,49.75 25.5,49.7608696 C24.1,49.7608696 23.75,50.0869565 23.75,51.5 C23.75,50.0869565 23.4,49.7608696 22,49.7608696 Z" id="Path-9" stroke="#FFDF8F" fill="#FFDF8F" stroke-linecap="round" stroke-linejoin="round"></path><path d="M56,11.7608696 C57.4,11.7608696 57.75,11.4347826 57.75,10 C57.75,11.4347826 58.1,11.75 59.5,11.7608696 C58.1,11.7608696 57.75,12.0869565 57.75,13.5 C57.75,12.0869565 57.4,11.7608696 56,11.7608696 Z" id="Path-9" stroke="#FFDF8F" fill="#FFDF8F" stroke-linecap="round" stroke-linejoin="round"></path><path d="M62,26.7608696 C63.4,26.7608696 63.75,26.4347826 63.75,25 C63.75,26.4347826 64.1,26.75 65.5,26.7608696 C64.1,26.7608696 63.75,27.0869565 63.75,28.5 C63.75,27.0869565 63.4,26.7608696 62,26.7608696 Z" id="Path-9" stroke="#FFDF8F" fill="#FFDF8F" stroke-linecap="round" stroke-linejoin="round"></path><path d="M77,34.7608696 C78.4,34.7608696 78.75,34.4347826 78.75,33 C78.75,34.4347826 79.1,34.75 80.5,34.7608696 C79.1,34.7608696 78.75,35.0869565 78.75,36.5 C78.75,35.0869565 78.4,34.7608696 77,34.7608696 Z" id="Path-9" stroke="#FFDF8F" fill="#FFDF8F" stroke-linecap="round" stroke-linejoin="round"></path><path d="M31,18.7608696 C32.4,18.7608696 32.75,18.4347826 32.75,17 C32.75,18.4347826 33.1,18.75 34.5,18.7608696 C33.1,18.7608696 32.75,19.0869565 32.75,20.5 C32.75,19.0869565 32.4,18.7608696 31,18.7608696 Z" id="Path-9" stroke="#FFDF8F" fill="#FFDF8F" stroke-linecap="round" stroke-linejoin="round"></path><path d="M40,27.7608696 C41.4,27.7608696 41.75,27.4347826 41.75,26 C41.75,27.4347826 42.1,27.75 43.5,27.7608696 C42.1,27.7608696 41.75,28.0869565 41.75,29.5 C41.75,28.0869565 41.4,27.7608696 40,27.7608696 Z" id="Path-9" stroke="#FFDF8F" fill="#FFDF8F" stroke-linecap="round" stroke-linejoin="round"></path><path d="M26,40.05 C29,40.05 29.75,39.3 29.75,36 C29.75,39.3 30.5,40.025 33.5,40.05 C30.5,40.05 29.75,40.8 29.75,44.05 C29.75,40.8 29,40.05 26,40.05 Z" id="Path-9" stroke="#F7C745" stroke-width="1.5" fill="#F7C745" stroke-linecap="round" stroke-linejoin="round"></path><path d="M68,40.05 C71,40.05 71.75,39.3 71.75,36 C71.75,39.3 72.5,40.025 75.5,40.05 C72.5,40.05 71.75,40.8 71.75,44.05 C71.75,40.8 71,40.05 68,40.05 Z" id="Path-9" stroke="#F7C745" stroke-width="1.5" fill="#F7C745" stroke-linecap="round" stroke-linejoin="round"></path><circle id="Oval-2" fill="#EDAB26" cx="28.75" cy="24.75" r="1"></circle><circle id="Oval-2" fill="#EDAB26" cx="35.75" cy="32.75" r="1"></circle><circle id="Oval-2" fill="#EDAB26" cx="80.75" cy="43.75" r="1"></circle><circle id="Oval-2" fill="#EDAB26" cx="63.75" cy="35.75" r="1"></circle><circle id="Oval-2" fill="#EDAB26" cx="54.75" cy="21.75" r="1"></circle><circle id="Oval-2" fill="#EDAB26" cx="69.75" cy="19.75" r="1"></circle><ellipse id="Oval-2" fill="#EDAB26" cx="54.125" cy="31.325" rx="1.125" ry="1.325"></ellipse><ellipse id="Oval-2" fill="#EDAB26" cx="20.125" cy="44.325" rx="1.125" ry="1.325"></ellipse><ellipse id="Oval-2" fill="#EDAB26" cx="23.125" cy="30.325" rx="1.125" ry="1.325"></ellipse><ellipse id="Oval-2" fill="#EDAB26" cx="43.125" cy="36.325" rx="1.125" ry="1.325"></ellipse><ellipse id="Oval-2" fill="#EDAB26" cx="78.125" cy="48.325" rx="1.125" ry="1.325"></ellipse><ellipse id="Oval-2" fill="#EDAB26" cx="74.125" cy="30.325" rx="1.125" ry="1.325"></ellipse><ellipse id="Oval-2" fill="#EDAB26" cx="62.125" cy="16.325" rx="1.125" ry="1.325"></ellipse><ellipse id="Oval-2" fill="#EDAB26" cx="45.125" cy="9.325" rx="1.125" ry="1.325"></ellipse><polygon id="Path-2" fill="#D8671B" points="27 54 27 78 50.5 93.3 50.5 69.2"></polygon><polygon id="Path-3" fill="#FFDF8F" points="50.5 69.2 75.5 53 75.5 77 50.5 93.309082"></polygon><polygon id="Path-4" fill="#F7C745" points="52 38 75.5 53 50.5 69.2 27 54"></polygon><polygon id="Path-5" fill="#174B54" points="36.52 47.9 60 63.04 66.23 59 42.77 43.9"></polygon><circle id="Oval-2" fill="#EDAB26" cx="49.5" cy="4.5" r="1"></circle><path d="M56.2280273,75.8979492 C62.9677734,80.5 69.7075195,69 69.7075195,68.3583984 C69,69.5 63.5,77 56.2280273,75.8979492 Z" id="Path-6" stroke="#505050" stroke-width="0.5" fill="#505050" stroke-linecap="round" stroke-linejoin="round"></path><path d="M68.6,68.1 C69.8666667,66.7 70.6666667,66 71,66 C71.3333333,66 71.0666667,67.4333333 70.2,70.3 C70.7333333,68.4333333 70.8333333,67.3333333 70.5,67 C70.1666667,66.6666667 69.5333333,67.0333333 68.6,68.1 Z" id="Path-7" stroke="#505050" stroke-width="0.5" fill="#505050" stroke-linecap="round" stroke-linejoin="round"></path><polygon id="Path-8" fill="#3B8A9D" points="60 63.04 60 71.54 66.23 67.5 66.23 59"></polygon><path d="M42.5,20.5 C45.5,20.5 46.25,19.75 46.25,16.45 C46.25,19.75 47,20.475 50,20.5 C47,20.5 46.25,21.25 46.25,24.5 C46.25,21.25 45.5,20.5 42.5,20.5 Z" id="Path-9" stroke="#F7C745" stroke-width="1.5" fill="#F7C745" stroke-linecap="round" stroke-linejoin="round"></path><polygon id="Path-10" fill="#DDE8E8" points="27 65.8 7.8 78.3 31 93.3 50.5 93.3 27 78"></polygon></g></svg>
              </div>
              <div class="product-search-centered">
                  <div class="main-landing-content">
                      <div class="title-Additional">要开始添加商品</div>
                      <div class="title">请首先在亚马逊目录中查找你的商品</div>
                      <div class="title-input">
                        <el-input style="height: 100%" v-model="keyword" placeholder="商品名称、通用产品的代码（UPC）、EAN\国际标准（ISBN）或亚马孙商品编码（ASIN）">
                            <template #append>
                              <el-button   icon="el-icon-search"></el-button>
                            </template>
                        </el-input>
                      </div>
                      <div class="Additional-list flex align-center">
                          <div @click="AddPrdouct">我要添加未在亚马逊销售的新商品</div>
                          <div>我正在上传文件来添加多个商品</div>
                          <div>我需要了解如何发布商品</div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="About_adding-products">
              <div class="About-adding-title">关于添加商品</div>
              <div class="adding-list flex align-center flex-wrap">
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">添加产品</div>
                      <div class="adding-additonal">获取想亚马逊目录中添加商品的基础知识</div>
                      <a>了解更多信息</a>
                  </el-col>
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">批发发布商品</div>
                      <div class="adding-additonal">了解如何使用电子表格上传你的库存等等</div>
                      <a>了解更多信息</a>
                  </el-col>
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">需要获得批准的分类</div>
                      <div class="adding-additonal">需要卖家获得亚马逊的批准，才能在特定商品分类中上架。</div>
                      <a>了解更多信息</a>
                  </el-col>
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">创建变体</div>
                      <div class="adding-additonal">详细了解更新类型以及何时使用变体关系</div>
                      <a>了解更多信息</a>
                  </el-col>
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">什么是GTIN</div>
                      <div class="adding-additonal">你可以在商品包装上找到条形码或GTIM（UPC / EAN / JAN / ISBA），如果你没有GTIN,则可以申请豁免。</div>
                      <a>了解更多信息</a>
                  </el-col>
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">GTIN</div>
                      <div class="adding-additonal">如果你已悄悄GTIN豁免，则可以在你的问题日志中查找状态。</div>
                      <a>了解更多信息</a>
                  </el-col>
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">产品图片指导</div>
                      <div class="adding-additonal">亚马逊上的每件商品都需要配有一张或多张商品图片，阅读有关商品信息的图片标准的信息。</div>
                      <a>了解更多信息</a>
                  </el-col>
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">转换为亚马逊模板</div>
                      <div class="adding-additonal">如果你有自己的电子商务网站或使用其他系统，你可以将你的商品详情导出到文件中。</div>
                      <a>上传非亚马逊模板</a>
                  </el-col>
                  <el-col class="About-adding-product" :xs="24" :sm="12" :md="8" :lg="6" :xl="6">
                      <div class="adding-title">合作性参考</div>
                      <div class="adding-additonal">获取想亚马逊目录中添加商品的基础知识</div>
                      <a>了解更多信息</a>
                  </el-col>
              </div>
          </div>
      </el-main>
  </el-container>
</template>

<script>
import { reactive, toRefs } from "vue"
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
import router from "../../router"
export default {
  components:{
    Sidebar
  },
  setup(props,content){
    const data = reactive({
        keyword:""
    })
    function AddPrdouct(){
        router.push({path:"/Amazonshop/AmazonProducts/productclassify"})
        
    }
    return {
      ...toRefs(data),
      AddPrdouct
    } 
  }
}
</script>

<style scoped lang="scss">
.el-header{
  background-color: #fff;
}
.el-main{
  cursor: pointer;
}
.product-search-container{
  width: 100%;
  // height: 100%;
  position: relative;
}
.landing-page{
  width: 50%;
  height: 100%;
  z-index: 0;
  position: absolute;
  left: -304px;
  transform: scale(1.5);
  svg{
    width: 100%;
    height: 100%;
    z-index: 0;
  }
}
.product-search-centered{
  display: flex;
  align-items: center;
  box-sizing: border-box;
  align-items: center;
  align-content: center;
  flex-direction: column;
  justify-content: center;
  width: 100%;
  // height: 100%;
  position: relative;
  z-index: 1;
}
.main-landing-content{
  min-width: 36rem;
  width: 60%;
  max-width: 50rem;
  padding: 5rem 0px;
  padding-bottom: 10rem;
  margin:auto;
  .title-Additional{
    font-weight: 600;
  }
  .title{
    font-size: 3rem;
    margin-top: 10px;
  }
  .title-input{
    margin-top: 30px;
    height: 60px;
    :deep(.el-input){
      input{
        height: 100%;
        font-size: 17px;
      }
      .el-icon-search{
        font-weight: bold;
        font-size: 20px;
        color: #333;
      }
    }
  }
  .Additional-list{
    margin-top: 20px;
    div{
      text-align: center;
      height: 50px;
      line-height: 50px;
      padding: 0px 10px;
      color: #007185;
      &:nth-child(2){
        border-left: 1px solid #eee;
        border-right: 1px solid #eee;
      }
      &:first-child{
        border-left: 1px solid #eee;
      }
      &:last-child{
        border-right: 1px solid #eee;
      }
    }
  }
}
.main-landing-content{
  width: 50%;
  height: auto;
  margin:0 auto;
  div{
    width:100%;
  }
}
.About_adding-products{
  width: 100%;
  height: auto;
  background-color: #fff;
  position: relative;
  z-index: 11;
  padding: 30px 30px;
  
  .About-adding-title{
    // font-weight: bold;
    font-size: 40px;
  }
}
.About-adding-product{
  margin-top: 30px;
  // width: 20%;
  .adding-title{
    font-weight: bold;
    font-size: 14px;
  }
  .adding-additonal{
    color: #999;
    margin: 10px 0px;
  }
  a{
    text-decoration: none;
    color: #00a2ff;
  }
}

@media only screen and(max-width:640px){
  .title-Additional{
    font-size: 14px;
    color: #999;
  }
  .main-landing-content{
    min-width: auto;
    width: 100%;
    padding: 10px 0px;
    .title{
      font-size: 1.2rem;
      margin-top: 10px;
    }
    .title-input{
    margin-top: 10px;
    height: 40px;
    :deep(.el-input){
      input{
        height: 100%;
        font-size: 12px;
      }
      .el-icon-search{
        font-weight: bold;
        font-size: 12px;
        color: #333;
      }
    }
  }
  }
  .main-landing-content{
    .Additional-list{
      div{
        font-size: 14px;
        height: auto;
        line-height: normal;
      }
    }
  } 
   
}
</style>