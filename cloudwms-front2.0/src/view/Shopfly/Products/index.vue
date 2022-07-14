<template>
   <el-container>
        <el-header>
            <sidebar :tagview="false"></sidebar>
        </el-header>
        <!-- <div class="el_header--tags flex align-center justify-between">
            <div class="tags--title">商品管理</div>
            <div class="el--tages flex align-center">
               <div class="tag--title" :class="{'active':_activeindex==1}" @click="Active(1)">商品管理</div>
               <div class="tag--title" :class="{'active':_activeindex==2}" @click="Active(2)">亚马逊管理</div>
               <div class="tag--title" :class="{'active':_activeindex==3}" @click="Active(3)">shopify管理</div>
            </div>
        </div> -->
        <!-- <div class="tags--flex flex align-center " v-if="Authentication">
            <div class="tags_list--li"  :class="{'active':activeindex==item.id}" @click="Active(item,$event)" v-for="(item,index) in shoplist" :key="index">
              <img src="/src/assets/img/shopfilylse.png" v-if="item.type == 'shopify'">
              <img src="/src/assets/img/amazion123.png" v-if="item.type == 'amazon'">
              {{item.name}}
            </div>
        </div> -->
        <!-- <div class="tags---label flex align-center ">
            <div class="tags_list-title flex align-center" >
                <div class="el_icon--left" @click="ScrollLeft">
                  <i class="el-icon-d-arrow-left"></i>
                </div>
                <div class="tags--list align-center flex" ref="Tag"  >
                    <div class="tags_list--li" :class="{'active':_activeindex==1}" @click="Active(1,$event)">商品管理</div>
                    <div class="tags_list--li" :class="{'active':_activeindex==2}" @click="Active(2)">亚马逊管理</div>
                    <div class="tags_list--li" :class="{'active':_activeindex==3}" @click="Active(3)">shopify管理</div>
                    <div class="tags_list--li" :class="{'active':_activeindex==3}" @click="Active(3)">shopify管理</div>
                    <div class="tags_list--li" :class="{'active':_activeindex==3}" @click="Active(3)">shopify管理</div>
                    <div class="tags_list--li" :class="{'active':_activeindex==3}" @click="Active(3)">shopify管理</div>
                    <div class="tags_list--li" :class="{'active':_activeindex==3}" @click="Active(3)">shopify管理</div>
                    <div class="tags_list--li" :class="{'active':_activeindex==3}" @click="Active(3)">shopify管理</div>
                    <div class="tags_list--li" :class="{'active':_activeindex==3}" @click="Active(3)">shopify管理</div>
                </div>
                <div class="el_icon--right" @click="ScrollRight">
                  <i class="el-icon-d-arrow-right"></i>
                </div>
            </div>
            <div class="tags--seacher">
              <el-input placeholder="请输入内容" v-model="searchinput" class="input-with-select">
                  <template #append>
                    <el-button  icon="el-icon-search"></el-button>
                  </template>
                </el-input>
            </div>
        </div> -->
        <el-main>
            <user-product  @ProductClisk="ProductClisk" ref="soref"  ></user-product>
            <!-- <shopify :_activeindex="_activeindex" @ProductClisk="ProductClisk" ref="soref" ></shopify> -->
            <!-- <amazon  @ProductClisk="ProductClisk" ref="soref" ></amazon> -->
        </el-main>
   </el-container>
    <el-drawer
        v-model="drawrstatus"
        title="Filter my products"
        :direction="direction"
        :before-close="DetailClose"
        size="30%"
        custom-class="product--custom"
      >
      <products-detail :content="context" @Delete="DeleteProduct"></products-detail>
    </el-drawer>
</template>

<script>
import { onMounted,ref, reactive, toRefs, computed } from 'vue'

import Sidebar from '../../../components/Loyout/Sidebar/Sidebar.vue'
import UserProduct from './components/UserProduct.vue';
import ProductsDetail from './ProductsDetail.vue';
import Shopify from './components/Shopify.vue';
import Amazon from './components/Amazon.vue';
import { getShopInfo } from '../../../api/shoplist';
import { useStore } from 'vuex';
import { deleteOwnerList,deleteShopProduct } from '../../../api/Porductapi';
import { useRoute } from 'vue-router';
import { shoElmessage } from '../../../utils/Elmessage';
export default {
  components: { Sidebar, UserProduct, ProductsDetail, Shopify, Amazon},
  name:"LoginProducts",

  setup(props,content){
    const store = useStore();
    const Tag = ref(null);
    const soref = ref();
    const data = reactive({
      //  activeindex:0,
       selectkey:"餐厅名",
       searchinput:"",
       direction:'rtl',
       drawrstatus:false,
       shoplist:[],
       Authentication:computed(() => store.getters['userinfo/Authentication']),
       context:{},
      //  shop_info.type:computed(() => useRoute().query.type),
       shop_id:computed(() => useRoute().query.id),
       shop_info:{},
    })
    function Active(item,event){
        // data.activeindex = item.id
        // soref._value.Active(item);
    }
    function ScrollRight(){
        Tag._value.scrollLeft = Tag._value.scrollLeft+120
    }
    function ScrollLeft(){
        Tag._value.scrollLeft = (Tag._value.scrollLeft-120)
    }
    function DetailClose(){
      data.drawrstatus = false
    }
    function ProductClisk(e){
      data.context = e
      data.drawrstatus = true
    }
    function DeleteProduct(e){
        let product_ids = e
        if(data.shop_info.type == 'self'){
            deleteOwnerList({
              product_ids,
            }).then(res =>{
              if(res.code == 1){
                shoElmessage(true,'删除成功')
                data.drawrstatus = false
                GetShoplist();
              }else{
                shoElmessage(true,'删除失败','error')
              }
            })
        }else{
            deleteShopProduct({
              product_ids,
              shop_id:data.shop_id
            }).then(res =>{
              if(res.code == 1){
                shoElmessage(true,'删除成功')
                data.drawrstatus = false
                GetShoplist();
              }else{
                shoElmessage(true,'删除失败','error')
              }
            })
        }
        
    }
    function GetShoplist(){


        getShopInfo({
          shop_id:data.shop_id
        }).then(res =>{
            if(res.code === 1){
              console.log(res);
              data.shop_info = res.data
               soref._value.Active(data.shop_info);
            }
        })
    }
    function GetImgItem(item){
        if(item.type == 'shopify'){
          console.log(1);
          return '@/assets/img/shopfilylse.png'
        }else if(item.type == 'amazon'){
          return '@/assets/img/amazion123.png'
        }
    }
    onMounted(()=>{
      GetShoplist();
    })
    return {
      ...toRefs(data),
      Active,
      Tag,
      soref,
      ScrollLeft,
      ScrollRight,
      ProductClisk,
      DetailClose,
      GetShoplist,
      GetImgItem,
      DeleteProduct
    }
  }
}
</script>

<style>
.el-drawer.rtl.product--custom{
  overflow: auto;
}
</style>
<style scoped lang="scss">
.el-header{
  background-color: #fff;
}
.el_header--tags{
    width: 100%;
    padding: 20px 20px 0px;
    box-sizing: border-box;
    .tags--title{
      font-family: inherit;
      font-weight: bold;
    }
    .active{
        background-color: var(--el-color-primary);
        color: #fff;
    }
}
.tag--title{
    padding:8px 10px;
    background-color: #fff;
    // min-width: 500px;
    font-size: 12px;
    cursor: pointer;
    border: 1px solid var(--el-color-primary);
    box-sizing: border-box;
    transition: all .5s;
    &:hover{
      background-color: var(--el-color-primary);
      transition: all .5s;
      color: #fff;
    }
    &:first-child{
      border-right: none;
      border-top-left-radius: 3px;
      border-bottom-left-radius: 3px;
    }
    &:last-child{
      border-left: none;
      border-top-right-radius: 3px;
      border-bottom-right-radius: 3px;
    }
}



.tags---label{
    width: 100%;
    background-color: #fff;
    justify-content: space-between;
    padding-top: 20px;
    padding-left: 20px;
    box-sizing: border-box;
    transition: all 0.5s;
}
.tags_list-title{
  cursor: pointer;
  width: 50%;
  background-color: #fff;
  position: relative;
  padding: 0px 30px;
  box-sizing: border-box;
}
.tags--list{
    background-color: #fff;
    width: 100%;
    overflow: hidden hidden;
    transition: all 0.5s;
    animation: Overflow 0.5s;
    .active{
      color:$color-bg;
    }
}
@keyframes Overflow {
  0%{
    scroll-left:0;
  }
  100%{
    scroll-left:100%;
  }
}
.tags_list--li{
    white-space: nowrap;
    margin:0px 20px;
    padding: 10px 0px;
    cursor: pointer;
    position: relative;   
    min-width: 60px;
    text-align: center;
    img{
      width: 100%;
      height: 20px;
      top: -10px;
      left: 0px;
      position: absolute;
    }
}

.tags_list--li::after{
    content: '';
    width: 0;
    height: 2px;
    background-color: $color-bg;
    position: absolute;
    bottom: 0%;
    left: 50%;
    transition: all .5s;
}
.tags_list--li.active::after{
    width: 100%;
    left: 0%;
}
.tags_list--li:hover::after{
    width: 100%;
    left: 0%;
}
.tags_list--li:hover{
  color: $color-bg;
}
.tags--seacher{
  width: 50%;
  margin-right: 20px;
  margin-left: 20px;
  padding-bottom: 5px;
}
.el_icon--left{
    position: absolute;
    left: 0px;
    width: 30px;
    height: 100%;
    background-color: #fff;
    display: flex;
    align-items: center;
    z-index: 11;
    // justify-content: center;
}
.el_icon--right{
  position: absolute;
  right: 0px;
  width: 30px;
  height: 100%;
  background-color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
   z-index: 11;
}
@media only screen and(max-width:900px){
  .tags---label{
    flex-wrap: wrap;
    padding-left: 20px;
    padding-right: 20px;
  }
  .tags_list-title{
    width: 100%;
  }
  .tags--seacher{
    width: 100%;
    // margin-top: 10px;
    margin:10px 0px 0px 0px;
  }
}

.tags--flex{
  padding-top: 15px;
  background-color:#fff;
  .active{
    color:$color-bg;
  }
}
:deep(.el-main){
  position: relative;
  // overflow: hidden auto;
}

</style>