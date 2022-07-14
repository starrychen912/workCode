<template>
  <!-- <div class="shopingfly"> -->
      <el-col class="el-col-list " >
            <el-card :class="{'product-added':content.is_import == 1}">
                <div class="panel-header-with-image">
                    <div class="product-card__anchor">
                        <img  :src="content.images[0]?content.images[0].src:''">
                    </div>
                    <div class="product-marked-corner" v-if="content.is_import == 1">
                        <i class="el-icon-check"></i>
                    </div>
                    <div class="product-in-shop-corner-wrapper" v-if="content.is_inport == 1">
                        <div class="product-in-shop-corner">
                            <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M4 12H44V20L42.6015 20.8391C40.3847 22.1692 37.6153 22.1692 35.3985 20.8391L34 20L32.6015 20.8391C30.3847 22.1692 27.6153 22.1692 25.3985 20.8391L24 20L22.6015 20.8391C20.3847 22.1692 17.6153 22.1692 15.3985 20.8391L14 20L12.6015 20.8391C10.3847 22.1692 7.61531 22.1692 5.39853 20.8391L4 20V12Z" fill="#ffffff" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M8 22.4889V44H40V22" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M8 11.8222V4H40V12" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><rect x="19" y="32" width="10" height="12" fill="#ffffff" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                        </div>
                    </div>
                </div>
                <div class="el_card-content" :class="{'el_card--loading':loading}">
                    <div class="product-card-title"> 
                        <a class="product-card-link">{{content.title}}</a>
                    </div>
                    <h4 class="product-card-price">CN{{t('home.unit')}}{{content.variants.length != 0?content.variants[0].market_price:'0.00'}} </h4>
                    <div class="product-shipping-info"> Choose shipping country </div>
                    <div class="source flex align-center">
                        <el-rate
                            v-model="value"
                            disabled
                            text-color="#ff9900">
                        </el-rate>
                        <span>(8)</span>
                    </div>
                    <div class="impors flex align-center justify-between">
                        <span>Impors</span>
                        <span>{{content.imports || 0}}</span>
                    </div>
                    <div class="orders flex align-center justify-between">
                        <span>Orders</span>
                        <span>{{content.orders || 0}}</span>
                    </div>
                    <div class="product-card-actions">
                        <loaddingbutton class="button" :loading="loading" @LoddingBtn="LoddingBtn"  :type="content.is_import == 0?'primary':'info'" :iconStatus="content.is_import == 0" :Btname="content.is_import == 0?'ADD TO IMPORT LIST':'EDIT ON IMPORT   List'" ></loaddingbutton>
                    </div>
                </div>
            </el-card>
        </el-col>
  <!-- </div> -->
</template>

<script>
import Loaddingbutton from '@/components/loaddingbutton/index.vue'
import { reactive, toRefs } from 'vue'
import i18n from '../../locale'
export default {
    emits:['addToImportListBtn'],
    props:{
        content:{
            type:Object,
            default:{}
        }
    },
    components:{
        Loaddingbutton
    },
    setup(props,{emit}){
        const data = reactive({
            value:3,
            loading:false,
            t:i18n.global.t,
        })
        function LoddingBtn(e){
            data.loading = e;
            if(props.content.is_import == 0){
                setTimeout(()=>{
                    console.log(data.loading);
                    data.loading = false
                    emit('addToImportListBtn')
                },3000)
            }else{
                emit('addToImportListBtn')
            }
        }
        return{
            ...toRefs(data),
            LoddingBtn,
        }
    }
}
</script>

<style scoped lang="scss">
@import url('@/assets/style/h---h7.css');
.el-col-list{
    min-width: 300px;
    flex: 1;
    max-width: 350px;
    padding:12px;
    cursor: pointer;
}
//   图片样式
.panel-header-with-image{
    position: relative;
    padding: 0;
    height: 300px;
    cursor: pointer;
}
.product-card__anchor{
    width: 100%;
    height: 100%;
    padding: 0;
    img{
        border-radius: 0;
        vertical-align: top;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
}
//正确的图标
.product-marked-corner{
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    z-index: 11;
    border-style: solid;
    border-color: #5ba137 transparent transparent transparent;
    border-width: 50px 50px 0 0;
    i{
        position: absolute;
        width: 20px;
        height: 20px;
        color: #fff;
        top: 0px;
        margin-top: -40px;
        left: 5px;
        font-weight: bold;
    }
}
//商品图标
.product-in-shop-corner-wrapper{
    right: -4px;
    top: -4px;
    width: 66px;
    height: 66px;
    border-radius: 3px;
    position: absolute;
    overflow: hidden;
    .product-in-shop-corner{
        border-style: solid;
        border-color: #595bff transparent transparent transparent;
        border-width: 66px 0 0 66px;
    }
    svg{
        height: 20px;
        width: 20px;
        position: absolute;
        top: 12px;
        right: 8px;
    }
}
//边框
.product-added{
    border:4px solid #5ba137;
}

//内容
.el_card-content{
    height: 200px;
    padding: var(--el-card-padding);
    transition: all 0.5s;
    overflow: hidden;
}
.product-card-title{
    overflow: auto;
    width: 100%;
    height: 30px;
    justify-content: space-between;
    align-items: center;
    position: relative;
}
.product-card-link{
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    text-decoration: none;
    color: #272742;
    font-size: 22px;
    font-weight: bold;
}
.product-card-price{
    color: red;
}
.product-shipping-info{
    position: relative;
    display: flex;
    justify-content: space-between;
    // padding-right: 20px;
    cursor: pointer;
    color: #9292b8;
    font-size: 15px;
    margin-top: 10px;
}
.impors{
    font-weight: normal;
    font-size: 14px;
    line-height: 20px;
    letter-spacing: .02em;
    display: flex;
    color: #6f6f91;
    justify-content: space-between;
}
.orders{
    font-weight: normal;
    font-size: 12px;
    line-height: 20px;
    letter-spacing: .02em;
    display: flex;
    color: #6f6f91;
    justify-content: space-between;
}
.source{
    width: 100%;
    padding: 10px 0px;
    span{
        font-size: 12px;
        margin-left: 8px;
    }
}
.el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 150px;
    margin: 0;
  }
  .grid-content{
      cursor: pointer;
  }
  .el-col---list:hover{
      background-color: rgb(243, 243, 243);
  }
  .el-col-list:hover{
      .el_card-content{
          height: 270px;
          transition: all 0.5s;
      }
  }
  .el_card--loading{
      height: 280px;
  }
</style>