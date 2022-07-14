<template>
  <!-- 头部 -->
  <div class="productInfo_header">
    <div class="product_info--list flex align-center">
      <div class="label">库存地点：</div>
      <el-select v-model="value1">
        <el-option
          v-for="item in options1"
          :key="item.value"
          :label="item.label"
          :value="item.value"
          style="display: flex"
        >
        </el-option>
      </el-select>
    </div>
    <div class="product_info--list flex align-center">
      <div class="label">日期：</div>
      <el-date-picker v-model="value1" type="date" placeholder="选择日期">
      </el-date-picker>
    </div>
    <div class="product_info--list flex align-center">
      <div class="label">关键字：</div>
      <el-input
        placeholder="请输入商品名称"
        style="flex: 1"
        v-model="title"
      ></el-input>
    </div>

    <div class="product_info--list flex align-center">
      <el-button> 等待收货 </el-button>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="product_info--list">
      <el-button type="primary" @click="Getlist">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <!-- 中间新增 -->
  <div class="product_integration--btn--list flex">
    <el-button type="primary" class="el-icon-plus">批量收货</el-button>
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
    <div class="itemList">
      <el-table
        ref="multipleTable"
        :data="lis"
        tooltip-effect="dark"
        style="width: 100%"
        @selection-change="handleSelectionChange"
        :row-class-name="tableRowClassName"
        @select-all="SelectAll"
        @select="Select"
        :border="true"
      >
        <el-table-column
          type="selection"
          width="55"
          align="center"
          tooltip-effect="dark"
        >
        </el-table-column>
        <el-table-column label="编号" prop="id" width="100px" align="center">
        </el-table-column>
        <el-table-column label="标题" prop="title" align="center">
        </el-table-column>
        <el-table-column label="收货日期" prop="receiving_date" align="center">
          <template #default="scope">
            {{ getLocalTime(scope.row.receiving_date) }}
          </template>
        </el-table-column>
        <el-table-column
          label="收货数量"
          prop="receiving_quantity"
          align="center"
          width="100px"
        >
        </el-table-column>
        <el-table-column label="货单号" prop="order_sn" align="center">
        </el-table-column>
        <el-table-column label="状态" prop="is_check" align="center">
          <template #default="scope">
            <el-tag :type="parseInt(scope.row.purchase_status) == 3 ? 'success' : 'error'">
             {{parseInt(scope.row.purchase_status) == 3 ? "已收货" : "未收货"}}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column label="收货仓库" prop="warehouse_name" align="center">
        </el-table-column>
        <el-table-column label="库存" prop="quantity" align="center">
        </el-table-column>
        <el-table-column
          label="操作"
          prop="operate"
          size="small"
          width="150px"
          align="center"
        >
          <template v-slot="scope">
            <div class="tableBtn">
              <template >
                <el-link
                  type="primary"
                  size="small"
                  @click="checkIdFun(scope.row)"
                  v-if="scope.row.purchase_status == '3'"
                  >确认收货</el-link>
                <el-divider direction="vertical"></el-divider>
              </template>
              <el-link
                type="primary"
                size="small"
                @click="deleteItem(scope.$index, scope.row.id)"
                >删除</el-link>
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <el-dialog
      v-model="confirmVisi"
      width="30%"
      top="10%"
      :before-close="handleClose"
      :show-close="false"
    >
      <template #title>
        <div class="el-dialog_title">
          <div class="title">确认收货</div>
          <div class="icon_list">
            <i class="el-icon-close" @click="Close"></i>
          </div>
        </div>
      </template>
      <el-form ref="confirmlist" :model="confirmList" :rules="rules">
        <el-form-item
          label="收货数量："
          label-width="18%"
          prop="receiving_quantity"
        >
          <el-input v-model="confirmList.receiving_quantity"></el-input>
        </el-form-item>
      </el-form>
      <template #footer class="el-dialog-footer">
        <el-button @click="Close">取消</el-button>
        <el-button @click="confirmReceipt('confirmlist')" type="primary"
          >确定</el-button
        >
      </template>
    </el-dialog>
    <!-- 分页 -->
    <div class="pagination-list">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="querInfo.pagenum"
        :page-sizes="[3, 5, 8, 10]"
        :page-size="querInfo.pagesize"
        layout="total, sizes, prev, pager, next, jumper"
        :total="querInfo.total"
      >
      </el-pagination>
    </div>
  </div>
  <!-- </el-main>
  </el-container> -->
</template>
<script>
// import datalist from '../../utils/data.js'
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import {
  receivingList,
  purchaseUpdate,
  deleteReceiving,
} from "../../api/receiving";
import { getLocalTime, isNaLL } from "../../utils/utils";
import { shoElmessage } from "@/utils/Elmessage";
import { shoElMessageBox } from "../../utils/Elmessage";

export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      // 关键字
      title: "",
      value1: [],
      keyWord: "",
      options1: [
        {
          value: "选项1",
          label: "全部",
        },
        {
          value: "选项2",
          label: "深圳",
        },
        {
          value: "选项3",
          label: "中山",
        },
        {
          value: "选项4",
          label: "北京 ",
        },
        {
          value: "选项5",
          label: "MV",
        },
      ],
      // 弹框
      editVisi: false,
      isFullscreen: false,
      rules: {
        receiving_quantity: [
          { required: true, message: "必填项", trigger: "blur" },
        ],
        receiving_date: [
          {
            type: "date",
            required: true,
            message: "Please pick a date",
            trigger: "change",
          },
        ],
      },
      tableChecked: [],

      lis: [],
      querInfo: {
        type: 2,
        pagenum: 1,
        pagesize: 3,
      },
      checkList: ["复选框 A"],
      Delete_list: [],
      confirmVisi: false,
      confirmList: {},
      order_id: "",
    };
  },
  //生命周期
  mounted() {
    // this.tableData = datalist
    // console.log(datalist);
    this.Getlist();
  },
  created() {
    
    this.value1 = this.options1[0].value;
  },
  methods: {
    getLocalTime(item) {
      return getLocalTime(item);
    },
    Getlist() {
      receivingList({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        title: this.title,
      }).then((res) => {
        if (res.code == 1) {
          this.lis = res.data.data;
          this.querInfo.total = res.data.total;
          this.querInfo.pagenum = res.data.cur;
          this.querInfo.pagesize = res.data.size;
        }
      });
    },
    // 确认收货
    checkIdFun(item) {
      // console.log(id, "....");
      this.confirmVisi = true;
      this.order_id = item.id;
      this.confirmList.receiving_quantity = item.receiving_quantity;
    },
    confirmReceipt(item) {
      this.$refs[item].validate((valid) => {
        if (valid) {
          purchaseUpdate({
            order_id: this.order_id,
            ...this.confirmList,
          }).then((res) => {
            if (res.code == 1) {
              shoElmessage(true, "收货成功");
              this.Getlist();
              this.Close();
            } else {
              shoElmessage("el-icon-warning", "确认失败", "error");
            }
          });
        } else {
          shoElmessage(true, "请输入完整信息", "error");
        }
      });
    },
    // 监听pagesize改变
    handleSizeChange(newSize) {
      this.lis = [];
      this.querInfo.pagesize = newSize;
      this.Getlist();
    },
    // 监听pagenum的改变
    handleCurrentChange(newPage) {
      this.lis = [];
      this.querInfo.pagenum = newPage;
      this.Getlist();
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
          console.log("112");
        } else {
          shoElmessage("el-icon-warning", "请选择删除列表", "error");
        }
      }
    },
    editVisible(item) {
      this.editList = {};
      this.title = "新增收货";
      this.btn_brand = "新增";
      if (isNaLL(item)) {
        this.editList = item;
        this.title = "编辑收货";
        this.btn_brand = "编辑";
        console.log(this.editList);
        // console.log(this.filelist)
      }
      this.editVisi = true;
    },

    Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    Close() {
      this.confirmVisi = !this.confirmVisi;
      this.$refs["confirmlist"].resetFields();
    },
    deleteItem(index, rowData) {
      console.log(rowData);
      deleteReceiving({ order_ids: rowData }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "删除成功");
          this.Getlist();
          // this.tableData.splice(index, 1);
        } else {
          shoElmessage("el-icon-warning", "删除失败", "error");
        }
      });
    },
  },
};
</script>
<style lang="scss">
.dialog_member {
  .el-dialog__header {
    border-bottom: 1px solid #eee;
  }
  .el-dialog__body {
    padding: 20px;
  }
  .el-dialog__footer {
    border-top: 1px solid #eee;
  }
}
</style>
<style scoped lang="scss">
p {
  font-size: 12px;
  margin: 0px;
}
a {
  text-decoration: none;
  font-size: 10px;
  color: #007185;
}

//顶部banner
.productInfo_header {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .product_info--list {
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
  background-color: #fff;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  // 分页
  .pagination-list {
    padding: 15px 0px;
  }
}
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
// 分页
</style>