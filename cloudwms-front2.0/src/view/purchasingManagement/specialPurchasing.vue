<template>
  <!-- 商品分类页面 -->
  <!-- <el-container>
    <el-header>
      <sidebar LogoName="商品特殊采购"></sidebar>
    </el-header>
    <el-main> -->
      <!-- 头部 -->
      <div class="bannerTop">
        <!-- 文字跳转链接 -->
        <div class="textLink">
          <div class="leftTips">
            <div class="Amazonproduct_application flex align-center flex-wrap">
              <ul class="application_list flex align-center flex-wrap">
                
                <li><router-link to="/purchasingManagement/addPurchasing">添加特殊采购</router-link></li>
                <el-divider direction="vertical"></el-divider>
                <li><router-link to="/purchasingManagement">商品采购</router-link></li>
                <el-divider direction="vertical"></el-divider>
                <p>特殊采购</p>
                <el-divider direction="vertical"></el-divider>
                <li><router-link to="/purchasingManagement/purchaseOrder">定制采购单</router-link></li>
                <el-divider direction="vertical"></el-divider>
                <li><router-link to="/purchasingManagement/materialPurchasing">物料采购</router-link></li>
              <el-divider direction="vertical"></el-divider>
                <li><router-link to="/purchasingManagement/examplesPurchasing">样品采购</router-link></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="searchRight">
                      <el-button  size="mini">全部</el-button>
          <div class="block">
            <span>日期</span>
            <el-date-picker
              v-model="value1"
              type="date"
              placeholder="选择日期"
              size="mini"
            >
            </el-date-picker>
          </div>
          <div class="keyWord">
            <span>关键字</span>
            <div class="input">
              <el-input v-model="input" placeholder="请输入内容" size="mini" />
            </div>
          </div>
         
          <el-button type="success" size="mini">查找</el-button>
        </div>
      </div>
      <!-- 表格 -->
      <div class="table_backCol">
        <!-- 表格头部 -->
        <div class="tableTips">
          <div class="tipsLeft">
            <i class="el-icon-s-grid"></i>
            商品特殊采购列表
          </div>
         
        </div>
        <!-- 表格 -->
        <el-table :data="lis" style="width: 100%" :border="true">
          <el-table-column
            label="编号"
            prop="id"
            width="100px"
            align="center"
            sortable
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
          <!-- <el-table-column label="操作时间" prop="specificDate">
          </el-table-column>
          <el-table-column label="数额" prop="num" align="center" width="100px">
            <template #default="scope">
              <el :underline="false">
                {{ scope.row.num }}
              </el>
              <div>
                ¥：
                <el>
                  {{ scope.row.num * scope.row.price }}
                </el>
              </div>
            </template>
          </el-table-column> -->
          <!-- <el-table-column label="事务内容" prop="desc"> </el-table-column> -->
          <el-table-column label="需求数" prop="customizeQuantity">
          </el-table-column>
          <el-table-column label="总金额" prop="price"> </el-table-column>
          <el-table-column label="渠道" prop="channel"> </el-table-column>
          <el-table-column label="订单号" prop="invoiceNumber">
          </el-table-column>
          <el-table-column label="运单号" prop="invoiceNumber">
          </el-table-column>
          <el-table-column label="采购" prop="channel" align="center">
            <i class="el-icon-check"></i>
          </el-table-column>
          <el-table-column label="备注" prop="classiFic"> </el-table-column>
          <el-table-column label="处理" align="center"
            ><i class="el-icon-close"></i
          ></el-table-column>
          <el-table-column
            label="操作"
            prop="operate"
            size="small"
            width="200px"
            align="center"
            fixed="right"
          >
            <template v-slot="scope">
              <div class="tableBtn">
                <el-button
                  type="primary"
                  size="small"
                  @click="editVisible(scope.row)"
                  >编辑</el-button
                >
                <el-button
                  type="success"
                  size="small"
                  @click="responseVisible(scope.row)"
                  >回应</el-button
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
          price: "10",
          invoiceNumber: "986564652899498",
          channel: "阿里",
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
          price: "10",
          invoiceNumber: "986564652899498",
          channel: "pdd",
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
          price: "12",
          invoiceNumber: "986564652899498",
          channel: "阿里",
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
          price: "12",
          invoiceNumber: "986564652899498",
          channel: "阿里",
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
          price: "14",
          invoiceNumber: "986564652899498",
          channel: "阿里",
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
          price: "19",
          invoiceNumber: "986564652899498",
          channel: "阿里",
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
          price: "2",
          invoiceNumber: "986564652899498",
          channel: "阿里",
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
          price: "29",
          invoiceNumber: "986564652899498",
          channel: "阿里",
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
          price: "12",
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
    //   shipping(item) {
    //     this.$router.push({
    //       path: "/purchasingManagement/shipping",
    //       query: {
    //         ...item,
    //       },
    //     });
    //   },
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
  font-size: 14px;
  margin: 0px;
}
a {
  text-decoration: none;
  color: #007185;
}
.el-header{
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
  color: #000;
   background-color: #fff;
}
//顶部banner
// 文字链接
.Amazonproduct_application {
  .application-title {
    font-size: 18px;
    font-weight: bold;
  }
  .application_list {
    text-decoration: none;
    list-style-type: none;
    padding: 0;
    li {
      padding: 0px 6px;
      font-size: 14px;
      color: #007185;
      cursor: pointer;
    }
  }
}
.textLink {
  font-size: 13px;
  display: flex;
  justify-content: space-between;
  padding: 20px 0px;
  flex-wrap: wrap;
  p {
    font-size: 14px;

}
a:hover{
    color: #606266;
  }
}
.bannerTop {
  display: flex;
  justify-content: space-between;
  //   左边链接
  .textLink {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    align-items: center;
    width: 60%;
  }
  .searchRight {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #606266;
    flex-wrap: wrap;
    align-items: center;
    width: 50%;
    span {
      //   padding-right: 10px;
    }
    .keyWord {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  }
}
// 商品列表
.table_backCol {
  margin-top: 10px;
  background-color: #fff;
  border-radius: 2px;
  padding: 12px;
  .tableTips {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size:12px;
    a {
      color: #606266;
      padding: 2px;
    }
    a:hover {
      color: #007185;
    }
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
.table_backCol {
  padding: 12px 0;
  .title {
    margin: 12px 0;
  }
  .el-table {
    .el-button {
      padding: 8px;
      margin: 3px;
    }
    .el-icon-close {
      color: red;
    }
    .el-icon-check {
      color: green;
    }
  }
}
// 分页
</style>