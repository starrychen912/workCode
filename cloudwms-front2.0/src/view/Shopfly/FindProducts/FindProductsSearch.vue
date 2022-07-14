<template>
    <el-container>
        <el-header>
            <!-- <suppliers-header></suppliers-header> -->
        </el-header>
        <el-main>
            <el-breadcrumb separator-class="el-icon-arrow-right">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item>活动管理</el-breadcrumb-item>
                <el-breadcrumb-item>活动列表</el-breadcrumb-item>
                <el-breadcrumb-item>活动详情</el-breadcrumb-item>
            </el-breadcrumb>
            <div class="Header_title">
                women's Clothing & Accessories
            </div>
            <div class="el_main">
               <el-row>
                <div class="explore-filter">
                    <div class="explore-filter__container">
                        <el-select
                            prefix-icon="123464"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            placeholder="HONG KONG"
                            style="width: 100%;"
                            >
                            <template v-slot:prefix>
                                <span class = 'prefixSlot'>SELLING TO:</span>
                            </template>
                        </el-select>
                    </div>
                    <div class="product-search__products" >
                      <el-select
                            prefix-icon="123464"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            placeholder="HONG KONG"
                            style="width: 50%;"
                            >
                            <template v-slot:prefix>
                                <span class = 'prefixSlot'>SELLING TO:</span>
                            </template>
                        </el-select>

                    </div>
                </div>

                <div class="product-search__results">
                    <div class="product-search__filters">
                        <el-card>
                            <div slot="header" class="clearfix">
                                <span>Category</span>
                            </div>
                            <div class="el_card-list flex align-center justify-between" v-for="(item,index) in data.list" :key="index">
                                <span>Accessories</span>
                                <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M19 12L31 24L19 36" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                            </div>
                        </el-card>
                    </div>
                    <div class="product-search__products" >
                        <div class="product-cards" >
                            <div class="product-cards__product-card" v-for="(item,index) in data.Orderlist" :key="index">
                                <div class="product-card-wrapper">
                                    <div class="panel expanding-panel product-card product-added panel-bordered">
                                        <div class="panel-header-with-image">
                                            <div class="product-card__anchor">
                                                <img src="https://ae04.alicdn.com/kf/H2a9e259092354f35b6b6c1c89c97d156F.jpg">
                                            </div>
                                            <div class="product-marked-corner"></div>
                                        </div>
                                        <div class="panel-body">
                                            <div style="max-height:none;">
                                                <div class="product-card__meta">
                                                    <div class="product-card-meta">
                                                        <div class="product-card-title">
                                                            <a class="product-card-link">Anti-stress Fidget Toys Rainbow Push Bubble Antistress Toys Adult Children Sensory Toy To Relieve Autism Dropshipping</a>
                                                        </div>
                                                        <div class="product-price-wrapper">
                                                            <h4>
                                                                <span>CN¥2.84</span>
                                                            </h4>
                                                        </div>
                                                        <span class="product-card-subtitle">
                                                            <div class="product-shipping-info">
                                                                <div class="shipping-title">CN¥19.34AliExpress Standard Shipping</div>
                                                                <div class="shipping-delivery-time">(28-28 days)</div>
                                                                <i class="el-icon-arrow-down"></i>
                                                            </div>
                                                        </span>
                                                        <div>
                                                            <div class="product-card__reviews">
                                                                <el-rate
                                                                    v-model="data.value"
                                                                    text-color="#ff9900">
                                                                    </el-rate>
                                                                <span>(665)</span>
                                                            </div>
                                                            <div class="product-card__stat">
                                                                <div class="product-card__stat-name">Imports</div>
                                                                <div class="product-card__stat-value">259</div>
                                                            </div>
                                                            <div class="product-card__stat">
                                                                <div class="product-card__stat-name">Orders</div>
                                                                <div class="product-card__stat-value">2591</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="el-pagination--page">
                            <el-pagination
                                background
                                layout="prev, pager, next"
                                :total="1000">
                            </el-pagination>
                        </div>
                    </div>

                </div>
                
                <!-- <el-col :xs="6" :sm="6" :md="7" :lg="6" :xl="6" >
                    
                    
              </el-col> -->
               <!-- <el-col :xs="16" :sm="18" :md="16" :lg="18" :xl="18">
                   
                    <div class="el_col-list">
                        
                    </div>
              </el-col> -->
               </el-row>
            </div>
        </el-main>
    </el-container>
</template>

<script>
import { reactive } from 'vue'
// import SuppliersHeader from '../../components/Loyout/header/Suppliers-header.vue'
export default {
    components:{
    
    },
    setup(){
        const data = reactive({
            value:5,
            list:[1,2,3,4,5,6,7,8,9,10,11,21,32],
            Orderlist:[{},{},{},{},{},{},{},{},{},{},{},{},{},{},{},{}]
        })
        return {
            data
        }
    }
}
</script>
<style>
@import url('@/assets/style/h---h7.css');
</style>
<style lang="scss" scoped>
*{
    box-sizing: border-box;
}
.Header_title{
    font-size:25px;
    padding: 20px 0px;
    border-bottom: 1px solid rgb(235,235,241);
    font-weight: bold;
}
.el_main{
    width: 100%;
    height: auto;
}
.prefixSlot{
    font-weight: bold;
    color: rgb(98,98,140);
    margin-right: 10px;
}
.clearfix{
    font-weight: bold;
    padding:  var(--el-card-padding);
    border-bottom: 1px solid rgb(235,235,241);
}
.el_card-list{
    width: 80%;
    height: auto;
    padding: 20px 20px;
}
.el_col-list{
    width: 100%;
    height: auto;
}


// 商品列表
.explore-filter{
    display: flex;
    border-top: 1px solid #e5e5ec;
    margin-top: 8px;
    padding: 24px 4px 4px 0;
    width: 100%;
    .product-search__products{
        display: inline-flex;
        flex: 3;
        justify-content: flex-end;
    }
}
.explore-filter__container{
    flex: 1;
    max-width: 242px;
    min-width: 230px;
    margin-right: 8px;
}
.product-search__results{
    margin-top: 8px;
    display: flex;
    flex-flow: row nowrap;
    flex: 1;
    .product-search__filters{
        max-width: 242px;
        min-width: 230px;
        flex: 1;
    }
    .product-search__products{
        flex: 3;
        .product-cards{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(215px, 1fr));
            gap: 16px;
            padding: 0 0 24px 16px;
            .product-card-wrapper{
                position: relative;

            }
        }
    }
}

.panel {
    background: #fff;
    box-shadow: 0 0 1px rgb(143 144 165 / 70%), 0 0 10px rgb(143 144 165 / 20%);
    border-radius: 0;
}

.product-card {
    transition: top .2s,z-index .3s;
}
.product-card.product-added {
    border: 4px solid #5ba137;
}
.panel-header-with-image{
    height: 234px;
    position: relative;
    padding: 0;
    cursor: pointer;
    img{
        width: 100%;
        height: 100%;
    }
    .product-card__anchor{
        width: 100%;
        height: 100%;
        padding: 0;
    }
}
.panel-body{
    padding-left: 21px;
    padding-right: 21px;
    padding-bottom: 13px;
}
.product-card__meta{
    min-height: 141px;
}
.product-card-title{
    overflow: auto;
    width: 100%;
    height: 20px;
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
    color: #272742;
    a{
        text-decoration: none;
    }
}
.product-shipping-info{
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-right: 20px;
    cursor: pointer;
    i{
        margin-left: 5px;
    }
}

.product-card-subtitle{
    color: #6f6f91;
    .shipping-title{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .shipping-delivery-time{
        white-space: nowrap;
    }
}
.product-card__reviews{
    margin: 12px 8px 12px 0;
    display: flex;
    align-items: center;
    line-height: 0;
    height: 16px;
    font-size: 12px;
    :deep(.el-rate__icon){
        margin-right: 0px;
    }
    span{
        color: #6f6f91;
        margin-left: 4px;
    }
}
.product-card__stat{
    font-weight: normal;
    font-size: 12px;
    line-height: 20px;
    letter-spacing: .02em;
    display: flex;
    color: #6f6f91;
    justify-content: space-between;
    .product-card__stat-name{
        display: flex;
        flex-direction: row;
        align-items: center;
    }
}
:deep(.el-input__prefix){
    font-size: 12px;
    padding-left: 10px;
}
.el-pagination--page{
    width: 100%;
    height: auto;
    text-align: center;
}
</style>