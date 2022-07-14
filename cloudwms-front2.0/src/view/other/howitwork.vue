<template>
  <div class="el-carousel--contet">
    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" >
        <el-carousel height="100%">
          <el-carousel-item v-for="item in bananlist" :key="item">
            <img src="@/assets/img/faq/bananer.png"> 
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
                <div class="description">数据管理中心为企业提供可视化，监控分享的信息处理平台。对于一切商品数据进行整合，进行对数据分析、管理、以及处理数据等。</div>
                <div class="description">数据管理中心为企业提供可视化，监控分享的信息处理平台。对于一切商品数据进行整合，进行对数据分析、管理、以及处理数据等。</div>
                <div class="description">数据管理中心为企业提供可视化，监控分享的信息处理平台。对于一切商品数据进行整合，进行对数据分析、管理、以及处理数据等。</div>
            </div>
          </el-col>
        </div>
       <div class="porduct_description">
          <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="8" style="height:100%;">
            <div class="porduct_description--detail">
                <h3 class="title">适用人群</h3>
                <div class="description">电商、网络销售、亚马逊、shopifly等一切网络销售平台，需要这个平台整合所有平台进行订单管理的等。店铺管理、订单管理、商品管理等。</div>
                <div class="description">电商、网络销售、亚马逊、shopifly等一切网络销售平台，需要这个平台整合所有平台进行订单管理的等。店铺管理、订单管理、商品管理等。</div>
                <div class="description">电商、网络销售、亚马逊、shopifly等一切网络销售平台，需要这个平台整合所有平台进行订单管理的等。店铺管理、订单管理、商品管理等。</div>
                <div class="description">电商、网络销售、亚马逊、shopifly等一切网络销售平台，需要这个平台整合所有平台进行订单管理的等。店铺管理、订单管理、商品管理等。</div>
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
                <div class="description">每一个平台的店铺都有一个独立的平台，每一个平台都有一个独立平台系统，每一个系统都随着当前店铺的来自那个平台（例亚马逊，shopifly）一样的操作的系统。随和着每一个让每一个用户对于平台不用去熟悉新的平台。</div>
                <div class="description">每一个平台的店铺都有一个独立的平台，每一个平台都有一个独立平台系统，每一个系统都随着当前店铺的来自那个平台（例亚马逊，shopifly）一样的操作的系统。随和着每一个让每一个用户对于平台不用去熟悉新的平台。</div>
                
                <div class="description">每一个平台的店铺都有一个独立的平台，每一个平台都有一个独立平台系统，每一个系统都随着当前店铺的来自那个平台（例亚马逊，shopifly）一样的操作的系统。随和着每一个让每一个用户对于平台不用去熟悉新的平台。</div>
            </div>
          </el-col>
        </div>
      </div>
      <div class="product_annotator--lovers">
          <div class="title">320,000 + System Mem Lovers!</div>
          <div style="text-align:center;">Today, our software is being used by more than 320,000 happy customers in 149 countries.</div>
          <div style="text-align:center;">Here's what they say about System Mem:</div>
      </div>
    </el-col>
    <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24" >
      <div class="ten_bg--dark">
        <div class="ten_main">
          <div class="ten_home">
            <div class="ten_home_l">
              <a>
                <h2>连接用户与生活</h2>
                <p>让生活便捷更多彩</p>
              </a>
              <a>
                <h2>连接企业与科技</h2>
                <p>数字化助手，助力产业升级</p>
              </a>
              <a>
                <h2>连接现在与未来</h2>
                <p>探索面向未来创新科技</p>
              </a>
            </div>
            <div class="ten_home_r">
              <div class="ten_home_card">
                <div class="ten_img--5x4">
                  <img src="https://www.tencent.com/data/index/index_link_1_1.jpg">
                  <div class="ten_img_shadow--vert"></div>
                  <div class="ten_img_txt">
                    <a>
                      <h3>通讯与社交</h3>
                      <p>连接人与人，提供功能丰富的即时通信和社交平台，让沟通更便捷。</p>
                    </a>
                  </div>
                </div>
                <div class="ten_img--5x4">
                  <img src="https://www.tencent.com/data/index/index_link_1_2.jpg">
                  <div class="ten_img_shadow--vert"></div>
                  <div class="ten_img_txt">
                    <a>
                      <h3>数字内容</h3>
                      <p>基于优质内容，以技术为驱动引擎，探索社交和内容融合的下一代形态。</p>
                    </a>
                  </div>
                </div>
                <div class="ten_img--5x4">
                  <img src="https://www.tencent.com/data/index/index_link_1_3.jpg">
                  <div class="ten_img_shadow--vert"></div>
                  <div class="ten_img_txt">
                    <a>
                      <h3>金融科技服务</h3>
                      <p>连接用户、商户和金融机构，提供安全、专业、便捷的金融产品与服务。</p>
                    </a>
                  </div>
                </div>
                <div class="ten_img--5x4">
                  <img src="https://www.tencent.com/data/index/index_link_1_4.jpg">
                  <div class="ten_img_shadow--vert"></div>
                  <div class="ten_img_txt">
                    <a>
                      <h3>工具</h3>
                      <p>提供多种工具性软件，帮助用户快速直接解决各项具体需求。</p>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
.product_annotator--lovers{
  width: 100%;
  padding: 30px;
  background-color: #f8f8f8;
  margin:30px 0px;
  .title{
    font-family: inherit;
    font-weight: 600;
    line-height: 1.5em;
    color: #333333;
    font-size: 26px;
    margin-bottom: 15px;
    text-align: center;
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

.ten_bg--dark{
  background-color: #1B1F25;
  color: #fff;
  .ten_main{
    width: 100%;
    max-width: 1200px;
    height: auto;
    margin: 0px auto;
  }
  .ten_home{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-between;
  }
  .ten_home_r{
    width: calc(66.66% - 12px);
    .ten_home_card{
      display: flex;
      justify-content: space-between;
      align-items: stretch;
      flex-wrap: wrap;
      .ten_img--5x4{
        width: 50%;
        position: relative;
        overflow: hidden;
        &::before{
          content: "";
          display: block;
          padding-bottom: 80%;
        }
        .ten_img_shadow--vert{
          position: absolute;
          top: 0px;
          left: 0px;
          width: 100%;
          height: 100%;
          background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 75%, rgba(0,0,0,0) 100%);
        }
        img{
          position: absolute;
          top: 0px;
          left: 0px;
          width: 100%;
          height: 100%;
          object-fit: cover;
          border: 0;
          vertical-align: bottom;
        }
        .ten_img_txt{
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: flex-end;
            padding: 24px 24px;
            cursor: pointer;
            p{
              opacity: 0;
              transition: ease all 0.3s;
            }
            h3{
              position: relative;
              &::after{
                content: "";
                display: block;
                position: absolute;
                width: 36px;
                height: 24px;
                opacity: 0;
                top: calc(50% - 9px);
                right: 24px;
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center left;
                background-image: url(../../assets/img/icon_arrow_r.png);
                transition: ease all 0.3s;
              }
            }
            &:hover{
              p{
                opacity: 1;
              }
              h3{
                &::after{
                  opacity: 1;
                }
              }
            }
            
            a{
              color: #fff;
            }
        }
      }
    }
  }
  .ten_home_l{
    padding-top: 24px;
    width: calc(33.33% - 12px);
    cursor: pointer;
    a{
      color: #ccc;
      &:hover{
        color: #fff;
        h2{
          padding-left: 36px;
          &::before{
            background: #0052D9;
            left: 0px;
          }
        }
        p{
          padding-left: 36px;
          &::after{
            opacity: 1;
          }
        }
      }
    }
    h2{
      font-size: 32px;
      line-height: 1.2em;
      margin: 12px 0px;
      padding: 0px;
      position: relative;
      transition: ease all 0.3s;
      &::before{
        content: "";
        display: block;
        position: absolute;
        top: 0px;
        left: -24px;
        height: 100%;
        width: 6px;
        background: rgba(25,74,195,0);
        transition: ease all 0.3s;
        // left: 0px;
      }
    }
    p{
        font-size: 16px;
        line-height: 1.5em;
        margin: 12px 0px;
        padding: 0px;
        font-weight: normal;
        position: relative;
        padding-left: 0px;
        transition: ease all 0.3s;
        &::after{
          content: "";
          display: block;
          width: 54px;
          height: 54px;
          opacity: 0;
          background-size: contain;
          background-repeat: no-repeat;
          background-position: center left;
          background-image: url(../../assets/img/icon_arrow_r.png);
          transition: ease all 0.3s;
        }
    }
  }
}
</style>