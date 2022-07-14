<template>
  <div class="content">
      <!-- 头部 -->
      <div class="productintegration_header">
          <div class="product_integration--list flex align-center">
            <div class="label">品牌：</div>
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
          <div class="product_integration--list flex align-center">
            <div class="label">分类：</div>
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
          <div class="product_integration--list flex align-center">
            <div class="label">关键字：</div>
            <el-input placeholder="请输入商品名称" style='flex:1'></el-input>
          </div>
          <div class="product_integration--list flex align-center">
             <el-dropdown trigger="click">
              <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <template #dropdown>
                <el-dropdown-menu >
                  <el-dropdown-item>
                    <router-link to="/productInformation/brandInfo">商品资料品牌</router-link>
                  </el-dropdown-item>
                  <el-dropdown-item>
                    <router-link to="/productInformation/infoClassify">商品资料分类</router-link>
                  </el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </div>
           <!-- 中间商品搜索栏 -->
          <div class="product_integration--list">
            <el-button type="primary">查询</el-button>
            <el-button>重置</el-button>
          </div>
      </div>
      <!-- 中间搜索 -->
      <div class="product_integration--btn--list flex">
        <el-button type="primary" class="el-icon-plus" @click="addProInt()">新增</el-button>
        <el-dropdown trigger="click" class="product_integration_dropdown">
              <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <template #dropdown>
                <el-dropdown-menu >
                  <el-dropdown-item>
                   批量删除
                  </el-dropdown-item>
                </el-dropdown-menu>
              </template>
          </el-dropdown>
      </div>
      <!-- 表格 -->
      <div class="table_backCol">
        <!-- 表格 -->
        <el-table :data="lis" style="width: 100%" :border="true">
          <el-table-column
            type="selection"
            width="55"
            align="center"
            tooltip-effect="dark"
          >
        </el-table-column>
          <el-table-column
            label="编号"
            prop="id"
            width="100px"
            align="center"
            fixed
          >
            <template #default="scope">
              <el-popover
                v-model:visible="visible"
                trigger="hover"
                placement="bottom-start"
                popper-class="popover_img--list"
              >
                <div>
                  <img
                    :src="scope.row.url"
                    @click="visible = false"
                    alt=""
                    class="picHov"
                  />
                  <img
                    :src="scope.row.url"
                    @click="visible = false"
                    alt=""
                    class="picHov"
                  />
                </div>
                <div>
                  <div>
                    <el-button type="warning" size="small">外观</el-button>
                  </div>
                  <br />
                  <div>
                    <el-button type="danger" size="small">配件</el-button>
                  </div>
                </div>
                <template #reference>
                  <el @click="visible = true">
                    {{ scope.row.id }}
                  </el>
                </template>
              </el-popover>
            </template>
          </el-table-column>

          <el-table-column
            label="商品名"
            prop="name"
            width="300px"
            align="center"
          >
            <template #default="scope">
              <el-link :underline="false">
                {{ scope.row.name }}
              </el-link>
              <div>
                库存SKU：
                <el-link :underline="false">
                  {{ scope.row.sku }}
                </el-link>
              </div>
            </template>
          </el-table-column>
          <el-table-column
            label="采购日期"
            prop="receiptDate"
            align="center"
            width="100px"
          >
          </el-table-column>
          <el-table-column label="品牌" prop="shop"> </el-table-column>
          <el-table-column
            label="评论数"
            prop="num"
            align="center"
            width="100px"
          >
          </el-table-column>
          <el-table-column label="重量" prop="customizeQuantity">
          </el-table-column>

          <el-table-column label="体积" prop="num"> </el-table-column>
          <el-table-column label="商品地址" prop="address"> </el-table-column>
          <el-table-column label="备注" prop="classiFic"> </el-table-column>

          <el-table-column
            label="操作"
            prop="operate"
            size="small"
            width="100px"
            align="center"
          >
          </el-table-column>
        </el-table>
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
  </div>
      <!-- 弹出事物编辑表单 -->
      <el-dialog title="编辑事务" v-model="editVisi">
        <el-descriptions>
          <el-descriptions-item label="商品 :"
            >{{ editList.name }} 现有库存：{{
              editList.num
            }}</el-descriptions-item
          >
          <el-descriptions-item label="库存sku :">{{
            editList.sku
          }}</el-descriptions-item>
        </el-descriptions>
        <el-descriptions>
          <el-descriptions-item label="提醒时间 :">
            <el-date-picker
              v-model="value1"
              type="date"
              placeholder="选择日期"
              size="mini"
            >
            </el-date-picker>
          </el-descriptions-item>
        </el-descriptions>
        <el-descriptions>
          <el-descriptions-item label="备注 :" class="des">
            <el-input
              type="textarea"
              :rows="2"
              placeholder="请输入内容"
              v-model="textarea"
            >
            </el-input>
          </el-descriptions-item>
        </el-descriptions>

        <el-checkbox label="同步到常见问题" border size="mini"> </el-checkbox>

        <template #footer>
          <div class="dialog-footer">
            <el-button @click="editVisi = false">取 消</el-button>
            <el-button type="primary" @click="editVisi = false"
              >确 定</el-button
            >
          </div>
        </template>
      </el-dialog>
      <!-- 弹出事物回应表单 -->
      <el-dialog title="事务回应" v-model="responseVisi">
        <el-descriptions>
          <el-descriptions-item label="商品 :"
            >{{ editList.name }} 现有库存：{{
              editList.num
            }}</el-descriptions-item
          >
          <el-descriptions-item label="库存sku :">{{
            editList.sku
          }}</el-descriptions-item>
        </el-descriptions>
        <el-descriptions>
          <el-descriptions-item label="提醒时间 :">
            <el-date-picker
              v-model="value1"
              type="date"
              placeholder="选择日期"
              size="mini"
            >
            </el-date-picker>
          </el-descriptions-item>
        </el-descriptions>
        <el-descriptions>
          <el-descriptions-item label="回应内容 :" class="des">
            <el-input
              type="textarea"
              :rows="2"
              placeholder="请输入内容"
              v-model="textarea"
            >
            </el-input>
          </el-descriptions-item>
        </el-descriptions>
        <el-link> 附件： </el-link>

        <template #footer>
          <div class="dialog-footer">
            <el-button @click="responseVisi = false">取 消</el-button>
            <el-button type="primary" @click="responseVisi = false"
              >确 定</el-button
            >
          </div>
        </template>
      </el-dialog>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      editVisi: false,
      responseVisi: false,
      editList: [],

      value1: [],
      value2: [],
      value3: [],
      options1: [
        {
          value: "选项1",
          label: "全部",
        },
        {
          value: "选项2",
          label: "无分类",
        },
        {
          value: "选项3",
          label: "消费电子",
        },
        {
          value: "选项4",
          label: "|----耳机配件 ",
        },
        {
          value: "选项5",
          label: "|----耳机架",
        },
        {
          value: "选项6",
          label: "|----耳机线",
        },
        {
          value: "选项7",
          label: "|----耳机头",
        },
      ],
      options2: [
        {
          value: "选项1",
          label: "全部",
        },
        {
          value: "选项2",
          label: "已采购",
        },
        {
          value: "选项3",
          label: "未采购",
        },
        {
          value: "选项4",
          label: "已收货 ",
        },
        {
          value: "选项5",
          label: "未收货",
        },
      ],
      dialogFormVisible: false,
      responTab: false,
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
          price: "20",
          invoiceNumber: "986564652899498",
          channel: "阿里",
        },
      ],
      querInfo: {
        type: 2,
        pagenum: 1,
        pagesize: 3,
      },
      value12: "",
      checkList: ["复选框 A"],
    };
  },
  mounted() {
    this.Getlist();
  },
  created() {
    this.value1 = this.options1[0].value;
    this.value2 = this.options2[0].value;
  },
  methods: {
    Getlist() {
      this.lis = this.tableData.slice(
        this.querInfo.pagesize * (this.querInfo.pagenum - 1),
        this.querInfo.pagesize * this.querInfo.pagenum
      );
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
    // 上移
    upHandle(index) {
      let previousSbiling = this.lis[index - 1];
      this.lis.splice(index - 1, 1);
      this.lis.splice(index, 0, previousSbiling);
    },

    // 下移
    downHandle(index) {
      let target = this.lis[index];
      this.lis.splice(index, 1);
      this.lis.splice(index + 1, 0, target);
    },
    // 监听鼠标是不是移入最后一行
    lastRow(index) {
      console.log(index);
    },
    //路由传参数
    //资料品牌
    brandInfo() {
      this.$router.push({
        path: "/productInformation/brandInfo",
        query: {
          // ...item,
        },
      });
    },
    //商品资料分类
    infoClassify() {
      this.$router.push({
        path: "/productInformation/infoClassify",
        query: {
          // ...item,
        },
      });
    },

    //编辑弹框
    editVisible(item) {
      this.editList = [];
      this.editList = item;
      this.editVisi = true;
    },
    //回应弹框
    responseVisible(item) {
      this.editList = [];
      this.editList = item;
      this.responseVisi = true;
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
</style>
<style scoped lang="scss">
p {
  font-size: 12px;
  margin: 0px;
}
a {
  text-decoration: none;
  // font-size: 10px;
  color: #007185;
}
// 头部
.productintegration_header{
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .product_integration--list{
    margin: 5px;
    .label{
      width: 70px;
      text-align: right;
    }
  }
}
// 中间搜索
.product_integration--btn--list{
  margin: 15px 0px;
  :deep(.product_integration_dropdown){
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
  // 分页
  .pagination-list{
    padding: 15px 0px;
  }
}

</style>