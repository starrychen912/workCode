<template>
    <div class="main-content-main user--product" >
      <div class="main-title flex align-center justify-between">        
            <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="oncheckAllchange">全选</el-checkbox>
            <div class="el-dropdown--import flex align-center" >
                <div class="flex align-center button--add" style="min-width:200px;">
                    <label class="el-drop--label">导入店铺：</label>
                    <el-dropdown split-button type="primary" trigger="click" size="medium" @click="ImportShop">
                    {{Dropdowntitle}}
                    <template #dropdown>
                        <el-dropdown-menu @click="Dropdown" >
                          <block  v-for="(item,index) in shoplist" :key="index">
                            <el-dropdown-item @click="Command(item)" v-if="item.id != activeindex">{{item.name}}</el-dropdown-item>
                          </block>
                        </el-dropdown-menu>
                    </template>
                  </el-dropdown>
                </div>
                <div class="medium--input-search ">
                  <el-input class="button--add" size="medium" v-model="keyword" placeholder="请输入内容"></el-input>
                  <el-button class="button--add" type="primary" icon="el-icon-search" size="medium" @click="Search">查找</el-button>
                </div>
                <el-button class="button--add"  size="medium" @click="AddProduct">新增商品</el-button>
                <el-button class="button--add" size="medium" @click="Adjustment">商品调价</el-button>
                <el-button class="button--add" size="medium" @click="ProductImport" disabled>商品导出</el-button>
                <el-button class="button--add" size="medium" @click="Synchronous">同步</el-button>
            </div>
        </div>
        <div class="content--list" :class="{'content-empty':list.length == 0}" v-loading="loading">
            <products 
                  v-for="(item,index) in list" 
                  :key="index" 
                  :product="item"
                  :index="index"
                  @ProductClisk="ProductClisk(item,$event)" 
                  :checkbox="checkStatus[item.id]" 
                  :checkStatus="checkStatus" 
                  :id="item.id"  
                  @oncheckboxchange="oncheckboxchange"
                  v-show="list.length > 0 && Object.keys(list).length > 0"
                  :shop_info="shop_info"
            ></products>
            <div class="content_list--empty" v-if="list.length == 0 && Object.keys(list).length == 0" >
                <img src="@/assets/svg/empty.svg">
                <div>订单是空的~</div>
            </div>
            <div class="el-paginations" v-if="list.length != 0 && Object.keys(list).length != 0">
              <el-pagination
                  @size-change="handleSizeChange"
                  @current-change="handleCurrentChange"
                  :current-page="currentpage"
                  :page-sizes="[10,50,100, 200, 300, 400]"
                  :page-size="pagesize"
                  layout="total, sizes, prev, pager, next, jumper"
                  :total="total">
              </el-pagination>
          </div>
        </div>
    </div>
    
      <el-dialog
          v-model="AdjustmentVisible"
          title="商品调价"
          :width="dialogwidth"
          
        >
        <el-alert title="请输入商品所有上调下动的价格" type="warning" :closable="false"></el-alert>
        <el-form
          label-position="right"
          :label-width="dialogwidth"
          :model="form"
          style="margin-top:20px;"
        >
          <el-form-item label="Market Price" style="text-align:center;" label-width="150px">
            <els-number-in :value="form.marketprice" @inputketup="form.marketprice = $event" @InputBlur="form.marketprice = $event" :error="Getiserror(form.marketprice)" ></els-number-in>
          </el-form-item>
          <el-form-item label="Price" style="text-align:center;" label-width="150px">
            <els-number-in :value="form.price" @inputketup="form.price = $event" @InputBlur="form.price = $event" :error="Getiserror(form.price)"></els-number-in>
          </el-form-item>
           <el-form-item label="Cost" style="text-align:center;" label-width="150px">
             <els-number-in :value="form.cost" @inputketup="form.cost = $event" @InputBlur="form.cost = $event" :error="Getiserror(form.cost)"></els-number-in>
          </el-form-item>
        </el-form>
        <template #footer>
          <span class="dialog-footer">
            <el-button @click="AdjustmentVisible = false">取消</el-button>
            <el-button type="primary" :loading='dialogstatus' @click="DebounceSavaupdateProductPrice"
              >确 定</el-button
            >
          </span>
        </template>
  </el-dialog>
</template>
<script>
import { computed, onMounted, reactive, toRefs, watch } from 'vue'
import Products from './product.vue'
import Shopify from './Shopify.vue'
import Amazon from './Amazon.vue'
import { interfalse,interlll,interCheckall,interobj,Addinstall,isNaLL } from '@/utils/utils'
import OrderlistwangEditor from '../../../Shopfly/Orderlist/OrderlistwangEditor.vue'
import router from '../../../../router'
import { GetProductlist, GetshopifyProdutList,importToSohpifyDirect,LoadPorduct,importToLocalDirect } from '../../../../api/Porductapi'
import { updateProductPrice } from '../../../../api/Addproduct'
import { shoElmessage } from '../../../../utils/Elmessage'
import store from '../../../../store'
import { ShopList } from '../../../../api/shoplist'
import { useStore } from 'vuex'
import ElsNumberIn from '../../../../components/input/els-number-in.vue'
import { useRoute } from 'vue-router'
import { debounce } from '../../../../utils/utils'
export default {
  components: { Products, Shopify, Amazon,  OrderlistwangEditor, ElsNumberIn },
  name:"UserProduct",
  emits:['ProductClisk'],
  props:['Shopid'],
  setup(props,content){
    const route = useRoute();
    const DebounceSavaupdateProductPrice = debounce(SavaupdateProductPrice,200);
    const data = reactive({
      shop_id:route.query.id,
      shop_info:{},
      store:useStore(),
      shoplist:[],//店铺名称
      loading:true, //加载效果
      AdjustmentVisibleloading:true,
      Dropdowntitle:"商品管理",
      activeindex:1, //店铺id
      isIndeterminate:false,
      checkAll:false,
      list:[

      ],
      keyword:'', //输入搜索框
      checkStatus:{}, //选择check

      //对话框
      AdjustmentVisible:false, //弹出框取消
      dialogVisible:false,  //弹出框
      form: { //form输入修改
        name: '',
        desc:'',
        costotal:0,
        marketprice:'',
        cost:'',
        price:'',
      },
      dialogImageUrl: '', //弹出框图片
      Authentication:computed(() => store.getters['userinfo/Authentication'] ),
      shopitem:"", //店铺item
      dialogstatus:false, //弹出框状态
      dialogwidth:computed(() => store.state.setting.dialogwidth),


      pagesize:10,
      total:100,
      currentpage:1,

    })
    watch(
      () => data.checkStatus,
      (newval,oldval) =>{
        if(interlll(newval)){
             data.checkAll = false
             data.isIndeterminate = true;
            if(interCheckall(newval)){
                data.checkAll = true
                data.isIndeterminate = false;
            }
          }else{
              data.checkAll = false
              data.isIndeterminate = false;
          }
        },
        {
            deep:true
        }
    )
    function shopifyProdutList(item){
        data.shop_info = item
        data.loading = true;
        if(data.shop_info.type == 'self'){
                GetProductlist({
                  shop_id:data.shop_id,
                  keyword:data.keyword,
                  page_num:data.currentpage,
                  per_page_num:data.pagesize
                }).then(res =>{
                  data.loading = false
                  if(res.code == 1 ){
                      data.currentpage = res.data.cur
                      data.total = res.data.total
                      data.pagesize = res.data.size
                      data.list = res.data.data
                      data.checkStatus = interfalse(data.list,'id');
                  }
              })
            }else{
              GetshopifyProdutList({
                shop_id:data.shop_id,
                keyword:data.keyword,
                page_num:data.currentpage,
                per_page_num:data.pagesize
              }).then(res =>{
                  data.loading = false
                  if(res.code == 1){
                    data.currentpage = res.data.cur
                    data.total = res.data.total
                    data.pagesize = res.data.size
                    data.list = res.data.data
                    data.checkStatus = interfalse(data.list,'id');
                  }
              })
            }
        
    }
    function Command(item){
        data.Dropdowntitle = item.name
    }
    function Dropdown(e){
      console.log(e);
    }
    function ProductClisk(item,event){
      content.emit('ProductClisk',item)
    }
    function Active(e){
       let item = e;

       data.shopitem = item
       data.loading = true
       data.activeindex = item.id,
       shopifyProdutList(item);
       GetShoplist();
    }
    function oncheckboxchange(e){
      data.checkStatus[e.id] = e.checkbox
    }
    function oncheckAllchange(e){
      data.checkAll = e
      if(e){
        data.checkStatus =  interobj(data.list,'id');
      }else{
        data.checkStatus =  interfalse(data.list,'id');
      }
    }
    //新增商品
    function AddProduct(){
      data.dialogVisible = true
      router.push({path:'/shop/Products/Addproduct',query:{id:data.shop_id}})
    }

    function handlePictureCardPreview(e){
      console.log(e);
    }
    function handbeforeupload(e){
      console.log(e);
    }
    //商品调价
    function Adjustment(e){
        if(interlll(data.checkStatus)){
            data.AdjustmentVisible = true;
            data.form.marketprice=""
            data.form.price=""
            data.form.cost=""
        }else{
            shoElmessage(true,'你还没有选择商品','error')
        }
    }
    //店铺导入商品
    function ImportShop(){
      data.loading = true;
      if(interlll(data.checkStatus)){
            switch(true){
                case data.shop_info.type == 'shopify':
                  console.log('本地');
                  importToLocalDirect({
                      product_ids:Addinstall(data.checkStatus,'string') || '',
                      shop_id:data.shop_id,
                      // token:store.getters['userinfo/accessToken'],
                  }).then(res =>{
                      data.loading = false;
                      if(res.code == 1){
                          shopifyProdutList(data.shopitem);
                          shoElmessage(true,'导入成功')
                      }else{
                          shoElmessage(true,`导入失败，原因：${res.msg}`,'error')
                      }
                  })
                  break;
                case data.shop_info.type == 'self':
                  console.log('shopfly');
                  importToSohpifyDirect({
                      product_ids:Addinstall(data.checkStatus,'string') || '',
                      token:store.getters['userinfo/accessToken'],
                  }).then(res =>{
                      data.loading = false;
                      console.log(res);
                      if(res.code == 1){
                          shopifyProdutList(data.shopitem);
                          shoElmessage(true,'导入成功')
                      }else{
                          shoElmessage(true,`导入失败，原因：${res.msg}`,'error')
                      }
                  })
                  break;
                default:
                  break;
            }


            
        }else{
            data.loading = false;
            shoElmessage(true,'你还没有选择商品','error')
        }
    }
    function ProductImport(){

    }
    //确认商品调价
    function SavaupdateProductPrice(){
      data.dialogstatus = true;
      if(!isNaLL(data.form.cost) && !isNaLL(data.form.price) && !isNaLL(data.form.marketprice)){
          data.dialogstatus = false;
          return shoElmessage(true,'你没有输入','error');
      }
      updateProductPrice({
          product_ids:Addinstall(data.checkStatus,'string') || '',
          shop_id:data.shop_id,
          cost:(Number(data.form.cost)/100),
          compare_at_price:(Number(data.form.price)/100),
          market_price:(Number(data.form.marketprice)/100)
      }).then(res =>{
        data.dialogstatus = false;
        if(res.code == 1){
            shoElmessage(true,'调价成功')
            shopifyProdutList(data.shopitem);
            data.AdjustmentVisible = false; 
        }else{
            shoElmessage(true,'调价失败','error')
        }
      })
    }
    function handleClose(){
      
    }
    //查找按钮
    function Search(){
      shopifyProdutList(data.shopitem);
    }
    //获取shoplist
    function GetShoplist(){
       ShopList({

       }).then(res =>{
          data.shoplist = res.data.filter((fel) =>{
            return fel.id != data.shop_id
          })
          data.Dropdowntitle = data.shoplist[0].name
       })
    }
    //商品同步
    function Synchronous(){
        data.loading = true
        LoadPorduct({
            shop_id:data.shop_id
        }).then(res =>{
            if(res.code === 1){
                data.loading = false
                shoElmessage(true,'同步成功')
                shopifyProdutList(data.shopitem);
            }else{
                shoElmessage(true,'同步失败','error')
            }
        })
    }
    //输入框
    function Getiserror(item){
        if(!isNaLL(data.form.price) && !isNaLL(data.form.cost) && !isNaLL(data.form.marketprice) && data.dialogstatus){    
            return true;
        }
        return false;
    }
    function handleSizeChange(e){
        // console.log(e);
        data.pagesize = e
        shopifyProdutList(data.shopitem)
    }
    function handleCurrentChange(e){
        // console.log(e);
        data.currentpage = e
        shopifyProdutList(data.shopitem)
    }
    return {
      handleSizeChange,
      handleCurrentChange,
      ...toRefs(data),
      ProductClisk,
      Active,
      oncheckboxchange,
      oncheckAllchange,
      AddProduct,
      Dropdown,
      Command,
      //上传文件
      handbeforeupload,
      Adjustment,
      handlePictureCardPreview,
      ProductImport,
      shopifyProdutList,
      SavaupdateProductPrice,
      handleClose,
      Search,
      GetShoplist,
      Synchronous,
      ImportShop,
      Getiserror,
      DebounceSavaupdateProductPrice
    }
  }
}
</script>

<style scoped lang="scss">
*{
  box-sizing: border-box;
}
.main-title{
  padding: 10px 20px;
  border-bottom:1px solid #dcdfe6;
  position: sticky;
  top: -20px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  box-sizing: border-box;
  background-color: #fff;
  z-index: 11;
}
.el-drop--label{
  margin-right: 10px;
  font-size: 14px;
}
.el-dropdown--import{
  // margin-right: 20px;
  // width: 100%;
  box-sizing: box-sizing;
}
:deep(.el-card__body){
  padding: 0px;
  border-radius: none !important;
}
.el--content{
  padding: 10px 0px;
  .el_content--title{
    font-weight: bold;
    padding-left: 15px;
    color: $color-bg;
  }
  position: relative;
}
.el--content::after{
  width: 4px;
  content: '';
  background-color:$color-bg;
  display: block;
  height: 20px;
  position: absolute;
  top: 25%;
}
//内容
.content--list{
  // padding: 10px 20px;
  min-width: 300px;
  
  box-sizing: border-box;

}
.content-empty{
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 500px;
}
.main-content-main{
  background-color: #fff;
  box-sizing: border-box;
  min-width: 300px;
  margin-bottom: 30px;
}
.medium--input-search{
  min-width: 300px;
  display: flex;
  align-items: center;
}
.button--add{
  margin-left: 10px;
}
@media only screen and(max-width:1400px){
  .el-dropdown--import{
    flex-wrap: wrap;
  }
  .button--add{
    margin-top: 10px;
  }

}

@media only screen and(max-width:630px){
  .button--add{
    margin-top: 10px;
  }
}
.content_list--empty{
  width: 200px;
  height:200px;
  text-align: center;
  img{
    width: 200px;
    height: 200px;
  }
}
// 弹出框
:deep(.el-input-number.is-without-controls){
  width: 100%;
}
:deep(.el-input.el-input-group.el-input-group--append){
  width: 80%;
}
.from_input--title{
  width: 100%;
  height: auto;
}
.editor{
  margin-top: 20px;
  height: 250px;
}
.add_from--input{
  box-sizing: border-box;
  overflow: auto;
  height: calc(100vh - 180px);
}
.inner-container::-webkit-scrollbar {
  display: none;
}
.upload-demo{
  width: 100%;
  :deep(.el-upload.el-upload--text){
    width: 100%;
  }
  :deep(.el-upload-dragger){
    width: 100%;
  }
}
.from_input--pricing{
  display: flex;
  margin-top: 10px;
  justify-content: space-between;
  .from_input-price{
    width: 48%;
  }
}
:deep(.el-overlay-dialog){
    overflow: auto;
}
//动画
.user--product{
  animation: Product .8s;
  transform: translateX(0%);
}
@keyframes Product {
    0%{
      transform: translateX(-200%);
    }
}
.product--orderlist{
  display: none;
  animation: Products .8s;
  transform: translateX(200%);
  position: absolute;
  opacity: 0;
  transition: all .8s;
  top: 20px;
}
@keyframes Products {
    0%{
      transform: translateX(0%);
    }
}

.el-paginations{
  // position: fixed;
  bottom: 0px;
  background-color: #fff;
  width: 100%;
  padding: 10px 20px;
}



//
</style>