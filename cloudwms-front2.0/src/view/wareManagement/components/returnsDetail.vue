<template>
    <div class="expand_props_list--header flex align-center">
        <i class="el-icon-back" @click="GoBack()"></i>
        <div>退货详情</div>
    </div>
    <div class="expand_props_list">
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">基本信息：</div>
              <el-descriptions 
                class="margin-top"
                :column="3"
                :size="size"
                :border="true"
                >
                <el-descriptions-item  label="id">{{expand_list.id}}</el-descriptions-item>
                <el-descriptions-item  label="FBA名称">{{expand_list.name}}</el-descriptions-item>
                <el-descriptions-item label="市场">{{expand_list.market_name}}</el-descriptions-item>
                <el-descriptions-item label="店铺">{{expand_list.shop_name}}</el-descriptions-item>
              </el-descriptions>
            </div>  
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">商品列表</div>
               <el-table border :data="expand_list.order_item">
                <el-table-column labelStyle="width: 200px" label="Id" prop="item_id"></el-table-column>
                <el-table-column label="SKU" prop="sku"></el-table-column>
                <el-table-column label="标题" prop="title"></el-table-column>
                <el-table-column label="库存数量" prop="quantity"></el-table-column>
                <el-table-column label="出库数量" prop="stock"></el-table-column>
              </el-table>
            </div> 
            <div class="expand_stock_list_description">
              <div class="expand_stock_list_description--title">描述：</div>
              <div class="expand_stock_list_description--content" v-html="expand_list.mark">
              </div>
            </div>
            </div>
</template>
<script>
import { onMounted, reactive, toRefs } from 'vue'
import { useRoute,useRouter } from 'vue-router'
import { netConfig } from '@/config/net.config'
import draggable from 'vuedraggable'
import { fbaDetail} from '@/api/FBA.js'
import { isNaLL ,getLocalTime} from '../../../utils/utils'
import {cancelDetail} from '@/api/cancel'
export default {
    components:{
      draggable
    },
    props:{
      Product_id:{
        type:String,
        default:''
      }
    },
    setup(props,content){
      const route = useRoute();
      const router = useRouter();
      const data = reactive({
        expand_list:{},
        baseUrl:netConfig.baseURL,
      })
      onMounted(() =>{
        Get_ProductDeatil();
      })
      //返回上一行
      function GoBack(){
        router.back()
      }
      //获取Product列表
      function Get_ProductDeatil(){
        cancelDetail({
          order_id:route.query.order_id,
        }).then(res =>{
          if(res.code == 1){
            data.expand_list = res.data.data
          }
        })
      }
      return{
        ...toRefs(data),
        Get_ProductDeatil,
        GoBack,
        getLocalTime
      }
    }
}
</script>
<style lang="scss" scoped>
.expand_props_list{
  background-color: #fff;
  padding: 10px;
}
.expand_props_list{
  padding: 20px;
  .expand_stock_list{
    .expand_stock_list--title{
      padding: 10px 0px;
      font-weight: bold;
    }
  }
}
.expand_stock_list_description{
    background-color: #fafafa;
    padding: 20px;
    margin-top: 20px;
    .expand_stock_list_description--title{
      padding-bottom: 20px;
      font-weight: bold;
      word-spacing:5px;
    }
}
//图片
.pic_upload-demo{
  cursor: pointer;
}
.expand-upload-list__item{
  transition: all .5s cubic-bezier(.55,0,.1,1);
  font-size: 14px;
  color: var(--el-text-color-regular);
  line-height: 1.8;
  margin-top: 5px;
  position: relative;
  box-sizing: border-box;
  border-radius: 4px;
  width: 100%;
}
.expand-upload-list--picture-card .expand-upload-list__item{
    overflow: hidden;
    background-color: #fff;
    border: 1px solid #c0ccda;
    border-radius: 6px;
    box-sizing: border-box;
    width: 148px;
    height: 148px;
    margin: 0 8px 8px 0;
    display: inline-block;
}
.pic_upload-demo{
  :deep(.el-upload){
    width: 100%;
    height: 170px;
    .el-upload-dragger{
        width: 100%;
        height: 100%;
        line-height:normal;
    }
  }
}
.expand_props_list--header{
  background-color: #fff;
  padding: 20px 20px 0px 20px;
  cursor: pointer;
  i{
    font-size: 20px;
    margin-right: 10px;
    font-weight: bold;
  }
}
</style>