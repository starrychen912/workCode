<template>
  <!-- 头部 -->
  <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">分类：</div>
      <el-select v-model="search_from.type" >
        <el-option  v-for="item in Product_type_list"  :key="item.id"  :label="item.name"  :value="item.id"  style="display: flex"></el-option>
      </el-select>
    </div>
    <div class="brandMan_list flex align-center">
      <div class="label">对应类型：</div>
      <el-select v-model="search_from.type_id" >
        <el-option  v-for="item in Product_type_list"  :key="item.id"  :label="item.name"  :value="item.id"  style="display: flex"></el-option>
      </el-select>
    </div>
    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input  placeholder="请输入关键字"  style="flex: 1"  v-model="search_from.title"></el-input>
    </div>
    <div class="brandMan_list flex align-center">
      <div class="label">状态：</div>
      <el-select v-model="search_from.status" placeholder="请选择类型">
         <el-option label="待处理" value="0"></el-option>
        <el-option label="处理中" value="1"></el-option>
        <el-option label="已处理" value="2"></el-option>
        <el-option label="已关闭" value="3"></el-option>
      </el-select>
    </div>
     <div class="brandMan_list flex align-center">
      <div class="label">时间：</div>
      <el-date-picker
        v-model="search_from.Time"
        type="datetimerange"
        :picker-options="pickerOptions"
        range-separator="至"
        start-placeholder="开始日期"
        end-placeholder="结束日期"
        value-format="x"
        align="right">
      </el-date-picker>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary" @click="SelectClick">查询</el-button>
      <el-button @click="Reset">重置</el-button>
    </div>
  </div>
  <!-- 中间新增 -->
  <div class="product_integration--btn--list flex">
    <el-button type="primary" @click="editVisible()">添加采购</el-button>

    <el-dropdown
      trigger="click"
      class="product_integration_dropdown"
      @command="Command"
    >
      <el-button>
        更多操作<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <template #dropdown>
        <el-dropdown-menu>
          <el-dropdown-item command="a"> 批量删除 </el-dropdown-item>
        </el-dropdown-menu>
      </template>
    </el-dropdown>
  </div>
  <!-- 表格 -->
  <div class="table_backCol">
    <!-- 表格 -->
    <el-table :data="lis" style="width: 100%" :border="true" :expand-row-keys="expands" :row-key="getRowKeys"  @expand-change="expandChange"  @select-all="SelectAll"  @select="Select">
      <el-table-column type="selection" width="55"> </el-table-column>
      <el-table-column  label="编号" prop="id" width="100px" :align="'center'" sortable>
      </el-table-column>
      <el-table-column  label="采购名称" prop="title"  :align="'center'">
      </el-table-column>
      <el-table-column  label="采购商品列表" prop="order_item" min-width="300px"  :align="'center'">
        <template #header>
            <el-link>商品名称</el-link>
            <el-divider direction="vertical"></el-divider>
            <el-link>sku</el-link>
            <el-divider direction="vertical"></el-divider>
            <el-link>采购数量</el-link>
        </template>
        <template #default="scope">
          <div class="sku_show" v-for="(item,index) in scope.row.order_item" :key="index">
            <el-link type="primary" :underline="false">{{item.title}}</el-link>
            <el-divider direction="vertical"></el-divider>
            <el-tooltip class="item" effect="dark" :content="item.sku" placement="top">
              <div class="sku_popover">{{item.sku}}</div>
            </el-tooltip>
            <el-divider direction="vertical"></el-divider>
            <el-link type="danger" :underline="false">{{item.quantity}}</el-link>
          </div>
        </template>
      </el-table-column>
      <el-table-column  label="采购日期" prop="purchase_date" :align="'center'"  width="100px">
        <template #default="scope">
          <span>{{ getLocalTime(scope.row.purchase_date) }}</span>
        </template>
      </el-table-column>
      <el-table-column  label="采购数量"  prop="purchase_quantity" :align="'center'" width="100px">
      </el-table-column>
      <el-table-column label="订单号" prop="order_sn" min-width="150px"> </el-table-column>
      <el-table-column label="状态" prop="is_check">
        <template #default="scope">
          <el-tag :type="scope.row.is_check == '0' ? 'info' : scope.row.is_check == '1' ? 'success' : scope.row.is_check == '2' ? 'warning' : 'primary'">
          {{ scope.row.is_check == '0'  ? "未采购" : scope.row.is_check == '1' ? "已采购" : scope.row.is_check == '2'? "未收货": "已收货"}}
        </el-tag>
        </template>
      </el-table-column>
      <el-table-column label= "操作" prop="operate" size="small" width="200px" :align="'center'"  fixed="right">
        <template #default="scope">
          <div class="tableBtn">
            <el-link type="primary" size="small" @click="editVisible(scope.row)">编辑</el-link>
            <el-divider direction="vertical"></el-divider>
            <el-link type="primary" size="small" @click="responseVisible(scope.row)">事务</el-link>
            <el-divider direction="vertical"></el-divider>
            <el-link type="primary" size="small" @click="deleteItem(scope.$index, scope.row.id)">删除</el-link>
          </div>
        </template>
      </el-table-column>
      <el-table-column type="expand" label="详情" width="80" fixed="right">
        <template #default="scope">
          <div class="expand_props_list">
            <!-- 基本信息详情 -->
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">基本信息：</div>
              <el-descriptions  class="margin-top"  :column="3"  :size="size" border>
                <el-descriptions-item label="采购编号">{{ expand_list.id}}</el-descriptions-item>
                <el-descriptions-item label="采购名称">{{ expand_list.title}}</el-descriptions-item>
                <el-descriptions-item label="商品SKU">
                  <div v-for="(item, index) in expand_list.order_item" :key="index">
                    <el-link>{{ item.sku }}</el-link>
                  </div>
                </el-descriptions-item>
                <el-descriptions-item label="采购数量">{{expand_list.purchase_quantity}}</el-descriptions-item>
                <el-descriptions-item label="订单号">{{expand_list.order_sn}}</el-descriptions-item>
                <el-descriptions-item label="采购日期">{{getLocalTime(expand_list.purchase_date)}}</el-descriptions-item>
                <el-descriptions-item label="采购类别">{{expand_list.category_name}}</el-descriptions-item>
                <el-descriptions-item label="更新时间">{{getLocalTime(expand_list.update_time)}}</el-descriptions-item>
                <el-descriptions-item label="采购状态">
                  <el-tag :type="expand_list.status == 0 ? 'info' : expand_list.status == 1 ? 'success' : expand_list.status == 2 ? 'warning' :'primary'">
                    {{expand_list.status == 0 ? "未采购" : expand_list.status == 1 ? "已采购" : expand_list.status == 2 ? "未收货"  : "已收货"}}
                  </el-tag>
                </el-descriptions-item>
              </el-descriptions>
            </div>
            <!-- 采购规格描述 -->
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">采购规格列表：</div>
              <el-table border :data="expand_list.order_item">
                <el-table-column label="商品id"  prop="item_id"></el-table-column>
                <el-table-column label="商品名称"  prop="title"></el-table-column>
                <el-table-column label="商品sku" prop="sku"></el-table-column>
                <el-table-column label="商品类别"  prop="category_name"></el-table-column>
                <el-table-column label="采购价" prop="price"></el-table-column>
                <el-table-column label="采购数量"  prop="quantity"></el-table-column>
              </el-table>
            </div>
            <!-- 采购描述 -->
            <div class="expand_stock_list_description">
              <div class="expand_stock_list_description--title">描述：</div>
              <div class="expand_stock_list_description--content" v-html="expand_list.note">

              </div>
            </div>
          </div>
        </template>
      </el-table-column>
    </el-table>
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
  <!-- 新增采购 -->
  <add-purchasing
    :dialog_visible="dialog_visible"
    :WarehouseList="warehouse_list"
    ref="addPurchasing"
    @CloseDialog="DialogClose"
    :user_list="user_list"
    :Product_type_list="Product_type_list"
    :brand_list="brand_list"
    :manufacturing_company_list="manufacturing_company_list"
    :Development_list="Development_list"
    :shop_list="shop_list"
  >
  </add-purchasing>
  <!-- 修改采购 -->
  <revise-purchasing
    :dialog_visible="revise_dialog_visible"
    :WarehouseList="warehouse_list"
    ref="revisePurchasing"
    @CloseDialog="DialogClose"
    :user_list="user_list"
    :Product_type_list="Product_type_list"
    :brand_list="brand_list"
    :manufacturing_company_list="manufacturing_company_list"
    :Development_list="Development_list"
    :shop_list="shop_list"
  >
  </revise-purchasing>
  <char-panel :chatpanelVisible="chatpanelVisible" @CharDialogClose="CommonCloseDialog" ref="charpanel" :responsible_person_list="user_list"></char-panel>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { getLocalTime, isNaLL,FilterProductType } from "../../utils/utils";
import Chat from "../affair/components/chat.vue";
import { GettransactionList, DeleteTransaction } from "@/api/transaction.js";
import { GetwarehouseList } from "@/api/warehouseList";
import addPurchasing from "./components/addPurchasing.vue";
import revisePurchasing from "./components/revisePurchasing.vue";
import CharPanel from '../ProductOperation/productIntegration/components/CharPanel.vue';// 事务组件
import { shoElmessage } from "../../utils/Elmessage";
import {  purchaseList,purchaseUpdate,purchaseDetail,deletePurchaseList,} from "@/api/purchasingMan";
import draggable from "vuedraggable";
import { companyUserList } from '@/api/memberCom';
import { GetBrandlist } from "@/api/brandManagement";
import { GetSupplierList } from "@/api/supplierManagement";
import {GetProductCategoryList} from '@/api/Addproduct'
import { GetproductDevelopmentList } from '@/api/productDevelopmentList'
import {  ShopList } from "@/api/shoplist";
export default {
  components: {
    Sidebar,
    addPurchasing,
    draggable,
    revisePurchasing,
    Chat,
    CharPanel
  },
  data() {
    return {
      search_from:{
        type:"",
        type_id:"",
        date_picker:"",
        status:"",
        startTime:"",
        endTime:"",
        title:"",
        Time:"",
      },

      chatpanelVisible:false,//事务列表
      title: "", // 关键字
      editVisi: false,
      responseVisi: false,
      editList: [],
      //弹出框
      dialog_visible: false,
      //修改商品弹出框
      revise_dialog_visible: false,
      lis: [],

      querInfo: { },//分页
      value12: "",
      checkList: ["复选框 A"],
      //选中展开
      expands: [],

      getRowKeys(row) {
        return row.id;
      },
      //折叠展开
      expand_list: [],
      Product_type_list: [], //商品分类列表
      warehouse_list: [], //创库列表
      brand_list:[],//品牌列表
      manufacturing_company_list:[],//供应商列表
      Development_list:[],//产品研发列表
      Delete_list: [],//批量删除文件
      user_list:[],
      affairData: [],// 对话列表
      isFullscreen: false,
      shop_list:[],
    };
  },
  mounted() {
    this.Getlist();
    // 仓库列表
    //事务
    this.Getwarehouse_List();
  },
  methods: {
    SelectClick(){
      this.search_from.startTime = this.search_from.Time[0] / 1000
      this.search_from.endTime = this.search_from.Time[1] / 1000
      // delete this.search_from.Time
      this.Getlist();
    },
    Reset(){
      this.search_from = {
        type:"",
        type_id:"",
        date_picker:"",
        status:"",
        startTime:"",
        endTime:"",
        title:"",
        Time:"",
      }
    },
    CommonCloseDialog(){
      this.chatpanelVisible = false
    },
    getLocalTime(item) {
      return getLocalTime(item);
    },
    // 父组件的方法 更改值
    DialogClose(item) {
      this.$data[item.item] = !this.$data[item.item];
      this.Getlist();
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
      //获取商品类型
        GetProductCategoryList({
            company_id:this.$store.state.userinfo.userinfo.company_id,
        }).then(res =>{
            if(res.code == 1){
              this.Product_type_list = FilterProductType(res.data.data,'children') 
            }
        })
      //获取品牌列表
        GetBrandlist({
          company_id:this.$store.state.userinfo.userinfo.company_id,
        }).then(res =>{
            if(res.code == 1){
              this.brand_list = res.data.data
            }
        })
        //产品研发
        GetproductDevelopmentList({
          company_id:this.$store.state.userinfo.userinfo.company_id,
        }).then(res =>{
            if(res.code == 1){
              this.Development_list = res.data.data
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
        purchaseList({
          company_id: this.$store.state.userinfo.userinfo.company_id,
          ...this.search_from,
          page_num: this.querInfo.pagenum,
          per_page_num: this.querInfo.pagesize,
        }).then((res) => {
          if (res.code == 1) {
            this.lis = res.data.data;
            this.data = res.data;
            this.querInfo.total = res.data.total;
            this.querInfo.pagenum = res.data.cur;
            this.querInfo.pagesize = res.data.size;
          }
        });
    },
    //获取库存sku列表
    Getwarehouse_List() {
      GetwarehouseList({
        company_id: this.$store.state.userinfo.userinfo.company_id,
      }).then((res) => {
        if (res.code == 1) {
          this.warehouse_list = res.data.data;
        }
      });
      companyUserList({
          company_id: this.$store.state.userinfo.userinfo.company_id,
      }).then((res) => {
        if (res.code == 1) {
          this.user_list = res.data.data;
        }
      });
    },
    //获取商品类型
    // GetProducttypelist() {
    //   GetProductCategoryList({
    //     // company_id: this.$store.state.userinfo.userinfo.company_id,
    //   }).then((res) => {
    //     if (res.code == 1) {
    //       this.Product_type_list = res.data.data;
    //     }
    //   });
    // },
    //查看详情
    expandChange(row, expandedRows) {
      this.expands = [];
      if (expandedRows.length > 0) {
        row ? this.expands.push(row.id) : "";
      }
      purchaseDetail({
        order_id: row.id,
      }).then((res) => {
        if (res.code == 1) {
          this.expand_list = res.data.data;
        }
      });
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
    deleteItem(index, rowData) {
      deletePurchaseList({ order_ids: rowData }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "删除成功");
          this.Getlist();
          // this.tableData.splice(index, 1);
        } else {
          shoElmessage("el-icon-warning", "删除失败", "error");
        }
      });
    },
    //全选
    SelectAll(item) {
      this.Delete_list = item;
    },
    //单选
    Select(item) {
      this.Delete_list = item;
    },
    // 批量删除
    Command(command) {
      if (command == "a") {
        if (this.Delete_list.length != 0) {
          let item = [];
          this.Delete_list.forEach((el) => {
            item.push(el.id);
          });
          this.deleteItem("批量删除", item.join());
        } else {
          shoElmessage("el-icon-warning", "请选择删除列表", "error");
        }
      }
    },
    //新增采购并修改采购
    editVisible(item) {
      this.ruleForm = {};
      //修改
      if (isNaLL(item)) {
        this.$refs.revisePurchasing.Init(item.id);
        // console.log(item,'111')
        this.revise_dialog_visible = true;
      } else {
        //新增
        this.$refs.addPurchasing.Init();
        this.dialog_visible = true;
      }
    },
    //回应弹框
    responseVisible(item) {
      this.editList = [];
      this.editList = item;
      this.chatpanelVisible = true;
      this.$refs.charpanel.Init({
        id:item.id,
        type:2,
      })
    },
    Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    Close() {
      this.responseVisi = !this.responseVisi;
    },
  },
};
</script>
<style lang="scss">
.popover_img--list {
  width: auto !important;
}
.popover_img--list img {
  padding: 10px;
  width: 200px;
  height: 200px;
}
.el-dialog__header {
  border-bottom: 1px solid #eee;
}
.el-dialog__body {
  padding: 20px;
}
.el-dialog__footer {
  border-top: 1px solid #eee;
}

.el-textarea__inner {
  height: 100%;
}
</style>
<style scoped lang="scss">
.sku_show{
  display: flex;
  align-items: center;
  justify-content: center;
}
.sku_popover{
  width: 50px;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  cursor: pointer;
}
p {
  font-size: 12px;
  margin: 0px;
}
a {
  text-decoration: none;
  // font-size: 10px;
  color: #007185;
}

.brandMan_header {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .brandMan_list {
    margin: 5px;
    .label {
      width: 70px;
      text-align: right;
    }
  }
}
// 中间新增
.product_integration--btn--list {
  margin: 15px 0px;
  :deep(.product_integration_dropdown) {
    margin-left: 10px;
  }
}
// 商品列表
.table_backCol {
  background-color: $navBg;
  background-color: #fff;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .pagination-list {
    padding: 15px 0px;
  }
  .picHov {
    width: 250px;
    height: 150px;
    position: absolute;
    z-index: 22;
    display: none;
    margin: -38px 0 0 110px;
  }
  .sc:hover .picHov {
    display: block;
  }
}

// expand
.expand_props_list {
  padding: 20px;
  .expand_stock_list {
    .expand_stock_list--title {
      padding: 10px 0px;
      font-weight: bold;
    }
  }
}
.expand_stock_list_description {
  background-color: #fafafa;
  padding: 20px;
  margin-top: 20px;
  .expand_stock_list_description--title {
    padding-bottom: 20px;
    font-weight: bold;
    word-spacing: 5px;
  }
}

// 分页
.el-dialog_title {
  width: 100%;
  display: flex;
  justify-content: space-between;
  font-size: 18px;
  cursor: pointer;
  .icon_list {
    display: flex;
    align-items: center;
    .screenfull {
      padding: 0px 10px;
      display: flex;
      align-items: center;
    }
    i {
      font-size: 20px;
      color: #000;
      font-weight: bold;
    }
  }
}
.el-dialog {
  .el-form {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    .colForm {
      width: 300px;
    }
  }
  .el-textarea {
    height: 200px;
  }
}
.bottomOperate {
  padding: 20px 0;
  text-align: right;
}
.textarea {
  margin-top: 20px;
}
.textarea_title {
  padding: 10px 0px;
}
.sku-input {
  border: 1px solid red;
}
</style>