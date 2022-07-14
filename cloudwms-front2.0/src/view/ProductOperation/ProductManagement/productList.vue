<template>
  <!-- 头部 -->
  <div class="search">
    <div class="headbox">
      <!-- 第一个 -->
      <div class="leftSearch">
        <div class="searchLa">分类：</div>
        
        <el-select v-model="search_type" clearable >
          <el-option
            v-for="item in Product_type_list"
            :key="item.id"
            :label="item.name"
            :value="item.id"
            style="display: flex"
          >
          </el-option>
        </el-select>
      </div>
      <div class="leftSearch">
        <div class="searchLa">品牌：</div>
        
        <el-select v-model="brand_id" clearable >
          <el-option
            v-for="item in brand_list"
            :key="item.id"
            :label="item.name"
            :value="item.id"
            style="display: flex"
          >
          </el-option>
        </el-select>
      </div>

      <div class="leftSearch" >
        <div class="searchLa">发货仓库：</div>
        <el-select v-model="warehouse_id" clearable >
          <el-option
            v-for="item in warehouse_list"
            :key="item.id"
            :label="item.name"
            :value="item.id"
            style="display: flex"
          >
          </el-option>
        </el-select>
      </div>
      <div class="leftSearch" v-show="show3">
        <div class="searchLa">SKU：</div>
        <el-input prefix-icon="el-icon-search" v-model="search_sku"></el-input>
      </div>
      <!-- 第三个 -->
      <div class="leftSearch" v-show="show3">
        <div class="searchLa">制造商：</div>
        <el-select v-model="manufacturing_company" clearable >
          <el-option
            v-for="item in manufacturing_company_list"
            :key="item.id"
            :label="item.supplier_name"
            :value="item.id"
            style="display: flex"
          >
          </el-option>
        </el-select>
      </div>

      <!-- 第二个 -->
      <div class="leftSearch" v-show="show3">
        <div class="searchLa">状态：</div>
        <el-select v-model="search_status"  multiple-limit="0" clearable >
          <el-option label="销售中" :value="0"></el-option>
          <el-option label="已下架" :value="1"></el-option>
          <el-option label="未上架" :value="2"></el-option>
          <el-option label="采购中" :value="3"></el-option>
        </el-select>
      </div>

      <div class="leftSearch">
        <div class="searchLa">关键字：</div>
        <el-input prefix-icon="el-icon-search" v-model="keyword"></el-input>
      </div>
        <!-- 中间商品搜索栏 -->
      <div class="leftSearch">
        <el-button type="primary" @click="Getlist">查询</el-button>
        <el-button @click="InitData">重置</el-button>
      </div>
      <div
          class="leftSearch iCol"
          :class="{ show3: show3 }"
          @click="show3 = !show3"
        >
          {{ show3 ? "收缩" : "展开" }}<i class="el-icon-arrow-down"></i>
        </div>
    </div>
  
  </div>
  <!-- 删除按钮 批量操作 -->
  <div class="add flex align-center">
    <el-button type="primary" class="el-icon-plus" @click="editVisible()">新增</el-button>
    <el-dropdown trigger="click" class="product_integration_dropdown" @command="Command($event,'item')">
            <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
            </el-button>
            <template #dropdown>
                <el-dropdown-menu >
                  <el-dropdown-item icon="el-icon-delete">
                   批量删除
                  </el-dropdown-item>
                  <el-dropdown-item icon="el-icon-check">
                   审核
                  </el-dropdown-item>
                  <el-dropdown-item icon="el-icon-circle-close">
                   反审核
                  </el-dropdown-item>
                </el-dropdown-menu>
            </template>
    </el-dropdown>
  </div>
  <div class="table_backCol">
    <!-- 表格 -->
    <div class="itemList">
      <el-table :data="tableData" style="width: 100%" :border="true" :expand-row-keys="expands" :row-key="getRowKeys"  @select-all="SelectAll" @select="Select" @expand-change="expandChange" >
        <el-table-column type="selection" width="55"> </el-table-column>
        <el-table-column
          label="编号"
          prop="id"
          align="center"
          @rowIndex="lastRow"
          width="80"
        >
        </el-table-column>
        <el-table-column label="图片" prop="url" align="center">
          <template #header>
              <span class="url_img">
                <el-tooltip  content="点击图片查看更多"  placement="top"><i class="el-icon-warning"></i></el-tooltip>
                图片
              </span>
          </template>
          <template #default="scope">
            <el-image
              style="cursor: pointer;"
              :src=" scope.row.images[0].src"
              :preview-src-list="scope.row.srcList"
              v-if="scope.row.images.length > 0"
            >
            </el-image>
            <div v-else>
             <svg width="59" height="59" viewBox="0 0 48 48" >
               <g><rect width="48" height="48" fill="#909399" fill-opacity="0.01" stroke-linejoin="round" stroke-width="4" stroke="none" fill-rule="evenodd"/>
                <g transform="translate(5.000000, 8.000000)">
                 <path d="M2,0 L36,0 C37.1045695,-2.02906125e-16 38,0.8954305 38,2 L38,30 C38,31.1045695 37.1045695,32 36,32 L2,32 C0.8954305,32 1.3527075e-16,31.1045695 0,30 L0,2 C-1.3527075e-16,0.8954305 0.8954305,2.02906125e-16 2,0 Z" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" stroke="#909399" fill="none" fill-rule="evenodd"/>
                 <circle stroke-width="4" stroke-linecap="round" cx="9.5" cy="8.5" r="1.5" stroke-linejoin="round" stroke="#909399" fill="none" fill-rule="evenodd"/><path d="M10,16 L15,20 L21,13 L38,26 L38,30 C38,31.1045695 37.1045695,32 36,32 L2,32 C0.8954305,32 2.27508946e-13,31.1045695 2.27373675e-13,30 L2.27373675e-13,26 L10,16 Z" stroke-width="4" fill="#909399" fill-rule="nonzero" stroke-linejoin="round" stroke="#909399"/>
                </g>
                </g>
                 </svg>
            </div>
          </template>
        </el-table-column>
        <el-table-column
          label="商品名称"
          prop="title"
          align="center"
        ></el-table-column>
        <el-table-column label="SKU" prop="sku" align="center" width="300px">
          <template #default="scope">
            <!-- <div style="text-align:left;display:flex;flex-wrap:wrap;">
              商品SKU：
              <el-link :underline="false">
                <div>{{ scope.row.sku }}</div>
              </el-link>
            </div>
            <div style="text-align:left;display:flex;flex-wrap:wrap;">
              库存SKU：
              <el-link :underline="false">
                <div>{{ scope.row.inventory_sku }}</div>
              </el-link>
            </div> -->
            <el-link :underline="false">
                <div>{{ scope.row.inventory_sku }}</div>
            </el-link>
          </template>
        </el-table-column>
        <el-table-column label="库存" prop="inventory" align="center">
          <template #header>
            <div>库存/(个)</div>
          </template>
          <template #default="scope">
            <div class="stock_list" v-for="(item,index) in scope.row.inventory" :key="index">
               {{ item.name }}：<span >{{item.stock}}</span>
            </div>
          </template>
        </el-table-column>
        <el-table-column label="类型" prop="category_name" align="center" >
        </el-table-column>
        <el-table-column
          label="商品价格"
          prop="rePrice"
          align="center"
          width="200px"
        >
          <template #default="scope">
            <div class="product_price--list">
              <span>原价：</span>
              <span class="price-text"><span>￥</span>{{ scope.row.compare_at_price }} </span>
            </div>
            <div class="product_price--list">
              <span>成本价：</span>
              <span class="price-text"><span>￥</span>{{ scope.row.cost }} </span>
            </div>
            <div  class="product_price--list">
              <span> 市场价：</span>
              <span class="price-text"><span>￥</span>{{ scope.row.market_price }} </span>
            </div>
            <div  class="product_price--list">
              <span> 零售价：</span>
              <span class="price-text"><span>￥</span>{{ scope.row.retail_price }} </span>
            </div>
          </template>
        </el-table-column>
        <!-- 状态:0=销售中,1=已下架,2=未上架,3=采购中	 -->
        <el-table-column label="商品状态" prop="category_name" align="center" >
          <template #default="scope">
            <el-tag :type="scope.row.status == 0?'success':scope.row.status == 1?'info':scope.row.status == 2?'warning':''">
              {{scope.row.status == 0?'销售中':scope.row.status == 1?'已下架':scope.row.status == 2?'未上架':'采购中'}}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column label="创建时间" prop="create_time" align="center" >
          <template #default="scope">
            {{getLocalTime(scope.row.create_time)}}
          </template>
        </el-table-column>
        <el-table-column
          label="操作"
          prop="operate"
          size="small"
          width="150px"
          :align="'center'"
          fixed="right"
        >
          <template v-slot="scope">
            <div class="tableBtn">
              <el-link
                type="primary"
                size="small"
                @click="editVisible(scope.row)"
                 
                >编辑</el-link
              >

              <el-divider direction="vertical"></el-divider>

              <el-link
                type="primary"
                size="small"
                @click="deleteItem(scope.$index,scope.row.id)"
                  
                >删除</el-link
              >
            </div>
          </template>
        </el-table-column>
        <el-table-column type="expand" label="详情"  width="80">
          <template #default="scope">
            <div class="expand_props_list">
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
                          <el-image style="width: 100%; height: 100%"  :src="element.src" :preview-src-list="scope.row.srcList"></el-image>
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
                <el-descriptions-item  label="商品名称">{{expand_list.title}}</el-descriptions-item>
                <!-- <el-descriptions-item label="商品SKU">{{expand_list.sku}}</el-descriptions-item> -->
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
              <div class="expand_stock_list--title">创库列表：</div>
              <el-table border :data="expand_list.inventory">
                <el-table-column label="Id" prop="id"></el-table-column>
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
        </el-table-column>
      </el-table>
    </div>
    <!-- 分页 -->
    <div class="pagination-list">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="querInfo.pagenum"
        :page-sizes="[10, 20, 30, 40]"
        :page-size="querInfo.pagesize"
        layout="total, sizes, prev, pager, next, jumper"
        :total="querInfo.total"
      >
      </el-pagination>
    </div>
  </div>
  <!-- 新增商品 -->
  <add-product-list 
    :dialog_visible="dialog_visible"
    :ProductTypeList="Product_type_list"
    :ManufacturingCompanyList="manufacturing_company_list"
    :WarehouseList="warehouse_list"
    :BrandList="brand_list"
    @Close="CloseDialog"
    ref="addproductlist"
    :shop_list="shop_list"
  ></add-product-list>

  <!-- 修改商品 -->
  <revise-product
    :dialog_visible="revise_dialog_visible"
    :ProductTypeList="Product_type_list"
    :ManufacturingCompanyList="manufacturing_company_list"
    :WarehouseList="warehouse_list"
    :BrandList="brand_list"
    @Close="CloseDialog"
    ref="reviseproductlist"
    :shop_list="shop_list"
  >
  </revise-product>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { GetProductList,deleteOwnerProduct } from "@/api/Porductapi";
import { isNaLL,FilterProductType,getLocalTime } from "../../../utils/utils";
import { shoElmessage } from "../../../utils/Elmessage";
import { netConfig } from '@/config/net.config'
import draggable from 'vuedraggable'
import { GetBrandlist } from "@/api/brandManagement";
import { GetSupplierList } from "@/api/supplierManagement";
import {GetProductCategoryList,AddingProduct,GetProductDetail,} from '@/api/Addproduct'
import { GetwarehouseList } from "@/api/warehouseList";
import AddProductList from './components/AddProductList.vue';
import ReviseProduct from './components/ReviseProduct.vue'
import {  ShopList } from "@/api/shoplist";
export default {
  components: {
    Sidebar,
    AddProductList,
    ReviseProduct,
    draggable
  },
  data() {
    return {
      getLocalTime:getLocalTime,
      //搜索TOGGLE
      show3: false,
      keyword:'',
      search_sku:'',//sku
      search_status:'', //状态
      warehouse_id:'', //创库
      manufacturing_company:'', //制造商
      brand_id:'', //品牌查询
      search_type:'', //分类搜索

      Product_type_list:[], //商品分类列表
      warehouse_list:[],  //创库列表
      manufacturing_company_list:[], //制造商列表
      brand_list:[], //品牌列表

      baseUrl:netConfig.baseURL,

      //所有信息
      tableData: [],
      //翻页
      querInfo: {
        total:10,
        pagenum: 1,
        pagesize: 10,
      },

      //弹出框
      dialog_visible:false,
      //修改商品弹出框
      revise_dialog_visible:false,

      //批量删除文件
      Delete_list:[],

      //选中展开
      expands:[],
      
      getRowKeys(row){
        return row.id
      },
      //折叠展开
      expand_list:[],
      
      shop_list:[],
    };
    
  },
  watch:{
    addOnline:{
       handler (newvak, old) {
        console.log(newvak, old)
      },
      immediate: true, //立即监听
      deep: true // 深度监听
    }
  },
  mounted() {
    this.GetProducttypelist();
    this.Getwarehouse_List();
    this.Getlist();
  },
  methods: {
    InitData(){
          this.brand_id = ''
          this.keyword = ''
          this.search_sku = ''
          this.search_status = ''
          this.search_type = ''
          this.warehouse_id = ''
          this.Getlist();
    },
    Getsupplier(id){
      ManufacturingCompanyList.some(el =>{
        return el.id == id;
      })
    },
    //查看详情
    expandChange(row,expandedRows){
       this.expands = []
       if (expandedRows.length > 0) {
          row ? this.expands.push(row.id) : ''
       }
       GetProductDetail({
         product_id:row.id
       }).then(res =>{
          if(res.code == 1){
            this.expand_list = res.data.data
          }
       })
    },
    //获取库存sku列表
    Getwarehouse_List(){
      GetwarehouseList({
        company_id:this.$store.state.userinfo.userinfo.company_id,
      }).then(res =>{
        console.log(res)
         if(res.code == 1){
            this.warehouse_list = res.data.data
         }
      })
    },
    //获取商品类型
    GetProducttypelist(){
      GetProductCategoryList({
        company_id:this.$store.state.userinfo.userinfo.company_id,
      }).then(res =>{
          if(res.code == 1){
            this.Product_type_list = FilterProductType(res.data.data,'children') 
          }
      })
    },
    //新增商品并修改商品
    editVisible(item) {
      this.ruleForm = {};
      //修改
      if (isNaLL(item)) {
        this.$refs.reviseproductlist.Init(item.id);
        this.revise_dialog_visible = true;
      }else{
        //新增
        this.$refs.addproductlist.Init();
        this.dialog_visible = true;
      }
    },
    Getlist() {
      //店铺列表
      ShopList({
        company_id:this.$store.state.userinfo.userinfo.company_id,
      }).then((res) => {
        if (res.code == 1) {
          this.shop_list = res.data.data;
        }
      });
       //获取品牌列表
        GetBrandlist({
          company_id:this.$store.state.userinfo.userinfo.company_id,
        }).then(res =>{
            if(res.code == 1){
              this.brand_list = res.data.data
            }
        })
        //获取供应商
        GetSupplierList({
          company_id:this.$store.state.userinfo.userinfo.company_id,
        }).then(res =>{
            if(res.code == 1){
              this.manufacturing_company_list = res.data.data
            }
        })
       //获取商品列表
        GetProductList({
          company_id:this.$store.state.userinfo.userinfo.company_id,
          brand_id:this.brand_id,
          title:this.keyword,
          sku:this.search_sku,
          status:this.search_status,
          category_id:this.search_type,
          warehouse_id:this.warehouse_id,
          page_num:this.querInfo.pagenum,
          per_page_num:this.querInfo.pagesize,
        }).then((res) =>{
            if(res.code == 1){
              this.tableData = res.data.data
              this.querInfo.total = res.data.total
              this.querInfo.pagenum = res.data.cur
              this.querInfo.pagesize = res.data.size

              this.tableData.forEach((el,key) =>{
                  el.srcList = [];
                  if(el.images){
                    el.images.forEach(item =>{
                      el.srcList.push(item.src)
                    })
                  }
              })
            }
        })
    },
    // 监听pagesize改变
    handleSizeChange(newSize) {
      this.querInfo.pagesize = newSize;
      this.Getlist();
    },
    // 监听pagenum的改变
    handleCurrentChange(newPage) {
      this.querInfo.pagenum = newPage;
      this.Getlist();
    },

    //删除产品列表
    deleteItem(index,rowData) {
      deleteOwnerProduct({product_ids:rowData}).then((res) => {
        if (res.code == 1) {
            shoElmessage(true,'删除成功')
            this.Getlist();
            // this.tableData.splice(index, 1);
        }else{
            shoElmessage('el-icon-warning','删除失败','error')
        }
      });
      
    },
  
    //批量删除
    Command(item){
      if(this.Delete_list.length != 0){
        let item = [];
        this.Delete_list.forEach(el =>{
            item.push(el.id)
        })
        this.deleteItem('批量删除',item.join());
      }else{
        shoElmessage('el-icon-warning','请选择删除列表','error')
      }
    },
    //全选
    SelectAll(item){
      this.Delete_list = item
    },
    //单选
    Select(item){
      this.Delete_list = item
    },
    //关闭弹出框
    CloseDialog(item){
        // this.dialog_visible = false;
        this.$data[item.item] = !this.$data[item.item]
        this.Getlist()
    }
  }, 
};
</script>
<style scoped lang="scss">
p {
  font-size: 14px;
  margin: 0px;
}
a {
  text-decoration: none;
  font-size: 14px;
  color: #007185;
}
//头部搜索框
.search {
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  // margin-bottom: 20px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);

  .headbox {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    width: 100%;
    .searchLa {
      width: 70px;
      text-align: right;
    }
    //具体搜索框
    .leftSearch {
      margin: 5px;
      display: flex;
      align-items: center;
      .el-input{
        flex:1;
      }
    }
  }
  //展开按钮
  .iCol {
    color: #409eff;
    cursor: pointer;
    transition: transform 0.5;
    transform: rotate(0deg);
    margin-left: 10px;
  }
  i{
      margin-left: 5px;
  }
  .show3 {
    i {
      transition: transform 0.5;
      transform: rotate(-180deg);
      margin-left: 5px;
    }
  }
}
// 新增
.add {
  margin-top: 15px;
  margin-bottom: 15px;
  .el-select {
    padding: 5px;
    width: 150px;
  }
  ::-webkit-input-placeholder {
    color: #606266;
    font-size: 14px;
  }
  :deep(.product_integration_dropdown){
    margin-left: 10px;
  }
}

//表格页面下部分内容
.table_backCol {
  background-color: #fff;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.03);
  padding: 20px;
  .demo-table-expand {
    font-size: 0;
    padding: 8px 20px;
  }
  .demo-table-expand label {
    width: 90px;
    color: #99a9bf;
  }
  .demo-table-expand .el-form-item {
    margin-right: 0;
    margin-bottom: 0;
    width: 50%;
  }
  .pagination-list {
    padding: 15px 0px;
  }
}

//库存
.stock_list{
  span{
    color: red;
  }
}
//商品价格
.product_price--list{
  text-align: right;
  .price-text{
    color: rgb(255, 0, 0);
    font-size: 14px;
  }
}
//图片
.url_img{
  cursor: pointer;
  i{
    color: rgb(255, 187, 0);
  }
}
.expand_props_list{
  padding: 20px;
  background-color: #fafafa;
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

</style>
<style lang="scss">
.dialog_productlist{
  .el-dialog__header{

    border-bottom: 1px solid #eee;
  }
  .el-dialog__body{
    padding: 20px;
  }
  .el-dialog__footer{
    border-top: 1px solid #eee;
  }
}
.enlarge_img{
  .el-dialog__body{
    max-height: 90vh;
    overflow: auto;
  }
}
</style>