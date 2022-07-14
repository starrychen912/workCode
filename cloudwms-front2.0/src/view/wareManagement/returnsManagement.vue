<template>
  <div class="productInfo_header">
    <div class="product_info--list flex align-center">
      <div class="label">状态：</div>
      <el-select v-model="search_from.status">
        <el-option label="未出库" :value="2"></el-option>
        <el-option label="已出库" :value="3"></el-option>
      </el-select>
    </div>
     <div class="product_info--list flex align-center">
      <div class="label">时间：</div>
     <el-date-picker
      v-model="date"
      type="daterange"
      range-separator="至"
      start-placeholder="开始日期"
      end-placeholder="结束日期"
      value-format="x"
      >
    </el-date-picker>
    </div>
    <div class="product_info--list flex align-center">
      <div class="label">关键字：</div>
      <el-input  placeholder="请输入商品名称"  style="flex: 1"  v-model="search_from.title"></el-input>
    </div>
    <div class="product_info--list">
      <el-button type="primary" @click="GetinboundList">查询</el-button>
      <el-button @click="Reset">重置</el-button>
    </div>
  </div>
  <div class="product_integration--btn--list flex">
    <!-- <el-button type="primary" class="el-icon-plus"  @click="deleteAll">批量删除</el-button> -->
    <el-dropdown trigger="click" class="product_integration_dropdown" style="margin-left:0px"> 
      <el-button>
        更多操作<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <template #dropdown>
        <el-dropdown-menu>
          <el-dropdown-item >批量删除 </el-dropdown-item>
        </el-dropdown-menu>
      </template>
    </el-dropdown>
  </div>
    <div class="table--list">
           <el-table
                ref="multipleTable"
                :data="tableData"
                tooltip-effect="dark"
                style="width: 100%"
                @selection-change="handleSelectionChange"
                :border="true"
                >
                    <el-table-column  type="selection"  width="55" >
                    </el-table-column>
                    <el-table-column  label="编号" >
                        <template #default="scope">{{ scope.row.id }}</template>
                    </el-table-column>
                    <el-table-column label="产品名称" prop="title" ></el-table-column>
                    <el-table-column  prop="sku"  label="SKU"  min-width="250"></el-table-column>
                    <el-table-column  prop="order_sn"  label="订单编号"  min-width="200"></el-table-column>
                    <el-table-column  prop="number_of_items_shipped"  label="发货数量"  min-width="200"></el-table-column>
                    <el-table-column  prop="marketplace_id"  label="亚马逊ID"  min-width="200"></el-table-column>
                    <el-table-column  prop="inventory_sku"  label="库存SKU"  min-width="250"></el-table-column>
                    <el-table-column  prop="fulfillment_channel"  label="亚马逊订单运输方式"  min-width="200"></el-table-column>
                    <el-table-column  prop="category_name"  label="产品类型"  min-width="200"></el-table-column>
                    <el-table-column  prop="amazon_order_id"  label="亚马逊订单ID"  min-width="200"></el-table-column>
                    <el-table-column  prop="current_total_price"  label="总价"  min-width="200"></el-table-column>
                    <el-table-column
                        label="操作"
                        fixed="right"
                        min-width="200"
                        >
                        <template #default="scope">
                          <div class="tableBtn">
                          <el-link  type="primary"  size="small"  @click="Returns_Detail(scope.row.id)">详情</el-link>
                          <el-divider direction="vertical"></el-divider>
                          <el-link  type="primary"  size="small"  @click="DeleteInbound(scope.row.id)">删除</el-link>
                          </div>
                        </template>
                    </el-table-column>
            </el-table>
            <div class="pagination">
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
      <add-receipt  :Receipt_dialogVisible="Receipt_dialogVisible" :WarehouseList="warehouse_list" :user_list="user_list" @CloseDialog="CloseDialog"></add-receipt>
</template>
<script>
import { computed, defineComponent, onMounted, reactive, toRefs } from 'vue'
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue"
import { useStore } from 'vuex'
import { GetwarehouseList } from "@/api/warehouseList";
import { companyUserList } from '@/api/memberCom';
import { shoElmessage, shoElMessageBox } from '../../utils/Elmessage'
import {GetcancelList,cancelDetail,deleteCancelList} from '@/api/cancel'
import { isNaLL } from '../../utils/utils'
import { getLocalTime } from '../../utils/utils'
import { useRouter } from 'vue-router';
export default defineComponent({
  components:{
    Sidebar,
  },

  setup(props,content) {
    const store = useStore();
    const router = useRouter();
    const data = reactive({
        Receipt_dialogVisible:false, //新建入库

        company_id:computed(() => store.state.userinfo.userinfo.company_id),
        title:"创建入库",
        search_from:{
          title:"",
          status:"",
          startTime:"",
          endTime:"",
          
        },
        date:"",
        wait_check_count: 0,
        wait_count: 1,
        finish_count: 0,
        refuse_count: 0,
        all_count: 1,

        tableData:[],
        dialogVisible:false,

        ruleForm:{
            Managementname:"安全部",
            id:12346578,
            mobile:'15766372450',
            market:'US-1',
            resource:'',
            userlist:'',
            textarea:'',
            managementuser:'',
        },
         // 弹框
        editVisi: false,
        querInfo: {
          total:100,
          pagenum:1,
          pagesize:100,
        },

        warehouse_list:[],
        user_list:[],
    })
    function onSubmit(){
        data.tableData.push(data.ruleForm)
        data.dialogVisible = true
    }
    function Reset(){
      data.search_from = {
        title:"",
          status:"",
          startTime:"",
          endTime:"",
          date:"",
      }
    }
    function Cancal(){
        data.dialogVisible = false
        data.ruleForm = {
            Managementname:"",
            id:12346578,
            mobile:'',
            market:'',
            resource:'',
            userlist:'',
            textarea:'',
            managementuser:'',
        }
    }

    function handleClick(item,index){
        data.dialogVisible = true
        data.title = '编辑收货信息'
        data.ruleForm = {}
        data.ruleForm = data.tableData[index]
    }
    onMounted(() =>{
      GetinboundList()
      additional()
    })
    function GetinboundList(){
      if(isNaLL(data.date)){
        data.search_from.startTime = parseInt(data.date[0]) / 1000
        data.search_from.endTime = parseInt(data.date[1]) / 1000
      }

      GetcancelList({
        company_id: data.company_id,
        ...data.search_from,
      }).then((res) => {
        if (res.code == 1) {
          data.tableData = res.data.data;
          data.querInfo.total = res.data.total;
          data.querInfo.pagenum = res.data.cur;
          data.querInfo.pagesize = res.data.size;
        }
      });
    }
    // 监听pagesize改变
    function handleSizeChange(newSize){
      data.lis = [];
      data.querInfo.pagesize = newSize;
      GetinboundList();
    }
    // 监听pagenum的改变
    function handleCurrentChange(newPage){
      data.lis = [];
      data.querInfo.pagenum = newPage;
      GetinboundList();
    }
    //全选
    function SelectAll(item){
      data.Delete_list = item;
    }
    //单选
    function Select(item){
      data.Delete_list = item;
    }
    // 批量删除
    function deleteAll() {
      // if (command == "a") {
        if (data.Delete_list.length != 0) {
          let item = [];
          data.Delete_list.forEach((el) => {
            item.push(el.id);
          });
          // data.deleteMaterial("批量删除", item.join());
        } else {
          shoElmessage("el-icon-warning", "请选择删除列表", "error");
        }
      // }
    }
    function additional(){
      GetwarehouseList({
        company_id: store.state.userinfo.userinfo.company_id,
      }).then((res) => {
        if (res.code == 1) {
          data.warehouse_list = res.data.data;
        }
      });
      companyUserList({
          company_id: store.state.userinfo.userinfo.company_id,
      }).then((res) => {
        if (res.code == 1) {
          data.user_list = res.data.data;
        }
      });
    } 
    function CloseDialog(item){
      data[item] = false
      GetinboundList();
    }
    function DeleteInbound(item){
      shoElMessageBox('确认删除当前退货订单，').then(res =>{
        console.log(res)
        if(res){
          deleteCancelList({
            order_ids:item,
          }).then(res =>{
              if(res.code == 1){
                shoElmessage(true,'删除成功','success')
                GetinboundList();
              }else{
                shoElmessage(true,`删除失败，,${res.msg}`,'error')
              }
          })
        }
      })
    }
    function Returns_Detail(id){
      router.push({
        path:"/Loft/returnsDetail",
        query:{
          order_id:id
        }
      })
    }
    return{
      Returns_Detail,
      DeleteInbound,
      CloseDialog,
      additional,
      ...toRefs(data),
      onSubmit,
      Cancal,
      handleClick,
      GetinboundList,
      handleSizeChange,
      handleCurrentChange,
      SelectAll,
      Select,
      deleteAll,
      Reset,
      getLocalTime,
    }
  }
})
</script>
<style scoped lang="scss">
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
.product_integration--btn--list {
  margin: 15px 0px;
  :deep(.product_integration_dropdown) {
    margin-left: 10px;
  }
}
.search--condition_list{
    padding: 10px 5px;
}
.table--list{
    background-color: #fff;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
}
.table_header{
  padding:10px 0px 20px 0px;
}


.pagination{
  display: flex;
  padding-top: 20px;
}



</style>
<style lang="scss">
.sales_dialog{
    .el-dialog__header{
        border-bottom: 1px solid #d6d6d6;
        
    }
     .el-dialog__body{
       height: 80vh;
       overflow: auto;
     }
     .el-dialog__body::-webkit-scrollbar {
       display: none;
    }
}
</style>
