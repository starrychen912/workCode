<template>
  <!-- <el-container>
      <el-header :class="{'el_header--bg':mode === 'mobile' }"><sidebar ></sidebar></el-header>
      <el-main> -->
  <div class="receipt_header--list">
    <div class="title">店铺状态</div>
    <el-row :span="24" class="flex align-center justify-between">
      <el-col
        :xs="24"
        :sm="24"
        :md="4"
        :lg="4"
        :xl="4"
        class="receipt--list flex align-center justify-between all"
      >
        <span class="receipt_sjx"></span>
        <div class="seceipt_img">
          <img src="../../assets/img/all.png" />
        </div>
        <div class="seceipt_text">
          <div>全部</div>
          <div class="seceipt_span">100</div>
        </div>
      </el-col>
      <el-col
        :xs="24"
        :sm="24"
        :md="4"
        :lg="4"
        :xl="4"
        class="receipt--list flex align-center justify-between"
      >
        <span class="receipt_sjx"></span>
        <div class="seceipt_img">
          <img src="../../assets/img/shenh.png" />
        </div>
        <div class="seceipt_text">
          <div>在线</div>
          <div class="seceipt_span">100</div>
        </div>
      </el-col>
      <el-col
        :xs="24"
        :sm="24"
        :md="4"
        :lg="4"
        :xl="4"
        class="receipt--list flex align-center justify-between warring"
      >
        <span class="receipt_sjx"></span>
        <div class="seceipt_img">
          <img src="../../assets/img/warring.png" />
        </div>
        <div class="seceipt_text">
          <div>离线</div>
          <div class="seceipt_span">100</div>
        </div>
      </el-col>
      <el-col
        :xs="24"
        :sm="24"
        :md="4"
        :lg="4"
        :xl="4"
        class="receipt--list flex align-center justify-between error"
      >
        <span class="receipt_sjx"></span>
        <div class="seceipt_img">
          <img src="../../assets/img/error.png" />
        </div>
        <div class="seceipt_text">
          <div>维护</div>
          <div class="seceipt_span">100</div>
        </div>
      </el-col>
      <el-col
        :xs="24"
        :sm="24"
        :md="4"
        :lg="4"
        :xl="4"
        class="receipt--list flex align-center justify-between success"
      >
        <span class="receipt_sjx"></span>
        <div class="seceipt_img">
          <img src="../../assets/img/success.png" />
        </div>
        <div class="seceipt_text">
          <div>关闭</div>
          <div class="seceipt_span">100</div>
        </div>
      </el-col>
    </el-row>
  </div>
  <!-- 店铺列表 -->
  <!-- 中间新增 -->
  <div class="product_integration--btn--list flex">
    <el-button type="primary" @click="AddStoreshop()">新增店铺</el-button>

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
    <el-table
      :data="datalist"
      style="width: 100%"
      :border="true"
      :expand-row-keys="expands"
      :row-key="getRowKeys"
      @expand-change="expandChange"
      @select-all="SelectAll"
      @select="Select"
    >
      <el-table-column type="selection" width="55"> </el-table-column>
      <el-table-column
        label="编号"
        prop="id"
        width="100px"
        align="center"
        sortable
      >
      </el-table-column>
      <el-table-column
        label="店铺名称"
        prop="name"
        width="300px"
        align="center"
      >
      </el-table-column>
      <el-table-column
        label="店铺域名"
        prop="domain"
        width="300px"
        align="center"
      >
      <template #default="scope">
        <el-link :href="scope.row.domain" target="_blank">链接</el-link>
      </template>
      </el-table-column>
      <!-- <el-table-column
        label="采购sku"
        prop="order_item"
        width="300px"
        align="center"
      >
        <template #default="scope">
          <div v-for="(item, index) in scope.row.order_item" :key="index">
            <el-link v-if="item != null">
              {{ item.sku }}
            </el-link>
          </div>
        </template>
      </el-table-column> -->
      <el-table-column label="店铺地址" prop="address" align="center">
      </el-table-column>
      <el-table-column label="店铺电话" prop="phone" align="center">
      </el-table-column>
      <el-table-column
        label="创建时间"
        prop="create_time"
        align="center"
        width="100px"
      >
        <template #default="scope">
          <span>{{ getLocalTime(scope.row.create_time) }}</span>
        </template>
      </el-table-column>
      <el-table-column
        label="操作"
        prop="operate"
        size="small"
        align="center"
        fixed="right"
      >
        <template v-slot="scope">
          <div class="tableBtn">
            <el-link
              type="primary"
              size="small"
              @click="AddStoreshop(scope.row)"
              >编辑</el-link
            >
            <el-divider direction="vertical"></el-divider>
            <el-link
              type="primary"
              size="small"
              @click="deleteItem(scope.$index, scope.row.id)"
              >删除</el-link
            >
          </div>
        </template>
      </el-table-column>
      <el-table-column type="expand" label="详情" width="80" fixed="right">
        <template #default="scope">
          <div class="expand_props_list">
            <!-- 基本信息详情 -->
            <div class="expand_stock_list">
              <div class="expand_stock_list--title">基本信息：</div>
              <el-descriptions
                class="margin-top"
                :column="3"
                :size="size"
                border
                width="150px"
              >
                <el-descriptions-item label="店铺编号">{{
                  expand_list.id
                }}</el-descriptions-item>
                <el-descriptions-item label="店铺名称">{{
                  expand_list.name
                }}</el-descriptions-item>
                <el-descriptions-item label="店铺地址">
                  {{
                  expand_list.domain
                }}
                
                </el-descriptions-item>
                <el-descriptions-item label="联系方式">{{
                  expand_list.phone
                }}</el-descriptions-item>
                <el-descriptions-item label="店铺邮箱">{{
                  expand_list.email
                }}</el-descriptions-item>
                <el-descriptions-item label="店铺货币">{{
                  expand_list.currency
                }}</el-descriptions-item>
                <el-descriptions-item label="创建日期">{{
                  getLocalTime(expand_list.create_time)
                }}</el-descriptions-item>
                <!-- <el-descriptions-item label="店铺所属人">{{
                  expand_list.shop_owner
                }}</el-descriptions-item> -->
                <!-- <el-descriptions-item label="采购说明">{{
                  expand_list.note
                }}</el-descriptions-item> -->
                <!-- <el-descriptions-item label="供应商">{{expand_list.supplier_id}}</el-descriptions-item> -->
                <!-- <el-descriptions-item label="创建时间">{{expand_list.create_time}}</el-descriptions-item> -->
                <el-descriptions-item label="店铺类型">
                  <el-tag
                    :type="
                      expand_list.type == 'Amazon'
                        ? 'primary'
                        : expand_list.type == 'shopify'
                        ? 'success'
                        : ''
                    "
                  >
                    {{
                      expand_list.type == "Amazon"
                        ? "Amazon"
                        : expand_list.type == 'shopify'
                        ? "shopify"
                        :''
                    }}
                  </el-tag>
                </el-descriptions-item>
              </el-descriptions>
            </div>
            <!-- 采购描述 -->
            <!-- <div class="expand_stock_list_description">
              <div class="expand_stock_list_description--title">描述：</div>
              <div class="expand_stock_list_description--content">
                {{ expand_list.note }}
              </div>
            </div> -->
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
  <!-- 新增组件 -->

  <addstoreshop
    :dialog_visible="dialog_visible"
    ref="editshop"
    @CloseDialog="DialogClose"
  >
  </addstoreshop>
</template>

<script>
import { computed, onMounted, reactive, toRefs, ref } from "vue";
import { deleteShop, ShopList, getShopInfo } from "../../api/shoplist";
import Sidebar from "../../components/Loyout/Sidebar/Sidebar.vue";
import router from "../../router";
import { shoElmessage } from "../../utils/Elmessage";
import { ElMessageBox } from "element-plus";
import { useStore } from "vuex";
import { netConfig } from "../../config/net.config";
import { getLocalTime, isNaLL } from "../../utils/utils";
// 新增
import Addstoreshop from "./componets/Addstoreshop.vue";

export default {
  components: { Sidebar, Addstoreshop },
  setup(props, content) {
    // console.log(props,content);
    const editshop = ref(null);
    const store = useStore();
    const data = reactive({
      datalist: [],
      querInfo: {},
      expand_list: [],
      //弹出框
      dialog_visible: false,
      Delete_list: [],
      baseurl: computed(() => netConfig.baseURL),
      mode: computed(() => store.state.setting.device.mode),
    });

    function AddStoreshop(item) {
      //新增采购并修改采购
      data.dialog_visible = true;
      console.log(item, "item");
      //修改
      if (isNaLL(item)) {
        editshop.value.Init({ title: "修改店铺", id: item.id });
      } else {
        //新增
        editshop.value.Init({ title: "新增店铺" });
      }
    }

    onMounted(() => {
      GetShoplist();
    });
    function GetShoplist() {
      ShopList({
        company_id: store.state.userinfo.userinfo.company_id,
        page_num: data.querInfo.pagenum,
        per_page_num: data.querInfo.pagesize,
      }).then((res) => {
        if (res.code == 1) {
          data.datalist = res.data.data;
          data.querInfo.total = res.data.total;
          data.querInfo.pagenum = res.data.cur;
          data.querInfo.pagesize = res.data.size;
        }
      });
    }
    // 分页
    // 监听pagesize改变
    function handleSizeChange(newSize) {
      data.querInfo.pagesize = newSize;
      console.log(data.querInfo.pagesize);
      GetShoplist();
    }
    // 监听pagenum的改变
    function handleCurrentChange(newPage) {
      data.querInfo.pagenum = newPage;
      GetShoplist();
    }
    // 店铺详情
    function expandChange(row, expandedRows) {
      let expands = [];
      if (expandedRows.length > 0) {
        row ? expands.push(row.id) : "";
      }
      getShopInfo({
        shop_id: row.id,
      }).then((res) => {
        // console.log(res);
        if (res.code == 1) {
          console.log(res.data, "res.data");

          data.expand_list = res.data;
          console.log(data.expand_list);
        }
      });
    }
    // 新增弹框关闭
    function DialogClose(item) {
      data[item.item] = !data[item.item];
      GetShoplist();
    }
    function Amazon(item) {
      // console.log(item);
      let shophome = router.resolve({ path: "/Amazonshop/index", query: item });
      window.open(shophome.href, "_blank");
    }
    //店铺管理
    function Management(item) {
      let Authentication = store.getters["userinfo/Authentication"];
      store.dispatch("storeshop/setShopId", item);
      //  console.log(store.getters['storeshop/shop_id']);
      if (Authentication) {
        let shophome = router.resolve({
          path: "/shop/shophome",
          query: { ...item },
        });
        window.open(shophome.href, "_blank");
      } else {
        if (!isNaLL(store.getters["userinfo/accessToken"])) {
          return shoElmessage(true, "token是空，跳转这里有点问题", "error");
        }
        let data = { ...item, token: store.getters["userinfo/accessToken"] };
        let shophome = router.resolve({ path: "/shop/shophome", query: data });
        window.open(shophome.href, "_blank");
      }
    }
    function deleteItem(index, rowData) {
      deleteShop({ shop_id: rowData }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "删除成功");
          GetShoplist();
          // this.tableData.splice(index, 1);
        } else {
          shoElmessage("el-icon-warning", "删除失败", "error");
        }
      });
    }
    function GetImgItem(item) {
      if (item.type == "shopify") {
        return "@/assets/img/shopfilylse.png";
      } else if (item.type == "amazon") {
        return "@/assets/img/amazion123.png";
      }
    }
    //全选
    function SelectAll(item) {
      data.Delete_list = item;
    }
    //单选
    function Select(item) {
      data.Delete_list = item;
    }
    // 批量删除
    function Command(command) {
      if (command == "a") {
        if (data.Delete_list.length != 0) {
          let item = [];
          data.Delete_list.forEach((el) => {
            deleteItem("批量删除",el.id);
          });
          
        } else {
          shoElmessage("el-icon-warning", "请选择删除列表", "error");
        }
      }
    }
    return {
      AddStoreshop,
      GetShoplist,
      ...toRefs(data),
      deleteItem,
      Management,
      GetImgItem,
      Amazon,
      getLocalTime,
      expandChange,
      handleCurrentChange,
      handleSizeChange,
      DialogClose,
      editshop,
      Command,
      Select,
      SelectAll,
    };
  },
};
</script>

<style scoped lang="scss">
.receipt_header--list {
  padding: 15px;
  border-radius: 10px;
  height: auto;
  background-color: $navBg;
  box-shadow: 0 0px 20px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.03);
  .title {
    font-size: 17px;
    font-weight: bold;
  }
}
.receipt--list {
  padding: 15px;
  height: 100px;
  position: relative;
  &::before {
    content: "";
    background: url("../../assets/img/bj.png");
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}
.error {
  &::before {
    content: "";
    background: url("../../assets/img/bj-error.png");
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}
.warring {
  &::before {
    content: "";
    background: url("../../assets/img/bj-warring.png");
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}
.success {
  &::before {
    content: "";
    background: url("../../assets/img/bj-success.png");
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}
.all {
  &::before {
    content: "";
    background: url("../../assets/img/bj-all.png");
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}

.seceipt_img {
  width: 70px;
  height: 70px;
  // border: 1px solid #000;
  z-index: 111;
  cursor: pointer;

  img {
    width: 100%;
    height: 100%;
    transition: all 0.5s;
    transform: scale(1);
  }
  &:hover {
    img {
      transition: all 0.5s;
      transform: scale(1.4);
    }
  }
}
.seceipt_text {
  // margin-left: ;
  width: 50%;
  z-index: 111;
}
.seceipt_span {
  font-size: 30px;
  font-weight: bold;
}

@media screen and (max-width: 1200px) {
}
@media screen and (max-width: 1450px) {
  .shop_list-store {
    .shop_list-shopinfo {
      flex: none;
      width: 100%;
      margin-left: 0px;
      margin-top: 10px;
    }
  }
}
// .flex::after{
//   content: '';
//   max-width: 29.1666666667%;
//   flex: 0 0 29.1666666667%;
//   display: block;
// }
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
}
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
.table_backCol .pagination-list {
  padding: 10px 0px;
}
</style>