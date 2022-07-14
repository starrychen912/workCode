<template>
    <div class="product-sidebar" v-if="ProductsStatus">
        <div class="empty" >
            <img src="https://app.oberlo.com/img/svg/product-sidebar-empty.svg"/>
            <h3>You have 5 Oberlo products in your store</h3>
            <div>Select one to view more details.</div>
        </div>
    </div>
     <div class="Product-context">
        <el-header class="el_header-H flex align-center">
            <!-- <el-button type="info" size="mini" style="background-color:#ededf2;border:none;color:#000;">
                <i class="el-icon-close" ></i>
            </el-button> -->
            <div class="flex align-center shopify">
                <a :href="content.out_link">Edit on Shopify</a>
                <svg width="15" height="15" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M28 6H42V20" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M42 29.4737V39C42 40.6569 40.6569 42 39 42H9C7.34315 42 6 40.6569 6 39V9C6 7.34315 7.34315 6 9 6L18 6" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M25.8 22.2L41.1 6.89999" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
            </div>
            <div class="flex align-center shopify">
                <a :href="content.out_link">Edit on Shopify</a>
                <svg width="15" height="15" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M28 6H42V20" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M42 29.4737V39C42 40.6569 40.6569 42 39 42H9C7.34315 42 6 40.6569 6 39V9C6 7.34315 7.34315 6 9 6L18 6" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M25.8 22.2L41.1 6.89999" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
            </div>
        </el-header>
        <div class="product-sidebar__block">
            <div class="product-sidebar__block--content">
                <h3>{{content.title}}</h3>
                <div class="product-sidebar__description">{{content.title}} (Homeware Store (AliExpress))</div>
            </div>
            <div class="product-sidebar__images flex align-center">
                <div class="product-sidebar__images-item" v-for="(imgitem,imgindex) in content.images" :key="imgindex">
                    <img :src="imgitem.src">
                </div>
                <div data-v-69e7af88="" class="product-sidebar__images-more">+{{content.images.length}}</div>
            </div>
            <div class="product-sidebar__block--panel">
                <div data-v-69e7af88="" class="product-sidebar--content">
                    <div data-v-69e7af88="" class="product-sidebar__block--left">
                        <div data-v-69e7af88="" class="product-sidebar__title">
                            Market Price
                        </div>
                    </div> 
                     <div data-v-69e7af88="" class="product-sidebar__block--right">
                    <div data-v-69e7af88="" class=" product-sidebar__data-block-moneybag">
                        <div data-v-69e7af88="" class="money-view"><div class="money-view__field money-view__field--original">
                            <span>{{t('home.unit')}}{{content.variants[0].market_price}}</span></div> <!----></div> <!----></div></div>
                </div>
                <div data-v-69e7af88="" class="product-sidebar--content product-sidebar__border---right" >
                    <div data-v-69e7af88="" class="product-sidebar__block--left">
                        <div data-v-69e7af88="" class="product-sidebar__title">
                            Price
                        </div>
                    </div> 
                     <div data-v-69e7af88="" class="product-sidebar__block--right ">
                    <div data-v-69e7af88="" class=" product-sidebar__data-block-moneybag">
                        <div data-v-69e7af88="" class="money-view"><div class="money-view__field money-view__field--original">
                        <span>{{t('home.unit')}}{{content.variants[0].compare_at_price}}</span></div> <!----></div> <!----></div></div>
                </div>
                <div data-v-69e7af88="" class="product-sidebar--content product-sidebar__border---right" >
                    <div data-v-69e7af88="" class="product-sidebar__block--left">
                        <div data-v-69e7af88="" class="product-sidebar__title">
                            Cost
                        </div>
                    </div> 
                     <div data-v-69e7af88="" class="product-sidebar__block--right ">
                    <div data-v-69e7af88="" class=" product-sidebar__data-block-moneybag">
                        <div data-v-69e7af88="" class="money-view"><div class="money-view__field money-view__field--original">
                        <span>{{t('home.unit')}}{{content.variants[0].cost}}</span></div> <!----></div> <!----></div></div>
                </div>
            </div>
            <div data-v-69e7af88="" class="product-sidebar__info-block">
                <div data-v-69e7af88="">Product cost – amount you will pay to supplier.</div> 
                <div data-v-69e7af88="">Shopify price – product selling price paid by your customers.</div>
            </div>
            <!-- <div class="product-sidebar__block--panel">
                <div class="product-sidebar--content">
                    <h3 class="flex1">AliExpress Products</h3>
                    <el-button type="info" size="mini" style="background-color:#ededf2;border:none;color:#000;">
                       Manage variants
                    </el-button>
                </div>
                <div class="product-sidebar--content product-sidebar__border---right" >
                    <div class="flex1">
                        <h5 class="product-title">
                            <a>DIDABEAR Brand Canvas Tote Bag Women Handbags Female Designer Large Capacity Leisure Shoulder Bags Big Travel Bags Bolsas</a>
                        </h5>
                        <div class="product-sidebar-source-product__supplier flex align-center justify-between">
                            <div class="supplier-badge">
                                <span>By</span>
                                <div>DIDA BEAR Official Store</div>
                            </div>
                            <a class="view-store">View store</a>
                        </div>
                        <p data-v-5db44246="" class="product-sidebar-source-product__footer">5 of 5 variants linked • 32 in stock</p>
                    </div> 
                </div>
            </div> -->
            <!-- <div class="product-sidebar__block--panel">
                <div class="product-sidebar--content" >
                    <div class="flex1">
                        <div class="product-sidebar_-title">{{content.variants.length}} variants</div>
                        <div style="color: #6f6f91;">32 available in stock</div>
                    </div>
                </div>
            </div> -->
            <div class="product-sidebar--content flex align-center">
                <div class="flex1">
                    <div class="auto-updating-switch__text" style="color: #6f6f91;">
                        <span>Automatically update price when cost changes</span> 
                        <a target="_blank" href="/settings/general" class="_blank--a">Manage auto update settings (disabled)</a>
                    </div>
                </div>
                <el-switch
                    v-model="value"
                />
            </div>
            <div class="product-sidebar__block--content">
                <!-- <el-button type="info" size="medium" plain  style="width:100%;">
                       Replace product
                </el-button> -->
                <el-button type="danger" size="medium" style="width:100%;margin-left:0px;margin-top:10px;" @click="DeleteProduct()">
                      DELETE
                </el-button>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive ,toRefs} from "vue";
import i18n from "../../locale";

export default {
    props:{
      ProductsStatus:{
          type:Boolean,
          default:false
      },
      content:{
          type:[Array,Object],
          default:{},
      }
    },
    setup(props,context){
        console.log(props.content);
        const data = reactive({
            loading:false,
            value:false,
            t:i18n.global.t,
        })
        function beforeChange1(){
            data.loading = !data.loading
            data.value = !data.value
        }
        function DeleteProduct(){
            context.emit('Delete',props.content.id)
        }   
        return {
            DeleteProduct,
            ...toRefs(data),
            beforeChange1
        }
    }
}
</script>

<style scoped lang="scss">
    @import url('@/assets/style/h---h7.css');
    *{
        box-sizing: border-box;
    }
   .product-sidebar{
        width: 100%;
        height: 100%;
        display: block;
        position: initial;
        top: initial;
        right: initial;
        bottom: initial;
        box-shadow: initial;
        border-left: 2px solid rgba(189,189,208,.6);
        box-sizing: border-box;
        padding: 64px 0;
}
.Product-context{
    border-left: 2px solid rgba(189,189,208,.6);
    box-sizing: border-box;
}
   .empty{
       width: 100%;
       height: 100%;
       text-align: center;
       box-sizing: border-box;
       padding: 0 64px;
        
   }
   .empty img{
        width: 100%;
   }
   .Product-context{
       width: 100%;
   }
   .Product-context .el-header{
       position: sticky;
       top: 0px;
       z-index: 5;
       background-color: #f6f6f9;
   }
   .el-icon-close{
       font-size: 20px;
   }
.shopify{
   font-size: 14px;
   display: flex;
    margin-left: 16px; 
}
.shopify a{
    font-weight: normal;
    font-size: 12px;
    line-height: 20px;
    padding: 1px;
    letter-spacing: normal;
    text-transform: initial;
    -webkit-text-decoration-line: underline;
    text-decoration-line: underline;
    color: #62628d;
    background: transparent;
    display: inline-block;
    cursor: pointer;
}
.product-sidebar__block{
    width: 100%;
    height: 100%;
    overflow: hidden;
}
.product-sidebar__block--content{
    margin-left: 24px;
    margin-right: 24px;
    margin-top: 16px;
    margin-bottom: 16px;
    h3{
        font-weight: 600;
        font-size: 14px;
        line-height: 20px;
        color: #272742;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    .product-sidebar__description{
        color: #6f6f91;
    }
    
}
.product-sidebar__images{
        margin-top: 16px;
        margin-bottom: 16px;
        position: relative;
        min-height: 135px;
        display: flex;
        flex-direction: row;
    }
    .product-sidebar__images-item{
        flex: 1;
        border-radius: 3px;
        overflow: hidden;
        margin-left: 4px;
        position: relative;
        cursor: pointer;
    }
    .product-sidebar__images-item img{
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
    .product-sidebar__images-more{
        height: 40px;
        line-height: 36px;
        min-width: 40px;
        text-align: center;
        font-size: 16px;
        color: #fff;
        background: #62628d;
        border-radius: 3px;
        z-index: 1;
        position: absolute;
        right: 8px;
        bottom: 8px;
        opacity: .9;
        font-weight: 600;
        cursor: default;
    }
    .product-sidebar__block--panel{
        background: #fff;
        box-shadow: 0 0 1px rgb(143 144 165 / 70%), 0 0 10px rgb(143 144 165 / 20%);
        margin-top: 16px;
        margin-bottom: 16px;
    }
    .product-sidebar--content{
        margin-left: 0;
        margin-right: 0;
        padding: 16px 24px;
        display: flex;
    }
    .product-sidebar__block--left{
        flex: 1;
        .product-sidebar__title{
            font-weight: 600;
            font-size: 14px;
            line-height: 20px;
            color: #272742;
        }
        
    }
    .money-view__field {
        font-weight: 600;
    }
    .product-sidebar__border---right{
        border-top: 1px solid #e5e5ec
    }
    .product-sidebar__info-block{
        font-weight: normal;
        font-size: 12px;
        line-height: 20px;
        letter-spacing: .02em;
        margin-top: -8px;
        color: #6f6f91;
        margin-left: 24px;
        margin-right: 24px;
        margin-bottom: 16px;
    }
    .flex1{
        margin-top: 0px;
        margin-bottom: 0px;
        font-size: 16px;
    }
    .product-title{
        color: #2d00fb;
        font-size: 14px;
        padding: 0;
        margin: 0;
        cursor: pointer;
        a{
            text-decoration-line: underline;
            color: #62628d;
            font-weight: normal;
        }
    }
    .supplier-badge{
            font-family: "Inter",sans-serif;
            font-style: normal;
            font-weight: normal;
            font-size: 14px;
            line-height: 20px;
            -webkit-text-decoration-line: none;
            text-decoration-line: none;
            letter-spacing: normal;
            text-transform: initial;
            -webkit-text-size-adjust: none;
            color: #272742;
            display: flex;
            flex-direction: row;
            white-space: nowrap;
            min-width: 0;
            max-width: 100%;
            span{
                margin-right: 5px;
            }
    }
    .view-store{
        font-weight: normal;
        font-size: 14px;
        line-height: 20px;
        padding: 1px;
        letter-spacing: normal;
        text-transform: initial;
        -webkit-text-decoration-line: underline;
        text-decoration-line: underline;
        color: #62628d;
        background: transparent;
        display: inline-block;
        cursor: pointer;
    }
    .product-sidebar-source-product__footer{
        color: #6f6f91;
        margin: 0;
    }
    .product-sidebar_-title{
        font-weight: 600;
        font-size: 14px;
        line-height: 20px;
        color: #272742;
    }   
    ._blank--a{
            font-weight: normal;
            font-size: 14px;
            line-height: 20px;
            padding: 1px;
            letter-spacing: normal;
            text-transform: initial;
            -webkit-text-decoration-line: underline;
            text-decoration-line: underline;
            color: #62628d;
            background: transparent;
            display: inline-block;
            cursor: pointer;
    } 
</style>