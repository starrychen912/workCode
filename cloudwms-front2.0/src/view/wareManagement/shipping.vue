<template>
  <!-- 商品分类页面 -->
  <!-- <el-container>
     <el-header>
      <sidebar></sidebar>
    </el-header>
    <el-main> -->
      <div class="banner">
         <div class="title"> {{tableList.name}} {{tableList.receiptDate}}</div>
         <div class="bannerTop">
        <div class="leftB">
          <el-button size="mini">添加发货事务</el-button>
        </div>
        <div class="searchRight">
          <el-button size="mini">全部事务</el-button>
            <div class="block">
        <el-date-picker
        v-model="value12"
        type="daterange"
        align="right"
        unlink-panels
        range-separator="至"
        start-placeholder="开始日期"
        end-placeholder="结束日期"
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
          
          <div class="keyWord">
            <span>内容</span>
            <div class="input">
              <el-input v-model="input" placeholder="请输入内容" size="mini" />
            </div>
          </div>
          <el-button type="success" size="mini">查找</el-button>
        </div>
        </div>
      </div>
      <!-- 表格 -->
      <div class="table_backCol">
        <!-- 表格 -->
        <div class="aList">
        <div class="aLeft">
          <i class="el-icon-s-grid">{{tableList.name}} {{tableList.receiptDate}}</i>
        </div>
        <div class="aRight">
           <el-link :underline="false">返回上一级</el-link>
        </div>
        </div>
          <el-table :data="lis" style="width: 100%" :border="true">
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
            <el-table-column label="发货日期" prop="specificDate">
            </el-table-column>
            <el-table-column label="货单号" prop="invoiceNumber">
            </el-table-column>
            <el-table-column label="事务内容" prop="reGoods"> </el-table-column>
            <el-table-column label="已处理(未)" prop="reGoods"> </el-table-column>
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
                    @click="dialogFormVisible = true"
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
        <!-- 弹出表单 -->
        <el-dialog title="编辑产品信息" v-model="dialogFormVisible">
          <el-form :model="lis">
            <el-form-item label="标题" :label-width="formLabelWidth">
              <el-input v-model="lis.name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="仓库选择" :label-width="formLabelWidth">
              <el-select v-model="lis.inStock" placeholder="请选择出库的仓库">
                <el-option label="中山" value="中山"></el-option>
                <el-option label="深圳" value="深圳"></el-option>
              </el-select>
            </el-form-item>
          </el-form>
          <template #footer>
            <div class="dialog-footer">
              <el-button @click="dialogFormVisible = false">取 消</el-button>
              <el-button type="primary" @click="dialogFormVisible = false"
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
            :total="this.dataList.length"
          >
          </el-pagination>
        </div>
    <!-- </el-main>
  </el-container> -->
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue"; 
// import { datalist } from "@/utils/data";
export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      tableList:{},
      // dataList:[],
      dialogFormVisible: false,
      responTab: false,
      lis: [],
      querInfo: {
        type: 2,
        pagenum: 1,
        pagesize: 3,
      },
      value12:'',
      checkList: ["复选框 A"],
       dataList: [
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
    };
  },

  mounted() {
    // this.dataList = datalist
    this.getlist();
    this.Getlist();
  },
  created() {
    
  },
  methods: {
      getlist(){
          this.tableList=this.$route.query;
      },
    Getlist() {
      this.lis = this.dataList.slice(
        this.querInfo.pagesize * (this.querInfo.pagenum - 1),
        this.querInfo.pagesize * this.querInfo.pagenum
      )
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
  font-size: 10px;
  color: #007185;
}
.el-header{
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
  color: #000;
}
.title{
    font-size: 16px;
    margin: 20px 0px;
}
//顶部banner
.banner{background-color: #fff;
  // margin:10px 0px;
  padding: 10px;
  border-radius: 4px;
.bannerTop {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}
  .searchRight {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #606266;
    flex-wrap: wrap;
    align-items: center;
    width: 60%;
   
    .keyWord {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  }
}
// 商品列表
.table_backCol {
  margin-top:20px ;
  background-color: #fff;
  border-radius: 2px;
  padding: 12px;
  // 链接跳转列表
.aList {
  font-size: 13px;
  display: flex;
  justify-content: space-between;
  a {
    margin: 3px;
  }
  a:hover {
    color: #000;
  }
  // .aLeft .el-radio{
  //   width: 5px;
  //   font-size: 5px;
  // }
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
  }
}
// 分页
</style>