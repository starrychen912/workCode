<template>
  <div class="product-title flex " >
      <div class="product_content--img" style="position: relative;">
          <div class="el--checkbox" @click.stop="checkboxClick" :class="{'el--checkboxstat':checkbox}">
              <el-checkbox v-model="checkbox" @change="oncheckboxchange" ></el-checkbox>
          </div>
          <div class="product_content--img">
            <el-image :src="product.images[0]?product.images[0].src : ''" fit="fit" style="width: 100%;height:100%;border-radius:5px;"  ></el-image>
            <!-- <img :src="product.images[0]?product.images[0].src : ''"  > -->
          </div>
      </div>
      <div class="product_content--row-body" @click.stop="ProductClisk">
          <div class="product_content--block flex">
              <div class="product_content--block--title ">
                  <div class="product_content--title">{{product.title}}</div>
                  <div class="product_conten-Additional">
                    <div class="product_content--tag">
                      <span>Happiness Store </span>
                    </div>
                    <div class="storeshop-img">
                        <div>Supplier:</div>
                    </div>
                  </div>
              </div>
              <div class="product_content--price">
                  <div class="product_shopify--price flex align-center">
                    <span>Cost：</span>
                    <div class="price">{{t('home.unit')}}{{product.variants[0]?product.variants[0].cost:'0.00'}}</div>
                  </div>
                  <div class="product_shopify--price flex align-center">
                    <span>Price：</span>
                    <div class="price">{{t('home.unit')}}{{product.variants[0]?product.variants[0].compare_at_price:'0.00'}}</div>
                  </div>
                  <div class="product_shopify--price flex align-center">
                    <span>MarketPirce：</span>
                    <div class="price">{{t('home.unit')}}{{product.variants[0]?product.variants[0].market_price:'0.00'}}</div>
                  </div>
              </div>
          </div>
      </div>
      <div class="icon--right">
        <div class="elicon-right" @click.stop="ProductClisk">
          <i class="el-icon-arrow-right"></i>
        </div>
        <div class="elicon-edit">
          <i class="el-icon-edit" @click.stop="Edit"></i>
        </div>
      </div>
  </div>
  
</template>

<script>
import { reactive, toRefs } from 'vue'
import i18n from '../../../locale'
import ProductsDetail from '../ProductsDetail.vue'
import { useRouter } from 'vue-router'
import router from '../../../router'

export default {
  components: { ProductsDetail },
  emits:['onchange','ProductClisk','oncheckboxchange'],
  props:{
    checkbox:{
      type:Boolean,
      default:true
    },
    id:{
      type:[String,Number],
      default:{}
    },
    index:{
      type:Number,
      default:'',
    },
    product:{
      type:[Object],
      default:{}
    },
    checkStatus:{
      type:Object,
      default:{}
    },
    shop_info:{
      type:Object,
      default:{}
    }
  },
  setup(props,content){
    const item = props.product
    const data = reactive({
         t:i18n.global.t,
         srcList:[],
    })
    for(let i=0;i<item.images.length;i++){

        data.srcList.push(item.images[i].src);
    }
    // console.log(data.srcList);
    // console.log(props.product[0].images[0].create_time);
    
    function DetailClose(){

    }
    function ProductClisk(){
        content.emit('ProductClisk')
    }
    function oncheckboxchange(e){
      let data = {
        id:props.id,
        checkbox:e,
        product_id:props.product_id,
        shop_id:props.shop_id
      }
      content.emit('oncheckboxchange',data)
    }
    function checkboxClick(){
      
    }
    //编辑商品
    function Edit(){
      router.push({
        path:"/shop/Revisionproduct",
        query:{
          product_id:props.product.id,
          shop_id:props.product.shop_id,
          type:props.shop_info.type
        }
      })
      content.emit('Edit',props.product.id)
    }
    return {
      ...toRefs(data),
      DetailClose,
      ProductClisk,
      oncheckboxchange,
      checkboxClick,
      item,
      Edit
    }
  }
}
</script>

<style lang="scss" scoped>
.el--checkbox{
  position: absolute;
  left: 10px;
  top: 0px;
  display: none;
}
.product-title{
  min-height: 100px;
  min-width: 300px;
  box-sizing: border-box;
  padding: 10px 20px;
  cursor: pointer;
  &:hover{
    background-color:#ecf5ff;
    .el--checkbox{
        display: block;
    }
  }
}
.el--checkboxstat{
  display: block;
}
.product_content--img{
  width: 120px;
  height: 120px;
  min-width: 120px;
  min-height: 120px;
  img{
    width: 100%;
    height: 100%;
  }
}
.product_content--row-body{
    padding:5px 20px;
    height: 100%;
    flex: 1;
    h2{
      margin:0px;
    }
}

.product_content--block--title {
  flex: 1;
  .product_content--title{
    font-size: 20px;
    font-weight: bold;
  }
}
.product_conten-Additional{
    margin-top: 10px;
    font-size: 14px;
    .product_content--tag{
      color: #6f6f91;
      padding: 5px 0px;
    }
    .storeshop-img{
        width: 100%;
        display: flex;
        align-items: center;
        color: #6f6f91;
        img{
          width: 50px;
          height: 30px;
          margin-left: 10px;
        }
        .filterss{
          filter: grayscale(100%);
          filter: gray;
        }
      }
}

.product_content--price{
  display: flex;
  flex-wrap: wrap;
  align-content: flex-start;
  justify-content: flex-end;
  width: 280px;
}
.product_shopify--price{
  width: 100%;
  display: flex;
  justify-content: flex-end;
  span{
    color: #6f6f91;
  }
  .price{
    font-weight: bold;
  }
}
.icon--right{
  margin-top: 5px;

  i{
    font-weight: bold;
    font-size: 15px;
  }
}
@media only screen and(max-width:900px){
  .product_content--price{
    display: none;
  }
  .icon--right{
    display: none;
  }
}
@media only screen and(max-width:650px){
  .product_content--img{
  width: 100%;
}
  .product-title{
    flex-wrap: wrap;
  }
  .product_content--img{
    width: 100%;
    height: 300px;
    min-width: 100px;
    min-height: 100px;
  }
  .product_content--block{
    flex-wrap: wrap;
  }
  .product_content--row-body{
    padding: 0px;
    flex: 1;
  }
  .product_content--price{
    margin-top: 10px;
    display: flex;
    align-content: flex-start;
    justify-content: flex-start;
  }
}
.elicon-right{
  width: 30px;
  height: 30px;
  color: #fff;
  background-color: #409EFF;
  border-radius: 4px;
  line-height: 30px;
  text-align: center;
}
.el-icon-edit{
  width: 30px;
  height: 30px;
  color: #fff;
  background-color: #409EFF;
  border-radius: 4px;
  line-height: 30px;
  text-align: center;
  margin-top: 10px;
}
</style>