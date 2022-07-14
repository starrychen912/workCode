<template>
  <!-- <el-container>
    <el-header>
      <sidebar></sidebar>
    </el-header>
    <el-main> -->
  <!-- 头部 -->
  <div class="brandMan_header">
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
  <!-- 新增 -->
  <div class="product_integration--btn--list flex">
         <el-button type="primary" @click="editVisible(123)"
        >新增物流</el-button
      >
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
  <el-tabs type="border-card">
    <el-tab-pane label="国内物流">
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
            <el-table-column label="快递公司名" prop="name" align="center">
            </el-table-column>

            <el-table-column
              label="查询地址"
              prop="invoiceNumber"
              align="center"
            >
              <template #default="scope">
                <el-link :underline="false">
                  {{ scope.row.invoiceNumber }}
                </el-link></template
              >
            </el-table-column>
            <el-table-column
              label="状态"
              prop="value"
              width="150px"
              align="center"
            >
              <template #default="scope">
                <el-switch
                  v-model="scope.row.value"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch
              ></template>
            </el-table-column>

            <el-table-column label="备注" prop="reGoods"> </el-table-column>
            <el-table-column
              label="操作"
              prop="operate"
              size="small"
              align="center"
              width="150px"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-button
                    type="success"
                    size="small"
                    @click="editVisible(scope.row)"
                    >编辑</el-button
                  >
                  <el-button
                    type="danger"
                    size="small"
                    @click="deleteItem(scope.$index, lis)"
                    >删除</el-button
                  >
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
            :page-sizes="[3, 5, 8, 10]"
            :page-size="querInfo.pagesize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="this.tableData.length"
          >
          </el-pagination>
        </div>
      </div>
    </el-tab-pane>
    <el-tab-pane label="国内快递">
      <div class="table_backCol">
        <!-- 表格 -->
        <div class="itemList">
          <el-table :data="lis" style="width: 100%" :border="true">
            <el-table-column
              label="编号"
              prop="id"
              width="100px"
              align="center"
              @rowIndex="lastRow"
            >
            </el-table-column>
            <el-table-column label="快递公司名" prop="name" align="center">
            </el-table-column>
            <el-table-column label="查询地址" prop="invoiceNumber"
              ><template #default="scope"
                ><el-link :underline="false">
                  {{ scope.row.invoiceNumber }}
                </el-link></template
              >
            </el-table-column>
            <el-table-column
              label="状态"
              prop="value"
              width="150px"
              align="center"
            >
              <template #default="scope">
                <el-switch
                  v-model="scope.row.value"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch
              ></template>
            </el-table-column>
            <el-table-column label="备注" prop="reGoods"> </el-table-column>
            <el-table-column
              label="操作"
              prop="operate"
              size="small"
              width="150px"
              align="center"
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
                    @click="deleteItem(scope.$index, lis)"
                    >删除</el-link
                  >
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
            :page-sizes="[3, 5, 8, 10]"
            :page-size="querInfo.pagesize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="this.tableData.length"
          >
          </el-pagination>
        </div>
      </div>
    </el-tab-pane>
    <el-tab-pane label="国外物流">
      <div class="table_backCol">
        <!-- 表格 -->
        <div class="itemList">
          <el-table :data="lis" style="width: 100%" :border="true">
            <el-table-column
              label="编号"
              prop="id"
              width="100px"
              align="center"
              @rowIndex="lastRow"
            >
            </el-table-column>
            <el-table-column label="快递公司名" prop="name" align="center">
            </el-table-column>

            <el-table-column label="查询地址" prop="invoiceNumber"
              ><template #default="scope"
                ><el-link :underline="false">
                  {{ scope.row.invoiceNumber }}
                </el-link></template
              >
            </el-table-column>
            <el-table-column
              label="状态"
              prop="value"
              width="150px"
              align="center"
            >
              <template #default="scope">
                <el-switch
                  v-model="scope.row.value"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch
              ></template>
            </el-table-column>
            <el-table-column label="备注" prop="reGoods"> </el-table-column>
            <el-table-column
              label="操作"
              prop="operate"
              size="small"
              align="center"
              width="150px"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-button
                    type="success"
                    size="small"
                    @click="editVisible(scope.row)"
                    >编辑</el-button
                  >
                  <el-button
                    type="danger"
                    size="small"
                    @click="deleteItem(scope.$index, lis)"
                    >删除</el-button
                  >
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
            :page-sizes="[3, 5, 8, 10]"
            :page-size="querInfo.pagesize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="this.tableData.length"
          >
          </el-pagination>
        </div></div
    ></el-tab-pane>
    <el-tab-pane label="国外快递">
      <div class="table_backCol">
        <!-- 表格 -->
        <div class="itemList">
          <el-table :data="lis" style="width: 100%" :border="true">
            <el-table-column
              label="编号"
              prop="id"
              width="100px"
              align="center"
              @rowIndex="lastRow"
            >
            </el-table-column>
            <el-table-column label="快递公司名" prop="name" align="center">
            </el-table-column>
            <el-table-column label="查询地址" prop="invoiceNumber"
              ><template #default="scope"
                ><el-link :underline="false">
                  {{ scope.row.invoiceNumber }}
                </el-link></template
              >
            </el-table-column>
            <el-table-column
              label="状态"
              prop="value"
              width="150px"
              align="center"
            >
              <template #default="scope">
                <el-switch
                  v-model="scope.row.value"
                  active-color="#13ce66"
                  inactive-color="#ff4949"
                >
                </el-switch
              ></template>
            </el-table-column>
            <el-table-column label="备注" prop="reGoods"> </el-table-column>
            <el-table-column
              label="操作"
              prop="operate"
              size="small"
              width="150px"
              align="center"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-button
                    type="success"
                    size="small"
                    @click="editVisible(scope.row)"
                    >编辑</el-button
                  >
                  <el-button
                    type="danger"
                    size="small"
                    @click="deleteItem(scope.$index, lis)"
                    >删除</el-button
                  >
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
  <el-dialog title="修改快递公司" v-model="editVisi">
    <el-descriptions>
      <el-descriptions-item label="快递公司名称 :" class="des">
        <el-input placeholder="请输入内容" v-model="editList.name"> </el-input>
      </el-descriptions-item>
    </el-descriptions>
    <el-descriptions>
      <el-descriptions-item label="查询地址 :" class="des">
        <el-input placeholder="请输入内容" v-model="editList.address">
        </el-input> </el-descriptions-item
    ></el-descriptions>

    <el-descriptions>
      <el-table-column label="状态" prop="value" width="150px" align="center">
        <template #default="scope">
          <el-switch
            v-model="scope.row.value"
            active-color="#13ce66"
            inactive-color="#ff4949"
          >
          </el-switch
        ></template>
      </el-table-column>
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
    <template #footer>
      <div class="dialog-footer">
        <el-button @click="editVisi = false">取 消</el-button>
        <el-button type="primary" @click="editVisi = false">确 定</el-button>
      </div>
    </template>
  </el-dialog>
  <!-- </el-main>
  </el-container> -->
</template>

<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
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
          value: true,
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
          value: true,
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
          value: true,
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
          value: true,
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
          value: true,
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
          value: true,
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
          value: true,
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
          value: true,
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
          value: true,
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
          value: true,
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
      if (item != "") {
        // this.form = [];
        this.editList = item;
      }
      this.editVisi = true;
    },
  },
};
</script>

<style scoped lang="scss">
// 头部
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
.product_integration--btn--list{
  margin: 15px 0px;
  :deep(.product_integration_dropdown){
    margin-left: 10px;
  }
}
.el-tabs--border-card {
  background-color: $navBg;
  background-color: #fff;
  border-radius: 2px;
  // padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .pagination-list {
    padding: 15px 0px;
  }
}
</style>