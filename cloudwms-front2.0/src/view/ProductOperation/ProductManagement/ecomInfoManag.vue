<template>
    <div class="ecomInfoManag_header">
      <div class="ecomInfoManag_search--list flex align-center">
          <div class="label">关键词：</div>
          <el-input placeholder="请输入商品名称" v-model="title"></el-input>
      </div>
      <div class="leftSearch" >
        <div class="searchLa">SKU：</div>
        <el-input prefix-icon="el-icon-search" v-model="sku"></el-input>
      </div>
      <!-- 第二个 -->
      <div class="leftSearch" >
        <div class="searchLa">状态：</div>
        <el-select v-model="status"  multiple-limit="0" clearable >
          <el-option label="销售中" :value="0"></el-option>
          <el-option label="已下架" :value="1"></el-option>
          <el-option label="未上架" :value="2"></el-option>
          <el-option label="采购中" :value="3"></el-option>
        </el-select>
      </div>
      <!-- 第一个 -->
      <div class="leftSearch">
        <div class="searchLa">分类：</div>
        
        <el-select v-model="category_id" clearable >
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
      <div class="ecomInfoManag_search--list flex align-center">
          <el-button type="primary" @click="Getlist">查询</el-button>
          <el-button @click="Init()">重置</el-button>
      </div>
    </div>
    <!-- 中间新增 -->
    <div class="product_integration--btn--list flex">
        <el-button type="primary" class="el-icon-plus" @click="AddVisible('新增')">新增</el-button>
        <el-dropdown trigger="click" class="product_integration_dropdown" @command="handleCommand">
              <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <template #dropdown>
                <el-dropdown-menu >
                  <el-dropdown-item command="批量删除">
                   批量删除
                  </el-dropdown-item>
                  <el-dropdown-item command="批量删除">
                   批量删除
                  </el-dropdown-item>
                </el-dropdown-menu>
              </template>
          </el-dropdown>
      </div>
    <div class="ecomInfoManag">
      <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="亚马逊平台" name="first">
          <div class="table_backCol">
            <!-- 表格 -->
            <div class="itemList">
              <el-table :data="AmzonData" style="width: 100%" :border="true" @select="HandSelect" @select-all="HandSelectAll">
                <el-table-column type="selection" width="55"> </el-table-column>
                <el-table-column label="图片" prop="url" align="center">
                  <template #header>
                      <span class="url_img">
                        <el-tooltip  content="点击下面图片查看更多图片"  placement="top"><i class="el-icon-warning"></i></el-tooltip>
                        图片
                      </span>
                  </template>
                  <template #default="scope">
                    <el-image
                      style="width: 80px; height: 80px"
                      :src="scope.row.images.length >0?scope.row.images[0].src:''"
                      :preview-src-list="scope.row.pre_img_list"
                    >
                    </el-image>
                  </template>
                </el-table-column>
                <el-table-column
                  label="编号"
                  prop="id"
                  align="center"
                  @rowIndex="lastRow"
                  width="70"
                >
                </el-table-column>
                <el-table-column
                  label="产品标题"
                  prop="a_title"
                  align="center"
                ></el-table-column>
                <el-table-column label="SKU" prop="sku" align="center" width="300px">
                  <template #default="scope">
                    <div style="text-align:left;display:flex;flex-wrap:wrap;">
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
                    </div>
                  </template>
                </el-table-column>
                <el-table-column
                  label="产品类目"
                  prop="category_name"
                  align="center"
                  sortable
                >
                </el-table-column>
                <!-- 状态:0=销售中,1=已下架,2=未上架,3=采购中	 -->
                <el-table-column label="商品状态" prop="status" align="center" >
                  <template #default="scope">
                    <el-tag :type="scope.row.status == 0?'success':scope.row.status == 1?'info':scope.row.status == 2?'warning':''">
                      {{scope.row.status == 0?'销售中':scope.row.status == 1?'已下架':scope.row.status == 2?'未上架':'采购中'}}
                    </el-tag>
                  </template>
                </el-table-column>
                <el-table-column
                  label="价格"
                  prop="rePrice"
                  align="center"
                  width="150px"
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
                <el-table-column label="库存" prop="inStock" align="center">
                  <template #default="scope">
                    <div class="stock_list" v-for="(item,index) in scope.row.inventory" :key="index">
                      {{ item.name }}：<span >{{item.stock}}</span>
                    </div>
                  </template>
                </el-table-column>
                <el-table-column fixed="right" label="操作"  prop="operate"  size="small"  width="200px"  align="center">
                  <template v-slot="scope">
                    <div class="tableBtn">
                      <el-link type="primary" plain  size="small"  @click="editVisible(scope.$index,scope.row.id)"  >编辑</el-link>
                      <el-divider direction="vertical"></el-divider>
                      <el-link type="primary" plain  size="small"  @click="DeleteProduct(scope.$index,scope.row.id)" >删除</el-link>
                      <el-divider direction="vertical"></el-divider>
                      <el-link type="primary" plain  size="small"  @click="AmzonDetail(scope.$index,scope.row.id)" >查看详情</el-link>  
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
                :current-page="querInfo.page_num"
                :page-sizes="[10, 20, 30, 100]"
                :page-size="querInfo.per_page_num"
                layout="total, sizes, prev, pager, next, jumper"
                :total="querInfo.total"
              >
              </el-pagination>
            </div>
          </div>
        </el-tab-pane>
        <el-tab-pane label="Shopify" name="second">
          <div class="table_backCol">
            <!-- 表格 -->
            <div class="itemList">
              <el-table :data="tableData" style="width: 100%" :border="true">
                <el-table-column type="selection" width="55"> </el-table-column>
                <el-table-column label="logo" prop="url" align="center">
                  <template #default="scope">
                    <el-image
                      style="width: 80px; height: 80px"
                      :src="scope.row.url"
                      :preview-src-list="scope.row.srcList"
                    >
                    </el-image>
                  </template>
                </el-table-column>
                <el-table-column
                  label="编号"
                  prop="id"
                  align="center"
                  @rowIndex="lastRow"
                >
                </el-table-column>
                <el-table-column
                  label="产品标题"
                  prop="name"
                  align="center"
                ></el-table-column>
                <el-table-column
                  label="产品类目"
                  prop="classiFic"
                  align="center"
                  sortable
                >
                </el-table-column>
                <el-table-column
                  label="价格"
                  prop="rePrice"
                  align="center"
                  width="150px"
                >
                </el-table-column>
                <el-table-column label="库存" prop="inStock" align="center">
                  <template #default="scope">
                    <el-link :underline="false">
                      {{ scope.row.inStock }}
                    </el-link>
                    <el-link :underline="false">
                      {{ scope.row.inStock }}
                    </el-link>
                  </template>
                </el-table-column>

                <el-table-column
                  label="详情"
                  prop="operate"
                  size="small"
                  width="150px"
                  align="center"
                >
                  <template v-slot="scope">
                    <div class="tableBtn">
                      <el-button type="primary"  plain size="small" :id="scope.row.id" >查看详情</el-button>
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
                :current-page="querInfo.page_num"
                :page-sizes="[3, 5, 8, 10]"
                :page-size="querInfo.per_page_num"
                layout="total, sizes, prev, pager, next, jumper"
                :total="this.tableData.length"
              >
              </el-pagination>
            </div>
          </div>
        </el-tab-pane>
        <el-tab-pane label="Ebay" name="third">
          <div class="table_backCol">
            <!-- 表格 -->
            <div class="itemList">
              <el-table :data="lis" style="width: 100%" :border="true">
                <el-table-column type="selection" width="55"> </el-table-column>
                <el-table-column label="logo" prop="url" align="center">
                  <template #default="scope">
                    <el-image
                      style="width: 80px; height: 80px"
                      :src="scope.row.url"
                      :preview-src-list="scope.row.srcList"
                    >
                    </el-image>
                  </template>
                </el-table-column>
                <el-table-column
                  label="编号"
                  prop="id"
                  align="center"
                  @rowIndex="lastRow"
                >
                </el-table-column>
                <el-table-column
                  label="产品标题"
                  prop="name"
                  align="center"
                ></el-table-column>
                <el-table-column
                  label="产品类目"
                  prop="classiFic"
                  align="center"
                  sortable
                >
                </el-table-column>
                <el-table-column
                  label="价格"
                  prop="rePrice"
                  align="center"
                  width="150px"
                >
                </el-table-column>
                <el-table-column label="库存" prop="inStock" align="center">
                  <template #default="scope">
                    <el-link :underline="false">
                      {{ scope.row.inStock }}
                    </el-link>
                    <el-link :underline="false">
                      {{ scope.row.inStock }}
                    </el-link>
                  </template>
                </el-table-column>

                <el-table-column
                  label="详情"
                  prop="operate"
                  size="small"
                  width="150px"
                  align="center"
                >
                  <template v-slot="scope">
                    <div class="tableBtn">
                      <el-button type="primary" plain  size="small" :id="scope.row.id"  >查看详情</el-button>
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
                :current-page="querInfo.page_num"
                :page-sizes="[3, 5, 8, 10]"
                :page-size="querInfo.per_page_num"
                layout="total, sizes, prev, pager, next, jumper"
                :total="this.tableData.length"
              >
              </el-pagination>
            </div>
          </div>
        </el-tab-pane>
        <el-tab-pane label="Shopee" name="fourth">
          <div class="table_backCol">
            <!-- 表格 -->
            <div class="itemList">
              <el-table :data="tableData" style="width: 100%" :border="true">
                <el-table-column type="selection" width="55"> </el-table-column>
                <el-table-column label="logo" prop="url" align="center">
                  <template #default="scope">
                    <el-image
                      style="width: 80px; height: 80px"
                      :src="scope.row.url"
                      :preview-src-list="scope.row.srcList"
                    >
                    </el-image>
                  </template>
                </el-table-column>
                <el-table-column
                  label="编号"
                  prop="id"
                  align="center"
                  @rowIndex="lastRow"
                >
                </el-table-column>
                <el-table-column
                  label="产品标题"
                  prop="name"
                  align="center"
                ></el-table-column>
                <el-table-column
                  label="产品类目"
                  prop="classiFic"
                  align="center"
                  sortable
                >
                </el-table-column>
                <el-table-column
                  label="价格"
                  prop="rePrice"
                  align="center"
                  width="150px"
                >
                </el-table-column>
                <el-table-column label="库存" prop="inStock" align="center">
                  <template #default="scope">
                    <el-link :underline="false">
                      {{ scope.row.inStock }}
                    </el-link>
                    <el-link :underline="false">
                      {{ scope.row.inStock }}
                    </el-link>
                  </template>
                </el-table-column>

                <el-table-column
                  label="详情"
                  prop="operate"
                  size="small"
                  width="150px"
                  align="center"
                  fixed="right"
                >
                  <template v-slot="scope">
                    <div class="tableBtn">
                      <el-button type="primary" plain  size="small" :id="scope.row.id" >查看详情</el-button  >
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
                :current-page="querInfo.page_num"
                :page-sizes="[3, 5, 8, 10]"
                :page-size="querInfo.per_page_num"
                layout="total, sizes, prev, pager, next, jumper"
                :total="this.tableData.length"
              >
              </el-pagination>
            </div>
          </div>
        </el-tab-pane>
      </el-tabs> 
    </div>
    
    <!-- 弹出新增框 -->
    <ecominfomanag-add 
      :dialog_visible="dialog_visible"
      @Close="Close"
    ></ecominfomanag-add>
    <!-- 编辑弹出框 -->
    <ecominfo-mang-edit
      :dialog_visible="edit_dialog_visible"
      @Close="Close"
      ref="ecominfomangedit"
    >

    </ecominfo-mang-edit>
</template>
<script>
import ecominfomanagAdd from "./components/ecominfoMangAdd.vue";
import { GetAmzonProductList,DeleteAmzonProduct } from '@/api/AmazonProduct';
import { netConfig } from "../../../config/net.config";
import { shoElmessage } from '../../../utils/Elmessage';
import {GetProductCategoryList} from '@/api/Addproduct'
import ecominfoMangEdit from "./components/ecominfoMangEdit.vue";
export default {
  components:{
    ecominfomanagAdd,
    ecominfoMangEdit
  },
  data() {
    return {
      title:"",
      status:'',
      sku:"",
      category_id:"",

      //上传图片url
      baseUrl:netConfig.baseURL,
      //弹出框状态
      dialog_visible:false,
      edit_dialog_visible:false,

      editVisi: false,
      activeName: "first",
      editList: {},
      title:"",//dialog标题
      rules: {
        name: [
          { required: true, message: "请输入商品名称", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        category: [
          { required: true, message: "请选择商品类别", trigger: "change" },
        ],
        brand: [
          { required: true, message: "请选择商品品牌", trigger: "change" },
        ],
        supply: [
          { required: true, message: "请选择供应商", trigger: "change" },
        ],
        proSku: [
          { required: true, message: "请输入商品sku", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        stockSku: [
          { required: true, message: "请输入库存sku", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        serialNum: [
          { required: true, message: "请输入序列号", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        material: [
          { required: true, message: "请输入材质", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        use: [
          { required: true, message: "请输入用途", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        customsDeclaration: [
          { required: true, message: "请输入海关报关名", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        customsCode: [
          { required: true, message: "请输入海关编码", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        date1: [
          {
            type: "date",
            required: true,
            message: "请选择日期",
            trigger: "change",
          },
        ],
        date2: [
          {
            type: "date",
            required: true,
            message: "请选择时间",
            trigger: "change",
          },
        ],
        type: [
          {
            type: "array",
            required: true,
            message: "请至少选择一个活动性质",
            trigger: "change",
          },
        ],
        resource: [
          { required: true, message: "请选择活动资源", trigger: "change" },
        ],
        desc: [{ required: true, message: "请填写活动形式", trigger: "blur" }],
      },
      show3: true,

      tableData: [], //总数据
      AmzonData:[],//亚马逊
      //翻页
      querInfo: {
        page_num: 1,
        per_page_num: 10,
        total:"",
      },
      //删除商品列表
      delete_list:[],
    };
  },
  mounted() {
    this.GetProducttypelist();
    this.Getlist();
    
  },
  methods: {
    //初始化
    Init(){
      this.title = '';
      this.sku = '';
      this.category_id = '';
      this.status = ''
      this.Getlist();
    },
    //商品详情
    AmzonDetail(index,id){
      console.log(id)
      this.$router.push({
        path:"/ProductManagement/ecominfoMangDetail",
        query:{
          product_id:id
        }
      })
    },
    //批量删除
    handleCommand(item){
      if(item == '批量删除'){
        const list = [];
        this.delete_list.some((el) => {
            list.push(el.amazon_id) 
        })
        this.DeleteProduct(null,list.join(','))
      }
    },
     //获取商品类型
    GetProducttypelist(){
      GetProductCategoryList({
        company_id:this.$store.state.userinfo.userinfo.company_id,
      }).then(res =>{
          if(res.code == 1){
            this.Product_type_list = res.data.data
          }
      })
    },
    //获取table数据
    Getlist(){
      GetAmzonProductList({
          company_id:this.$store.state.userinfo.userinfo.company_id, //必
          title:this.title,
          sku:this.sku,
          category_id:this.category_id,
          status:this.status,
          ...this.querInfo
      }).then(res =>{
          if(res.code == 1){
            this.querInfo = res.data
            this.AmzonData = res.data.data
            this.AmzonData.some((el) =>{
                el.pre_img_list = [];
                el.images.forEach(element => {
                  el.pre_img_list.push(element.src)
                });
            })
          }
      })
    },
    //关闭弹出框
    Close(item){
      if(item.title == '新增'){
        this.dialog_visible = !this.dialog_visible
        this.Getlist();
      }else if(item.title == '编辑'){
        this.edit_dialog_visible = !this.edit_dialog_visible
        this.Getlist();
      }
    },
    //单选
    HandSelect(item){
      console.log(item)
      this.delete_list = item
      // this.AmzonData.indexOf(item)
    },
    //全选
    HandSelectAll(item){
      console.log(item)
      this.delete_list = item
    },
    //新增弹出框
    AddVisible(){
      this.dialog_visible = true
    },
    //编辑弹出框
    editVisible(index,product_id) {
      this.edit_dialog_visible = true
      this.$refs.ecominfomangedit.Init(product_id);
    },
    // 监听per_page_num改变
    handleSizeChange(newSize) {
      this.querInfo.per_page_num = newSize;
      this.Getlist();
    },
    // 监听page_num的改变
    handleCurrentChange(newPage) {
      this.querInfo.page_num = newPage;
      this.Getlist();
    },
    //删除Product
    DeleteProduct(index,Id){
      DeleteAmzonProduct({
        company_id:this.$store.state.userinfo.userinfo.company_id, //必
        product_ids:Id
      }).then(res => {
          if(res.code == 1){
              shoElmessage(true,'删除成功')
              this.Getlist();
          }else{
              shoElmessage(true,`删除失败,原因${res.msg}`,'error')
          }
      })
    }
  },
};
</script>

<style scoped lang="scss">
.ecomInfoManag_header{
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .ecomInfoManag_search--list{
    margin: 5px;
    .label{
      width: 70px;
      text-align: right;
    }
    .el-input{
      width: auto;
    }
  }
}
// 中间新增
.product_integration--btn--list{
  margin: 15px 0px;
  :deep(.product_integration_dropdown){
    margin-left: 10px;
  }
}
.ecomInfoManag{
  padding: 20px;
  background-color: #fff;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
}
.add {
  margin: 15px 0px;
  .el-select {
    padding: 5px;
    width: 150px;
  }
  ::-webkit-input-placeholder {
    color: #606266;
    font-size: 14px;
    // font-weight: bolder;
  }
}
.el-dialog_title{
  width: 100%;
  display: flex;
  justify-content: space-between;
  font-size: 18px;
  cursor: pointer;
  .icon_list{
    display: flex;
    align-items: center;
    .screenfull{
      padding: 0px 10px;
      display: flex;
      align-items: center;
    }
    i{
      font-size: 20px;
      color: #000;
      font-weight: bold;
    }
  }
}
// 分页
.pagination-list{
  padding: 15px 0px;
}
.table_backCol{

  .itemList{
    .rePrice_title{
      color: red;
      font-size: 18px;
    }
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
//按钮
.tableBtn{
  .el-button{
    margin-top: 10px;
  }
}
//图片
.url_img{
  cursor: pointer;
  i{
    color: rgb(255, 187, 0);
  }
}
.leftSearch {
      margin: 5px;
      display: flex;
      align-items: center;
      .el-input{
        flex:1;
      }
    }
</style>
