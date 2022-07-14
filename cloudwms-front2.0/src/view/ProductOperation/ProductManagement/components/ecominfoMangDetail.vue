<template>
    <div class="expand_props_list--header flex align-center">
        <i class="el-icon-back" @click="GoBack()"></i>
        <div>商品详情</div>
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
                <el-descriptions-item  label="亚马逊商品名称">{{expand_list.a_title}}</el-descriptions-item>
                <el-descriptions-item  label="商品名称">{{expand_list.title}}</el-descriptions-item>
                <el-descriptions-item label="商品SKU">{{expand_list.sku}}</el-descriptions-item>
                <el-descriptions-item label="库存SKU">{{expand_list.inventory_sku}}</el-descriptions-item>
                <el-descriptions-item label="原价">{{expand_list.compare_at_price}}</el-descriptions-item>
                <el-descriptions-item label="成本价">{{expand_list.cost}}</el-descriptions-item>
                <el-descriptions-item label="市场价">{{expand_list.market_price}}</el-descriptions-item>
                <el-descriptions-item label="零售价">{{expand_list.retail_price}}</el-descriptions-item>
                <el-descriptions-item label="品牌名称">{{expand_list.brand_name}}</el-descriptions-item>
                <el-descriptions-item label="序列号">{{expand_list.encoding}}</el-descriptions-item>
                <el-descriptions-item label="商品类型">{{expand_list.category_name}}</el-descriptions-item>
                <el-descriptions-item label="供应商">{{expand_list.supplier_id}}</el-descriptions-item>
                <el-descriptions-item label="创建时间">{{expand_list.create_time}}</el-descriptions-item>
                <el-descriptions-item label="商品状态">
                  <el-tag :type="expand_list.status == 0?'success':expand_list.status == 1?'info':expand_list.status == 2?'warning':''">
                      {{expand_list.status == 0?'销售中':expand_list.status == 1?'已下架':expand_list.status == 2?'未上架':'采购中'}}
                  </el-tag>
                </el-descriptions-item>
              </el-descriptions>
            </div>  

            <div class="expand_stock_list">
              <div class="expand_stock_list--title">BulletPoint：</div>
              <el-descriptions 
                :column="1"
                border
                colon
                direction="vertical"
                >
                <el-descriptions-item width="100px" min-width="100px" :span="2" label="bullet_point1：">{{expand_list.bullet_point1 || '无'}}</el-descriptions-item>
                <el-descriptions-item  label="bullet_point2：">{{expand_list.bullet_point2 || '无'}}</el-descriptions-item>
                <el-descriptions-item  label="bullet_point3：">{{expand_list.bullet_point3 || '无'}}</el-descriptions-item>
                <el-descriptions-item  label="bullet_point4：">{{expand_list.bullet_point4 || '无'}}</el-descriptions-item>
                <el-descriptions-item  label="bullet_point5：">{{expand_list.bullet_point5 || '无'}}</el-descriptions-item>
              </el-descriptions>
            </div> 
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">创库列表：</div>
              <el-table border :data="expand_list.inventory">
                <el-table-column labelStyle="width: 200px" label="Id" prop="id"></el-table-column>
                <el-table-column label="创库名称" prop="name"></el-table-column>
                <el-table-column label="初期库存数" prop="stock"></el-table-column>
                <el-table-column label="最低安全库存数" prop="stock_minimum"></el-table-column>
                <el-table-column label="最高安全库存数" prop="stock_highest"></el-table-column>
              </el-table>
            </div>
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">商品规格列表：</div>
              <el-table border>
                <el-table-column label="Id"></el-table-column>
                <el-table-column label="条码"></el-table-column>
                <el-table-column label="采购价"></el-table-column>
                <el-table-column label="零售价"></el-table-column>
                <el-table-column label="平台价"></el-table-column>
                <el-table-column label="商品重量"></el-table-column>
                <el-table-column label="商品规格"></el-table-column>
                <el-table-column label="包装重量"></el-table-column>
                <el-table-column label="包装规格"></el-table-column>
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
import { GetAmzonProductDetail } from '@/api/AmazonProduct'
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
        GetAmzonProductDetail({
          product_id:parseInt(route.query.product_id)
        }).then(res =>{
            if(res.code == 1){
              data.expand_list = res.data.data
            }
        })
      }
      return{
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