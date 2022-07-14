<template>
  <!-- 头部 -->

  <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">部门：</div>
      <el-select v-model="value1" style="width: 120px">
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
    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input placeholder="" style="flex: 1"></el-input>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <!-- 中间新增 -->
  <div class="product_integration--btn--list flex">
    <el-button type="primary" @click="editVisible()">添加财务申请</el-button>

    <el-dropdown trigger="click" class="product_integration_dropdown">
      <el-button>
        更多操作<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <template #dropdown>
        <el-dropdown-menu>
          <el-dropdown-item> 批量删除 </el-dropdown-item>
        </el-dropdown-menu>
      </template>
    </el-dropdown>
  </div>
  <el-tabs type="border-card">
    <el-tab-pane label="财务列表">
      <div class="table_backCol">
        <!-- 表格 -->
        <div class="itemList">
          <el-table :data="lis" style="width: 100%" :border="true">
             <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
            <el-table-column
              label="编号"
              prop="id"
              width="100px"
              align="center"
              @rowIndex="lastRow"
            >
            </el-table-column>
            <el-table-column label="名称" prop="name" align="center">
            </el-table-column>
            <el-table-column label="创建人" prop="shop" align="center">
            </el-table-column>
            <el-table-column label="所属部门" prop="name" align="center">
            </el-table-column>
            <el-table-column label="创建时间" prop="receiptDate" align="center">
            </el-table-column>
            <el-table-column label="审核金额" prop="receiptDate" align="center">
              <template v-slot="scope">
                <span v-if="scope.row.shopShow">
                  {{ scope.row.num }}
                </span>
                <span v-else>******</span>
                <i
                  class="el-icon-view"
                  @click="toggleShopShow(scope.$index)"
                ></i>
              </template>
            </el-table-column>
            <el-table-column label="备注" prop="reGoods"> </el-table-column>
            <el-table-column
              type="expand"
              fixed="right"
              label="审核流程"
              width="150px"
            >
              <template #default="scope">
                <div class="steps_list">
                  <el-steps :active="2" align-center finish-status="success">
                    <el-step
                      title="步骤1"
                      description="这是一段很长很长很长的描述性文字"
                    ></el-step>
                    <el-step
                      title="步骤2"
                      description="这是一段很长很长很长的描述性文字"
                    ></el-step>
                    <el-step
                      title="步骤3"
                      description="这是一段很长很长很长的描述性文字"
                    ></el-step>
                    <el-step
                      title="步骤4"
                      description="这是一段很长很长很长的描述性文字"
                    ></el-step>
                  </el-steps>
                </div>
              </template>
            </el-table-column>
            <el-table-column
              label="操作"
              prop="operate"
              size="small"
              align="center"
              width="200px"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-link type="primary" size="small" @click="open"
                    >批准</el-link
                  >
                  <el-divider direction="vertical"></el-divider>
                  <el-link type="primary" size="small" @click="open"
                    >审核</el-link
                  >
                  <el-divider direction="vertical"></el-divider>
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
                    @click="deleteItem(scope.$index, lis)"
                    >删除</el-link
                  >
                </div>
              </template>
            </el-table-column>
          </el-table>
        </div>
        <!-- 责任人 -->
        <el-dialog title="责任人" v-model="responTab">
          <el-checkbox-group v-model="checkList">
            <el-checkbox label="复选框 A"></el-checkbox>
            <el-checkbox label="复选框 B"></el-checkbox>
            <el-checkbox label="复选框 C"></el-checkbox>
          </el-checkbox-group>
        </el-dialog>
        <!-- 弹出表单 -->

        <!-- 分页 -->
        <div class="pagination-list">
          <el-pagination
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            :current-page="querInfo.pagenum"
            :page-sizes="[3, 5, 8, 10]"
            :page-size="querInfo.pagesize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="this.tableData.length"
          >
          </el-pagination>
        </div>
      </div>
    </el-tab-pane>
  </el-tabs>
  <!-- 显示弹框 -->
  <el-dialog title="修改财务信息" v-model="editVisi">
    <el-descriptions>
      <el-descriptions-item label="编号 :" class="des">
        <el-input placeholder="名称" v-model="editList.name"> </el-input>
      </el-descriptions-item>
      <el-descriptions-item label="所属部门 :" class="des"
        ><div class="search_list">
          <el-select v-model="value1" style="width: 120px">
            <el-option
              v-for="item in options1"
              :key="item.value"
              :label="item.label"
              :value="item.value"
              style="display: flex"
            >
            </el-option>
          </el-select></div
      ></el-descriptions-item>
    </el-descriptions>
    <el-descriptions>
      <el-descriptions-item label="创建人 :" class="address">
        <el-input placeholder="请输入内容" v-model="editList.address">
        </el-input>
      </el-descriptions-item>
    </el-descriptions>
    <el-descriptions>
      <el-descriptions-item label="审核金额 :" class="address">
        <el-input placeholder="请输入内容" v-model="editList.num"> </el-input>
      </el-descriptions-item>
    </el-descriptions>
    <el-descriptions>
      <el-descriptions-item label="提交时间 :" class="address">
        <el-date-picker
          v-model="editList.receiptDate"
          type="datetime"
          placeholder="选择日期时间"
        >
        </el-date-picker>
      </el-descriptions-item>
    </el-descriptions>
    <el-descriptions>
      <el-descriptions-item label="商家介绍 :" class="desc">
        <el-input placeholder="请输入内容" v-model="editList.desc"> </el-input>
      </el-descriptions-item>
    </el-descriptions>

    <el-descriptions>
      <el-descriptions-item label="备注 :" class="des">
        <el-input
          type="textarea"
          :rows="2"
          placeholder="请输入内容"
          v-model="editList.reGoods"
        >
        </el-input>
      </el-descriptions-item>
    </el-descriptions>
    <el-descriptions>
      <el-descriptions-item label="属性 :" class="des">
        <el-checkbox v-model="editList.checked">优先</el-checkbox>
      </el-descriptions-item>
    </el-descriptions>

    <template #footer>
      <div class="dialog-footer">
        <el-button @click="editVisi = false">取 消</el-button>
        <el-button type="primary" @click="editVisi = false">确 定</el-button>
      </div>
    </template>
  </el-dialog>
</template>

<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { isNaLL } from "../../utils/utils";
export default {
  components: {
    Sidebar,
  },
  data() {
    return {
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
      editVisi: false,
      lis: [],
      tableData: [
        {
          id: "1360",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          radio: "1",
          checked: true,
          shopShow: false,
        },
        {
          id: "2360",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-02",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          checked: true,
        },
        {
          id: "3360",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",

          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          checked: true,
        },
        {
          id: "4360",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",

          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          checked: true,
        },
        {
          id: "5360",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          category: "江浙小吃、小吃零食",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          checked: true,
        },
        {
          id: "6360",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          checked: true,
        },
        {
          id: "7360",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          checked: true,
        },
        {
          id: "8360",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          checked: true,
        },
        {
          id: "9360",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",
          checked: true,
        },
        {
          id: "1060",
          name: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          enName: "耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
          url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
          category: "江浙小吃、小吃零食",
          desc: "荷兰优质淡奶，奶香浓而不腻",
          address: "上海市普陀区真北路",
          shop: "王小虎夫妻店",
          shopId: "10333",
          sku: "XFDZ-EJP-PJZ-0065-01",
          receipt: "深圳(103238)",
          ship: "中山(213)",
          reGoods: "中山(413)",
          inStock: "中山(2113)",
          classiFic: "配件周边",
          rePrice: "采购:￥3.63",
          receiptDate: "2019-8-2",
          specificDate: "2019-8-2 14:20:05",
          customizeQuantity: "2011",
          num: "22",
          invoiceNumber: "986564652899498",

          //   checked: true,
        },
      ],
      querInfo: {
        type: 2,
        pagenum: 1,
        pagesize: 3,
      },
      checkList: ["复选框 A"],
      editList: {},
    };
  },
  //生命周期
  mounted() {
    this.Getlist();
  },
  created() {
    this.value1 = this.options1[0].value;
  },
  methods: {
    Getlist() {
      this.lis = this.tableData.slice(
        this.querInfo.pagesize * (this.querInfo.pagenum - 1),
        this.querInfo.pagesize * this.querInfo.pagenum
      );
    },
    toggleShopShow(index) {
      this.tableData[index].shopShow = !this.tableData[index].shopShow; //使false变为true显示
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
    deleteItem(index, lis) {
      lis.splice(index, 1);
    },

    editVisible(item) {
      this.editList = {};
      if (isNaLL(item)) {
        // this.form = [];
        this.editList = item;
      }

      this.editVisi = true;
    },

    open() {
      this.$confirm("是否确定批准?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning",
      })
        .then(() => {
          this.$message({
            type: "success",
            message: "成功!",
          });
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "已取消",
          });
        });
    },
  },
};
</script>

<style lang="scss">
.el-input {
  max-width: 700px;
}
</style>
<style scoped lang="scss">
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
.table_backCol {
  background-color: $navBg;
  background-color: #fff;
  border-radius: 2px;
  // padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .tableBtn {
    .el-button {
      margin: 5px;
    }
  }
  .pagination-list {
    padding: 15px 0px;
  }
}
</style>