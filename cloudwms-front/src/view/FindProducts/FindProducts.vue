<template>
    <el-container>
        <el-header :class="{'el_header--bg':mode === 'mobile' }">
            <sidebar>
                <template #Seacrch>
                    <search class="search-input" :value="keyword"  @inputketup="keyword = $event" @InputBlur="keyword = $event"  >
                        <template #append>
                            <el-button icon="el-icon-search" type="primary" @click="OptionsClick">搜索</el-button>
                        </template>
                    </search>
                </template>
            </sidebar>
        </el-header>
        <el-main>
            <div class="Product_w_t">
                <span>Recemmed</span>
            </div>
            <el-card class="el-cards">
                <el-row>
                    <el-tabs tab-position="left" style="height: 86vh;width:100%;" type="border-card" v-loading="showloadding" >
                       <el-tab-pane v-for="(item,index) in CategoryList" :key="index"  > 
                            <template #label>
                                  <div class="label-title" >{{item.name}}</div>
                            </template>
                            <el-row v-if="recemmed.length != 0" style="overflow:auto;height:100%;">
                                    <shopingfly 
                                        v-for="(item,index) in recemmed" 
                                        :key="index" 
                                        :content="item" 
                                        @addToImportListBtn="addToImportListBtn(index,item.id)" 
                                        @click.stop="ShopflyDetail(item.out_link)"
                                    ></shopingfly>
                                    <div class="loadding-content">
                                        <div class="loadding-conetn-btn" :class="{'disable':pageloading}">
                                            <div v-if="pageloading" >
                                                <i class="el-icon-loading"></i><span>加载中.....</span>
                                            </div>
                                            <div v-else @click="load">点击加载更多数据</div>
                                        </div>
                                    </div>
                            </el-row>
                            <empty v-else content="商品为空~"></empty>
                        </el-tab-pane>
                    </el-tabs>
                </el-row>
            </el-card>
            <!-- <div class="Product_w_t">
                <span>Product Watch</span>
            </div>
            <el-card class="el-cards">
                <el-row>
                    <el-col :xs="24" :sm="12" :md="8" :lg="5" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 37H4V10L18 4H30L44 10V37H37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                                <path d="M37 21V37V44H11V37V21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                                <path d="M30 4L24 18M24 18L18 4M24 18V37V44" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                                <path d="M30 4L24 18" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                                <path d="M24 18L18 4" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                                <path d="M18 4L14 12L18 17.5L16 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                                <path d="M30 4L35 12L30 17.5L32 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               Men's Clothing Accessories
                           </div>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="5" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="36" height="36" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 18L14 10H34L30 18V24L40.5 44H7L18 24V18Z" fill="none" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M20 4V10" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M28 4V10" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 21L30 21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 19V23" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 19V23" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               Women's Clothing & Accessories
                           </div>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="5" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 37H4V10L18 4H30L44 10V37H37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M37 21V37V44H11V37V21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18M24 18L18 4M24 18V37V44" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 18L18 4" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 4L14 12L18 17.5L16 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L35 12L30 17.5L32 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               Toys & Hobbies
                           </div>
                        </div>
                    </el-col>
                   <el-col :xs="24" :sm="12" :md="8" :lg="5" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 37H4V10L18 4H30L44 10V37H37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M37 21V37V44H11V37V21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18M24 18L18 4M24 18V37V44" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 18L18 4" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 4L14 12L18 17.5L16 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L35 12L30 17.5L32 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               Beauty & Health
                           </div>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="5" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 37H4V10L18 4H30L44 10V37H37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M37 21V37V44H11V37V21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18M24 18L18 4M24 18V37V44" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 18L18 4" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 4L14 12L18 17.5L16 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L35 12L30 17.5L32 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               Watches
                           </div>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="5" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 37H4V10L18 4H30L44 10V37H37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M37 21V37V44H11V37V21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18M24 18L18 4M24 18V37V44" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 18L18 4" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 4L14 12L18 17.5L16 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L35 12L30 17.5L32 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               Jewelry & Accessories
                           </div>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="5" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 37H4V10L18 4H30L44 10V37H37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M37 21V37V44H11V37V21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18M24 18L18 4M24 18V37V44" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 18L18 4" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 4L14 12L18 17.5L16 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L35 12L30 17.5L32 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               Home & Garden
                           </div>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="5" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 37H4V10L18 4H30L44 10V37H37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M37 21V37V44H11V37V21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18M24 18L18 4M24 18V37V44" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 18L18 4" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 4L14 12L18 17.5L16 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L35 12L30 17.5L32 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               More categories
                           </div>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="12" :xl="5" class="el-col---list" @click="FinProductsDetail">
                        <div class="grid-content bg-purple flex align-center">
                           <div class="grid-c-svg flex align-center justify-center">
                                <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 37H4V10L18 4H30L44 10V37H37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M37 21V37V44H11V37V21" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18M24 18L18 4M24 18V37V44" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L24 18" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 18L18 4" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M18 4L14 12L18 17.5L16 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M30 4L35 12L30 17.5L32 23L24 37" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                           </div>
                           <div class="grid-c-content">
                               Sports & Entertainment
                           </div>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="24" :lg="12" :xl="5" @click="MoreCateGories" class="el-col---list">
                         <el-popover
                                placement="bottom"
                                width="10000"
                                trigger="click"
                                >
                                <ul class="el-popover---list">
                                    <li  v-for="(item,index) in typelist" :key="index" @click="FinProductsDetail">
                                        <span>{{item.name}} </span>
                                    </li>
                                </ul>
                                <template #reference>
                                    <div class="grid-content bg-purple flex align-center">
                                        <div class="grid-c-svg flex align-center justify-center">
                                            <svg width="35" height="35" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><circle cx="12" cy="24" r="3" fill="#000"/><circle cx="24" cy="24" r="3" fill="#000"/><circle cx="36" cy="24" r="3" fill="#000"/></svg>
                                        </div>
                                        <div class="grid-c-content" >
                                           More categories
                                        </div>
                                    </div>
                                </template>
                            </el-popover>
                    </el-col>
                </el-row>
            </el-card> -->
            <div class="Product_watch">
                <!-- <el-col class="procuct_list-shopingfly">
                    <shopingfly 
                            v-for="(item,index) in recemmed" 
                            :key="index" 
                            :content="item" 
                            @addToImportListBtn="addToImportListBtn(index,item.id)" 
                            @click.stop="ShopflyDetail(item.out_link)"
                        ></shopingfly>
                </el-col> -->
                <!-- <el-carousel indicator-position="none" :loop="false" :autoplay="false" height="580px" arrow="always" >
                    <el-carousel-item v-for="item in 4" :key="item" style="height: auto;">
                        <div class="flex algin-center justify-between flex-wrap" >
                        <el-col class="el-col-list" v-for="(item,index) in list[0].list" :key="index">
                            <el-card :class="{'product-added':item.mystatus}">
                                <div class="panel-header-with-image">
                                    <div class="product-card__anchor">
                                        <img  src="https://ae01.alicdn.com/kf/Hb776e554c8384d56ba3c6dd06e7152baH/Night-Light-Home-Decoration-Bonsai-Style-Party-Cherry-Tree-Shape-LED-Light-DIY-Firework-Christmas-Gift.jpg">
                                    </div>
                                    <div class="product-marked-corner" v-if="item.mystatus">
                                        <i class="el-icon-check"></i>
                                    </div>
                                    <div class="product-in-shop-corner-wrapper" v-if="item.myshop">
                                        <div class="product-in-shop-corner">
                                           <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M4 12H44V20L42.6015 20.8391C40.3847 22.1692 37.6153 22.1692 35.3985 20.8391L34 20L32.6015 20.8391C30.3847 22.1692 27.6153 22.1692 25.3985 20.8391L24 20L22.6015 20.8391C20.3847 22.1692 17.6153 22.1692 15.3985 20.8391L14 20L12.6015 20.8391C10.3847 22.1692 7.61531 22.1692 5.39853 20.8391L4 20V12Z" fill="#ffffff" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M8 22.4889V44H40V22" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M8 11.8222V4H40V12" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><rect x="19" y="32" width="10" height="12" fill="#ffffff" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="el_card-content">
                                   <div class="product-card-title"> 
                                        <a class="product-card-link">Chef Decoration Pencil Anti-slip Accessories Draw Tools Stainless Steel Portable Mini Sauce Painting Coffee Spoon Kitchen Home</a>
                                     </div>
                                   <h4> $73.00 - $21.66 </h4>
                                   <div class="product-shipping-info"> Choose shipping country </div>
                                   <div class="source flex align-center">
                                       <el-rate
                                        v-model="value"
                                        disabled
                                        text-color="#ff9900"
                                        >
                                    </el-rate>
                                      (8)
                                   </div>
                                   <div class="impors flex align-center justify-between">
                                       <span>Impors</span>
                                       <span>23347</span>
                                   </div>
                                   <div class="orders flex align-center justify-between">
                                       <span>Orders</span>
                                       <span>325</span>
                                   </div>
                                   <div class="product-card-actions" :class="{'product-card-action--Bj':item.mystatus}">
                                        <el-button :type="!item.mystatus?'primary':'info'" size="small" style="width:100%;">
                                           <i class="el-icon-plus" v-if="!item.mystatus"></i>
                                           <span>{{!item.mystatus?'ADD TO IMPORT LIST':'EDIT ON IMPORT   List'}}</span>
                                        </el-button>
                                   </div>
                                </div>
                            </el-card>
                        </el-col>
                        </div>
                    </el-carousel-item>
                </el-carousel> -->
            </div>
        </el-main>
    </el-container>
   
</template>

<script>
import { reactive,onMounted,toRefs} from 'vue'
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
import Search from '../../components/Search/Search.vue'
import router  from '../../router'
import {GetProductlist,addToImportList,DeleteImportList} from '../../api/Porductapi'
import { getItem } from '../../utils/storage'
import { shoElmessage } from '../../utils/Elmessage'
import Loaddingbutton from '../../components/loaddingbutton/index.vue'
import Shopingfly from '../../components/shopingfly/shopingfly.vue'
import { GetproductCategoryList } from '../../api/Addproduct'
import Empty from '../../components/empty/index.vue'
import Empty1 from '../../components/empty/index.vue'
import { isNaLL } from '../../utils/utils'
export default {
    components:{
    Sidebar,
    Search,
    Loaddingbutton,
    Shopingfly,
    Empty,
    Empty1
},
    created(){
    },
    setup(props,context){
       const data = reactive({
           keyword:"",
           shop_id:"",
           value:5,
           typelist:[
               {name:'Mens Clothing Accessories',value:1},
               {name:' Womens Clothing & Accessories',value:1},
               {name:'Toys & Hobbies',value:1},
               {name:'Beauty & Health',value:1},
               {name:'Watches',value:1},
               {name:'Jewelry & Accessories',value:1},
               {name:'Home & Garden',value:1},
               {name:'More categories',value:1},
               {name:'Sports & Entertainment',value:1},
               {name:'More categories',value:1},
           ],
           recemmed:[],
           list:[{},{},{},],
           visible:true,
           showsatus:false,
           showloadding:true,
           CategoryList:[],//商品分类列表

           total:100,
           pagesize:10,
           currentpage:1,
           pageloading:false,
       })
       function FinProductsDetail(){
           router.push('/FindProductsSearch')
       }
       function InputSearch(e){
           console.log(e);
       }
       function MoreCateGories(){
           visible = !visible
       }
       return {
           MoreCateGories,
           ...toRefs(data),
           InputSearch,
           FinProductsDetail
       }
    },
    mounted(){
        this.GetFindProducts();
        this.GetproductCategoryLists();
        // this.showloadding = true
    },
    methods:{
        ShopflyDetail(url){
            if(isNaLL(url)){
                window.open(url)
            }else{
               return shoElmessage(true,'可能没有商品详情链接','error')
            }
            
        },
        //获取商品分类列表
        GetproductCategoryLists(){
            GetproductCategoryList({}).then(res =>{
                if(res.code == 1){
                    this.CategoryList = res.data[0].children
                    console.log(this.CategoryList);
                }
            })
        },
        
        GetFindProducts(){
            let that = this;
            that.showloadding = true
            GetProductlist({product_id:"",shop_id:"",keyword:this.keyword,finder_user_id:getItem('userinfo').id,per_page_num:this.pagesize,page_num:this.currentpage}).then(res =>{
                if(res.code == 1){
                    that.showloadding = false
                    this.pageloading = false;
                    if(res.data.data.length != 0){
                        this.recemmed.push(...res.data.data)
                    }else{
                        shoElmessage(true,'没有数据了，你还想怎么样','error')
                    }
                }
            })
        },
        addToImportListBtn(index,id){
           if(this.recemmed[index].is_import == 1){
              return router.push({path:'/index/Orderlist'});
           }
           addToImportList({product_id:id}).then(res => {
               if(res.code == 1){
                   this.recemmed[index].is_import = 1
                   shoElmessage(true,'添加成功','success')
               }else{
                   shoElmessage(true,`添加失败,原因：${res.msg}`,'error')
               }
           })
       },
       OptionsClick(){
           this.GetFindProducts();
       },
       load(e){
           if(this.pageloading){
               return shoElmessage(true,'加载中还点，小心作者锤子丢你~','error')
           }
           this.pageloading = true;
           this.currentpage++
           this.GetFindProducts();
       }
        
    }

}
</script>
<style lang="scss" scoped>
.el-icon-check{
    font-weight: 600;
}
:deep(.el-tabs--left.el-tabs--border-card .el-tabs__item.is-left){
    border-bottom: 1px solid rgb(230, 230, 230);
    &:hover{
        border-bottom: none;
    }
}
:deep(.el-row .el-tabs__item){
    width: 200px;
    height: 80px;
    line-height: 80px;
    font-size: 15px;
    font-weight: bold;
    box-sizing: border-box;
    text-align: center;
    &:hover{
        background-color: #fff;
    }
}
 .el-tabs__content .el-tab-pane .el-row .el-col-list[data-v-7f58a17e]{
        min-width: 290px;
        max-width: 350px;
}
.label-title{
    font-weight: normal;
    font-size: 14px;
    letter-spacing: normal;
    text-transform: initial;
    background: transparent;
    display: inline-block;
    cursor: pointer;
    flex-grow: 4;
    flex-basis: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    min-width: 50px;
    display: -webkit-box;
    height:100%;
    // line-height: 20px;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    white-space: initial;

}
:deep(.el-tabs__content){
        height: 100%;
        // overflow: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-sizing: border-box;
       
        // &::-webkit-scrollbar{
        //     display: none;
        // }
        &:deep(.el-col-list){
            min-width: 190px;
            flex: 1;
            max-width: 243px;
            padding: 12px;
        }


    }
     :deep(.el-tab-pane){
            width: 100%;
            height: 100%;
        }



:deep(.el-carousel__arrow){
   font-size: 50px;
   width: 55px;
   height: 55px;
}
@import url('@/assets/style/h---h7.css');
:deep(.el-rate__icon){
    margin-right: 0px;
}
:deep(.el-rate){
    font-size: 15px;
}
:deep(.el-card__body){
    padding: 0px;
    max-height: 1000px;
    transition: max-height 0.5s ease-in;
}
// 顶部
.el-header{
    height: auto;
    padding: 0px 50px;
}
//内容
.el-main{
    padding: 0px 50px;
    margin-top: 0px;
    &::-webkit-scrollbar{
        display: none;
    }
}

//图标样式
.product-added{
    border:4px solid #5ba137;
}
.product-card-actions{
    transition: all 0.5s;
    margin-top: 0px;
    i{
       font-size: 15px;
       font-weight: bold; 
    }
    span{
        margin-left: 10px;
        font-weight: bold;
        font-size: 14px;
    }
    button{
         opacity: 0;
    }
    
}
.el-col-list:hover .product-card-actions{
    transition: all 0.5s;
    margin-top: 40px;
    button{
        opacity: 1;
        transition: all 0.5s;
    }
    .button{
         opacity: 1;
         transition: all 0.5s;
    }
}
//内容样式
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
    text-decoration: none;
    color: #272742;
}
.product-shipping-info{
    position: relative;
    display: flex;
    justify-content: space-between;
    padding-right: 20px;
    cursor: pointer;
    color: #6f6f91;
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
}
.el_card-content{
    // width: 100%;
    height: auto;
    padding: var(--el-card-padding);
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
    }
}

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
        // fill: #fff;
    }
}


.bg-purple{
    width: 100%;
    height: 80px;
    border-right: 1px solid #eeeef3;
    border-bottom: 1px solid #eeeef3;
}

.grid-c-svg{
    width: 80px;
    height: 80px;
}
.grid-c-content{
    width: auto;
    font-size: 15px;
    color: #000;
    font-weight: bold;
}
.Product_w_t{
    padding:15px 0px;
    font-weight: bold;
    color: #409eff;
    span{
        border-left: 4px solid #409eff;
        padding-left: 10px;
    }
}
:deep(.el-carousel__item){
    height: auto !important;
    overflow: hidden;
    min-height:500px;
}
:deep(.el-carousel__container){
    min-height: 500px;
    max-height: auto;
}
:deep(.el-carousel--horizontal){
    overflow-y: auto;
    // overflow-y: inherit;
}
//开始
.el-col-list{
    min-width: 300px;
    flex: 1;
    max-width: 350px;
    padding:12px;
}

//弹出提示
.el-popover---list{
    transform: translateY(0);
    visibility: visible;
    pointer-events: all;
    overflow: auto;
    max-height: 70vh;
    max-width: 100vw;
    margin: 0;
    padding: 0;
    text-align: left;
    list-style: none;
    color: #272742;
    white-space: nowrap;
    box-sizing: border-box;
    li{
        width: 100%;
        padding: 4px 16px;
        box-sizing: border-box;
        cursor: pointer;
    }
    li:hover{

        background-color: rgb(235, 235, 235);
    }
}



@media only screen and (min-width: 1920px){
    .el-col-xl-5 {
        display: block;
        max-width: 20%;
        flex: 0 0 20%;
    }
}
@media only screen and (min-width: 1200px){
    .el-col-lg-5 {
        display: block;
        max-width: 25%;
        flex: 0 0 25%;
    }
}
@media only screen and (min-width: 1400px){
    .el-col-lg-5 {
        display: block;
        max-width: 20%;
        flex: 0 0 20%;
    }
    .el-col-lg-12 {
        display: block;
        max-width: 20%;
        flex: 0 0 20%;
    }
}

@media only screen and (min-width: 992px){
    .el-col-md-5 {
        display: block;
        max-width: 20%;
        flex: 0 0 20%;
    }
}
@media only screen and(min-width:1400px){
    .page-layout__content-container{
        max-width: 90%;
    }
}
@media only screen and(max-width:1400px){
        .el-header{
            height: auto;
            padding:0px 20px 20px 20px;
            // .header{
            //     display: grid;
            //     grid-template-columns: auto auto;
            //     grid-gap: 4px;
            // }
            // .navigation{
            //     grid-column: 1/span 2;
            //     order: 1;
            // }
            // .search-input{
            //     grid-column: 1/span 3;
            //     order: 3;
            //     display: flex;
            //     align-items: center;
            //     box-sizing: border-box;
            //     :deep(.el-button){
            //         margin-left: 20px;
            //     }
            // }
            // :deep(.SidebarUser){
            //     grid-column: 3/span 1;
            //     order: 2;
            //     margin-left: 0;
            //     justify-content: flex-end;
            // }
        }
        .el-main{
            padding: 20px;
            margin-top: 0px;
            // &::-webkit-scrollbar{
            //     display: none;
            // }
        }
       
}
@media only screen and(max-width:400px){
    
    .el-main{
            padding: 5px;
            margin-top: 0px;
            &::-webkit-scrollbar{
                display: none;
            }
    }
    :deep(.header){
        .navigation{
                height: 100%;
                display: flex;
                align-items: center;    
                justify-content: flex-start;
                cursor: pointer;
                grid-column: 1/ span 2;
                width: 100%;
        }
    }
}
@media only screen and (max-width:1500px){
    :deep(.el-row .el-tabs__item){
        padding: 4px;
        width: 100px;
        text-align: center;
        box-sizing: border-box;
    }
}
@media only screen and (max-width:900px){
    :deep(.el-row .el-tabs__item){
        padding: 4px;
        width: 50px;
        text-align: center;
        box-sizing: border-box;
    }
}
.page-layout__content-container{
    display: flex;
    flex-direction: column;
    position: relative;
    margin-right: auto;
    margin-left: auto;
    margin-bottom: 32px;
    min-height: calc(100% - 68px);
}
.show{
    display: none;
}

//新修改
.procuct_list-shopingfly{
    // min-width: 300px;
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    // max-width: 350px;
    // padding:12px;
}
.loadding-content{
    width: 100%;
    padding: 20px 10px;
    cursor: pointer;
    .loadding-conetn-btn{
        width: 300px;
        height: 40px;
        line-height: 40px;
        margin:0 auto;
        background-color: #409eff;
        text-align: center;
        border-radius: 30px;
        color: #fff;
    }
    .disable{
        background-color: #c4c4c4;
        color: #fff;
        i{
            margin-right: 10px;
        }
    }
}
</style>