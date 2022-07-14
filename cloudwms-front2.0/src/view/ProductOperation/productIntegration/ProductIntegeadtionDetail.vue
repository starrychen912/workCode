<template>
    <div class="expand_props_list--header flex align-center">
        <i class="el-icon-back" @click="GoBack()"></i>
        <div>产品研发详情</div>
    </div>
    <div class="expand_props_list">
            <div>
            </div>
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">商品图片：</div>
              <draggable 
                  class="draggable_list flex flex-wrap"
                  v-model="expand_list.images"
                  @start="drag = true"
                  @end="drag = false"
                  item-key="id"
                  :animation="1000"
                  @change="onMoveCallback"
                  :forceFallback="true"
                >
                  <template #item="{ element }">
                    <div class="pic_upload-demo">
                      <ul class="el-upload-list expand-upload-list--picture-card">
                          <li class="expand-upload-list__item is-success">
                            <el-image style="width: 100%; height: 100%"  :src="element.src" ></el-image>
                          </li>
                      </ul>
                    </div>
                </template>
              </draggable>
            </div>
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">基本信息：</div>
              <el-descriptions 
                class="margin-top"
                :column="3"
                :size="size"
                border
                >
                <el-descriptions-item  label="产品标题">{{expand_list.title}}</el-descriptions-item>
                <el-descriptions-item  label="产品类型">{{expand_list.category_name}}</el-descriptions-item>
                <el-descriptions-item label="供应商名称">{{expand_list.supplier_name}}</el-descriptions-item>
                <el-descriptions-item label="创建时间">{{getLocalTime(expand_list.create_time)}}</el-descriptions-item>
                <el-descriptions-item label="商品状态">
                  <el-tag :type="expand_list.order_status == '1'?'success' : expand_list.order_status == '1' ? 'warning':'' ">
                      {{expand_list.order_status == '1'?'普通':expand_list.order_status == '2'?'优先':'置顶'}}
                  </el-tag>
                </el-descriptions-item>
                <el-descriptions-item label="商品状态">
                  <el-tag :type="expand_list.status == 0?'danger':'success'">{{expand_list.status == 0?'进行中':'已完成'}}</el-tag>
                </el-descriptions-item>
              </el-descriptions>
               
            </div>  

            <div class="expand_stock_list">
              <div class="expand_stock_list--title">竞品列表：</div>
              <el-table border :data="expand_list.competitives">
                <el-table-column labelStyle="width: 200px" label="Id" prop="id"></el-table-column>
                <el-table-column label="竞品名称" prop="name"></el-table-column>
                <el-table-column label="地址" prop="url">
                  <template #default="scope" max-width="100px">
                    <el-link :underline="false" type="primary" :href="scope.row.url" target="_blank">
                      Beast
                    </el-link>
                  </template>
                </el-table-column>
                <el-table-column label="参考价格" prop="price"></el-table-column>
                <el-table-column label="预览数" prop="reviews"></el-table-column>
              </el-table>
            </div>
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">品牌列表：</div>
              <el-table border :data="expand_list.brand">
                <el-table-column labelStyle="width: 200px" label="Id" prop="id"></el-table-column>
                <el-table-column label="品牌名称" prop="name"></el-table-column>
                <el-table-column label="品牌地址" prop="url">
                  <template #default="scope" >
                    <el-link :underline="false" type="primary" :href="scope.row.url" target="_blank">
                      Beast
                    </el-link>
                  </template>
                </el-table-column>
                <el-table-column label="订单数" prop="orders"></el-table-column>
                <el-table-column label="logo" prop="logo" width="100px">
                  <template #default="scope" >
                    <el-image :src="scope.row.logo"></el-image>
                  </template>
                </el-table-column>
                 <el-table-column label="简介" prop="introduction"></el-table-column>
              </el-table>
            </div>
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">负责人列表：</div>
              <el-table border :data="expand_list.user">
                <el-table-column label="Id" prop="id"></el-table-column>
                <el-table-column label="头像" width="100px">
                  <template #default="scope" >
                    <el-image :src="scope.row.avatar"></el-image>
                  </template>
                </el-table-column>
                <el-table-column label="状态" prop="status"></el-table-column>
                <el-table-column label="手机号码" prop="phone"></el-table-column>
                <el-table-column label="邮箱" prop="email"></el-table-column>
              </el-table>
            </div>
            <div class="expand_stock_list_description">
              <div class="expand_stock_list_description--title">描述：</div>
              <div class="expand_stock_list_description--content">
                {{expand_list.description}}
              </div>
            </div>
            </div>
</template>
<script>
import { onMounted, reactive, toRefs } from 'vue'
import { useRoute,useRouter } from 'vue-router'
import { netConfig } from '@/config/net.config'
import draggable from 'vuedraggable'
import {GetproductDetail} from '@/api/productDevelopmentList.js'
import { getLocalTime } from '../../../utils/utils'
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
        GetProductDatalData();
      })
      //返回上一行
      function GoBack(){
        router.back()
      }
      //获取Product列表
      function GetProductDatalData(){
        GetproductDetail({
          product_development_id:parseInt(route.query.product_development_id)
        }).then(res =>{
            if(res.code == 1){
              data.expand_list = res.data.data
            }
        })
      }
      return{
        getLocalTime,
        ...toRefs(data),
        GetProductDatalData,
        GoBack
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