<template>
  <!-- 商品分类页面 -->
  <!-- <el-container>
    <el-header>
      <sidebar ></sidebar>
    </el-header>
    <el-main> -->
      <!-- 头部 -->
      <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">部门选择：</div>
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
    <div class="brandMan_list flex align-center">
      <div class="label">日期：</div>
      <el-date-picker
              v-model="value1"
              type="date"
              placeholder="选择日期"
            >
            </el-date-picker>
    </div>
    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input placeholder="请输入商品名称" style="flex:1;"></el-input>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <!-- 中间新增 -->
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
                      <el-button type="warning" >外观</el-button>
                    </div>
                    <br />
                    <div>
                      <el-button type="danger" >配件</el-button>
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
              label="商品"
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
            <el-table-column label="退货日期" prop="sku">
              <template #default="scope">
                <div>
                  {{ scope.row.receiptDate }}
                </div>
                <div>
                  {{ scope.row.specificDate }}
                </div>
                <div>
                  get定制：
                  <el-link :underline="false">
                    {{ scope.row.customizeQuantity }}
                  </el-link>
                </div>
              </template>
            </el-table-column>
            <el-table-column
              label="数量"
              prop="num"
              align="center"
              width="100px"
            >
            </el-table-column>
            <el-table-column label="货单号" prop="invoiceNumber"
              ><template #default="scope"
                ><el-link :underline="false">
                  {{ scope.row.invoiceNumber }}
                </el-link></template
              >
            </el-table-column>
            <el-table-column label="备注" prop="reGoods"> </el-table-column>
            <el-table-column label="库存" prop="reGoods"> </el-table-column>

            <el-table-column
              label="操作"
              prop="operate"
              width="150px"
              align="center"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <!-- <el-button
                    type="success"
                    
                    @click="editVisible(scope.row)"
                    >编辑</el-button
                  > -->
                  <el-link
                    type="primary"
                    @click="deleteItem(scope.$index, lis)"
                    >删除</el-link
                  >
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
            :page-sizes="[3, 5, 8, 10]"
            :page-size="querInfo.pagesize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="this.tableData.length"
          >
          </el-pagination>
        </div>
        </div>
        <!-- 责任人 -->
        <el-dialog title="责任人" v-model="responTab"> 
          <el-checkbox-group v-model="checkList">
            <el-checkbox label="复选框 A"></el-checkbox>
            <el-checkbox label="复选框 B"></el-checkbox>
            <el-checkbox label="复选框 C"></el-checkbox>
          </el-checkbox-group>
        </el-dialog>
        <!-- 弹出编辑表单 -->
        <el-dialog title="修改商品退货" v-model="editVisi">
          <el-descriptions title="用户信息">
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
            <el-descriptions-item label="退换日期 :">
              <el-date-picker
                v-model="value1"
                type="date"
                placeholder="选择日期"
                size="mini"
              >
              </el-date-picker>
              <el-checkbox label="同步发货" border size="mini"></el-checkbox>
            </el-descriptions-item>
            <el-descriptions-item label="数量 :">
               <el-input
    size="mini"
    placeholder="请输入内容"
    v-model="input1"
    class="des"
    >
  </el-input>
            </el-descriptions-item>
            <el-descriptions-item label="库存地点 :">
            
            <el-select v-model="value1" style="width: 120px" size="mini">
              <el-option
                v-for="item in options1"
                :key="item.value"
                :label="item.label"
                :value="item.value"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </el-descriptions-item>
          </el-descriptions>
  <el-descriptions>
     <el-descriptions-item label="货单号 :" class="des">
        <el-input
    placeholder="请输入内容"
    v-model="input2"
    >
  </el-input>
     </el-descriptions-item>

  </el-descriptions>
  <el-descriptions>
     <el-descriptions-item label="备注 :" class="des">
       <el-input
  type="textarea"
  :rows="2"
  placeholder="请输入内容"
  v-model="textarea">
</el-input>
     </el-descriptions-item>
     
  </el-descriptions>
          <template #footer>
            <div class="dialog-footer">
              <el-button @click="editVisi = false">取 消</el-button>
              <el-button type="primary" @click="editVisi = false"
                >确 定</el-button
              >
            </div>
          </template>
        </el-dialog>        
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
      editList: [],
      value1: [],
      value2: [],
      input1:'',
      input2:'',
       textarea: '',
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
      dialogFormVisible: false,
      responTab: false,
      lis: [],
      tableData: [
        {
          id: "1360",
          name: "1耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
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
        },
        {
          id: "2360",
          name: "2耳机线线夹，整理绑带，棕色PU, 基础版 五个装",
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
        },
      ],
      querInfo: {
        type: 2,
        pagenum: 1,
        pagesize: 3,
      },
      checkList: ["复选框 A"],
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
    //删除此行
    deleteItem(index, lis) {
      lis.splice(index, 1);
    },
    //编辑弹框
    editVisible(item) {
      this.editList = [];
      this.editList = item;
      console.log(item);
      this.editVisi = true;
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
//弹出编辑表格
.el-checkbox.is-bordered.el-checkbox--mini {
  margin-left: 4px;
  // margin-bottom: 2px;
  padding: 0px 10px 4px 10px;
  border-radius: calc(var(--el-border-radius-base) - 1px);
}

  .des {
    font-size: 12px;
    line-height: 28px;
    display: inline;
    input{
      width: 140px;
    }
}

    

</style>
<style scoped lang="scss">

.el-header{
  background-color: $navBg;
  height: auto;
  // box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
  color: #000;
}
p {
  font-size: 12px;
  margin: 0px;
}
a {
  text-decoration: none;
  font-size: 10px;
  color: #007185;
}
.el-header {
  background-color: #fff;
}
//顶部banner
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
// 商品列表
.table_backCol {
  background-color: $navBg;
  background-color: #fff;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .pagination-list{
    padding: 15px 0px;
  }
}


// 分页
</style>