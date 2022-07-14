<template>
  <div class="el-carousel--contet">
    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" >
        <el-carousel height="100%">
          <el-carousel-item v-for="item in bananlist" :key="item">
            <img src="@/assets/img/faq/bananer2.png"> 
            <!-- <img :src="item.url"> -->

            <!-- <img src="http://www.okai.tech/static/images/www/banner1.jpg"> -->
          </el-carousel-item>
      </el-carousel>
    </el-col>
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
      <div class="product_detail--title">
        <h1><i>One</i>
        tool for
        <i>all</i>
         Commodity Management purposes. Everything you need.</h1>
      </div>
      <div class="product_detail--content">
        <div class="title">
          <h1>产品概述.</h1>
        </div>
        <div class="porduct_description">
          <el-col :xs="24" :sm="24" :md="14" :lg="14" :xl="16" style="height:100%;">
            <div class="porduct_description--img">
              <img src="../../assets/img/faq/jianjie.png">
              <!-- <img src="https://www.tencent.com/data/student/pic-bg-1.jpg"> -->
            </div>
          </el-col>
          <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="8" style="height:100%;">
            <div class="porduct_description--detail">
                <h3 class="title">产品简介</h3>
                <div class="description">数据管理中心为企业提供可视化，监控分享的信息处理平台。对于一切商品数据进行整合，进行对数据分析、管理、以及处理数据等。</div>
            </div>
          </el-col>
        </div>
       <div class="porduct_description">
          <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="8" style="height:100%;">
            <div class="porduct_description--detail">
                <h3 class="title">适用人群</h3>
                <div class="description">电商、网络销售、亚马逊、shopifly等一切网络销售平台，需要这个平台整合所有平台进行订单管理的等。店铺管理、订单管理、商品管理等。</div>
            </div>
          </el-col>
          <el-col :xs="24" :sm="24" :md="14" :lg="14" :xl="16" style="height:100%;">
            <div class="porduct_description--img imgright">
              <img src="../../assets/img/faq/home.png">
            </div>
          </el-col>
        </div>
        <div class="porduct_description">
          <el-col :xs="24" :sm="24" :md="14" :lg="14" :xl="16" style="height:100%;">
            <div class="porduct_description--img">
              <img src="@/assets/img/faq/storeshop.png">
            </div>
          </el-col>
          <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="8" style="height:100%;">
            <div class="porduct_description--detail">
                <h3 class="title">店铺管理</h3>
                <div class="description">每一个平台的店铺都有一个独立的平台，每一个平台都有一个独立平台系统，每一个系统都随着当前店铺的来自那个平台（例亚马逊，shopifly）一样的操作的系统。随和着每一个让每一个用户对于平台不用去熟悉新的平台。</div>
            </div>
          </el-col>
        </div>
      </div>
    </el-col>
  </div>
</template>

<script>
import { reactive, toRefs,onMounted } from "vue"
export default {
 
  setup(props,content){
    const data = reactive({
        bananlist:[
          {}
          // {name:"",url:require('../../assets/img/faq/bananer2.png')}
        ]
    })
    
    return {
      ...toRefs(data)
    }
  }
}
</script>

<style scoped lang="scss">
.el-carousel--contet{
  width: 100%;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  // height: 500px;
}
.el-carousel.el-carousel--horizontal{
  width: 100%;
  height: calc(100vh - 100px);
}
.el-carousel.el-carousel--horizontal img{
  width: 100%;
  object-fit: cover;
  height: 100%;
}
.product_detail--title{
  text-align: center;
  height: 100px;
  h1{
    font-size: 2rem;
    color: #333333;
  }
}
.product_detial--list{
  width: 100%;
  
}
.product_detail--content{
  width: 100%;
  height: auto;
  // background-color: #fff;
  // border-radius: 10px;
  cursor: pointer;
  // box-shadow: 1px 1px 15px rgba(000, 000, 000,0.1);
  margin-top: 30px;
  .title{
    text-align: center;
  }
  .porduct_description{
    width: 100%;
    min-height: 500px;
    // border: 1px solid #000;
    margin:0 auto;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    padding: 10px;
    margin-top: 50px;
    &:hover{
      box-shadow: 1px 1px 15px rgba(000, 000, 000,0.1);
    }
    .porduct_description--img{
      width: 100%;
      height: 100%;
      overflow: hidden;
      img{
        object-fit: cover;
        width: 100%;
        height: 100%;
        transition: all 0.8s;
        transform: translateX(0%);
        &:hover{
          transform: scale(1.5)
        }
        animation: animat 1s;
      }
    }
    .imgright{
      width: 100%;
      height: 100%;
      overflow: hidden;
      img{
        object-fit: cover;
        width: 100%;
        height: 100%;
        transition: all 0.8s;
        transform: translateX(0%);
        &:hover{
          transform: scale(1.5)
        }
        animation: imgrightanimat 1s;
      }
    }
    .porduct_description--detail{
      padding: 0px 30px;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      align-content: center;
      .title{
        text-align: center;
        width: 100%;
        margin: 0px;
        font-size: 24px;
      }
      .description{
        margin-top: 10px;
        font-size: 18px;
        color: #333;
      }
    }
  }
}
@keyframes animat {
  0%{
    transform: translateX(-200%);
  }
}
@keyframes imgrightanimat {
  0%{
    transform: translateX(200%);
  }
}
</style>