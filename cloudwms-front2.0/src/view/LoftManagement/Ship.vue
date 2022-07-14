<template>
        <div class="receipt_header--list">
          <div class="title">我的流程</div>
          <el-row :span="24" class="flex align-center justify-between">
            <el-col :xs="24" :sm="24" :md="4" :lg="4" :xl="4" class="receipt--list flex align-center justify-between all">
                <span class="receipt_sjx"></span>
                <div class="seceipt_img">
                  <img src="../../assets/img/all.png">
                </div>
                <div class="seceipt_text">
                  <div>全部</div>
                  <div class="seceipt_span">{{all_count || 100000}}</div>
                </div>
            </el-col>
            <el-col :xs="24" :sm="24" :md="4" :lg="4" :xl="4" class="receipt--list flex align-center justify-between">
                <span class="receipt_sjx"></span>
                <div class="seceipt_img">
                  <img src="../../assets/img/shenh.png">
                </div>
                <div class="seceipt_text">
                  <div>预警</div>
                  <div class="seceipt_span">{{wait_count}}</div>
                </div>
            </el-col>
            <el-col :xs="24" :sm="24" :md="4" :lg="4" :xl="4" class="receipt--list flex align-center justify-between warring">
                <span class="receipt_sjx"></span>
                <div class="seceipt_img">
                  <img src="../../assets/img/warring.png">
                </div>
                <div class="seceipt_text">
                  <div>待出库</div>
                  <div class="seceipt_span">{{wait_check_count || 888}}</div>
                </div>
            </el-col>
            <el-col :xs="24" :sm="24" :md="4" :lg="4" :xl="4" class="receipt--list flex align-center justify-between error">
                <span class="receipt_sjx"></span>
                <div class="seceipt_img">
                  <img src="../../assets/img/error.png">
                </div>
                <div class="seceipt_text">
                  <div>驳回</div>
                  <div class="seceipt_span">{{refuse_count || 20}}</div>
                </div>
            </el-col>
            <el-col :xs="24" :sm="24" :md="4" :lg="4" :xl="4" class="receipt--list flex align-center justify-between success">
                <span class="receipt_sjx"></span>
                <div class="seceipt_img">
                  <img src="../../assets/img/success.png">
                </div>
                <div class="seceipt_text">
                  <div>完成</div>
                  <div class="seceipt_span">{{finish_count || 10000}}</div>
                </div>
            </el-col>
          </el-row>
        </div>
         <div class="productInfo_header">
          <div class="product_info--list flex align-center">
            <div class="label">状态：</div>
            <el-select v-model="search_from.status">
              <!-- 3=已收货,4=入库审核中,5=已入库,6=驳回入库 -->
              <el-option label="已收货" :value="3"></el-option>
              <el-option label="已入库" :value="5"></el-option>
              <el-option label="入库审核中" :value="4"></el-option>
              <el-option label="驳回入库" :value="6"></el-option>
            </el-select>
          </div>
        <!-- <div class="product_info--list flex align-center">
          <div class="label">入库仓库：</div>
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
        </div> -->
     <div class="product_info--list flex align-center">
      <div class="label">时间：</div>
     <el-date-picker
      v-model="search_from.date"
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

    <!-- 中间商品搜索栏 -->
    <div class="product_info--list">
      <el-button type="primary" @click="GetinboundList">查询</el-button>
      <el-button @click="Reset">重置</el-button>
    </div>
  </div>
  <div class="product_integration--btn--list flex">
    <el-button type="primary" class="el-icon-plus"  @click="deleteAll">批量删除</el-button>
    <el-dropdown trigger="click" class="product_integration_dropdown" > 
      <el-button>
        更多操作<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <template #dropdown>
        <el-dropdown-menu>
          <el-dropdown-item > 批量删除 </el-dropdown-item>
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
                :expand-row-keys="expands" 
                :row-key="getRowKeys"
                @expand-change="expandChange"
                @select-all="SelectAll"
                @select="Select"
                >
                    <el-table-column  type="selection"  width="55" >
                    </el-table-column>
                    <el-table-column  label="编号" >
                        <template #default="scope">{{ scope.row.id }}</template>
                    </el-table-column>
                    <el-table-column label="名称" prop="title" ></el-table-column>
                    <el-table-column  prop="sku"  label="SKU"  min-width="200">
                    </el-table-column>
                    <el-table-column  prop="create_time"  label="创建时间" >
                      <template #default="scope">
                        <span>{{getLocalTime(scope.row.create_time)}}</span>
                      </template>
                    </el-table-column>
                    <el-table-column  prop="outbound_date"  label="出库时间" >
                      <template #default="scope">
                        <span>{{scope.row.outbound_date?getLocalTime(scope.row.outbound_date):'未出库'}}</span>
                      </template>
                    </el-table-column>
                    <el-table-column  prop="outbound_date"  label="库存数量" >
                      <template #default="scope">
                        <span>{{scope.row.quantity}}</span>
                      </template>
                    </el-table-column>
                    <el-table-column  prop="outbound_date"  label="出库数量" >
                      <template #default="scope">
                        <span>{{scope.row.quantity_incase}}</span>
                      </template>
                    </el-table-column>
                    <el-table-column  prop="warehouse_name"  label="出库仓库"  >
                    </el-table-column>
                    <el-table-column  prop="resource"  label="状态"  >
                      <template #default="scope">
                       <!-- 3=已收货,4=入库审核中,5=已入库,6=驳回入库 -->
                          <el-tag :type="parseInt(scope.row.status) == 2? 'info':parseInt(scope.row.status) == 3?'success':'error'">
                            {{parseInt(scope.row.status) == 2? '未出库':parseInt(scope.row.status) == 3?'已出库':'被驳回'}}
                          </el-tag>
                      </template>
                    </el-table-column>
                    <el-table-column
                        label="操作"
                        fixed="right"
                        min-width="200"
                        >
                        <template #default="scope">
                          <div class="tableBtn">
                            <template v-if="parseInt(scope.row.status) == 2">
                              <el-link  type="primary"  size="small"  @click="inbound_Check(scope.row.id)">确认</el-link>
                              <el-divider direction="vertical"></el-divider>
                            </template>
                            
                            <template v-if="parseInt(scope.row.status) == 2">
                              <el-link  type="primary"  size="small"  @click="inbound_Refuse(scope.row.id)">驳回</el-link>
                              <el-divider direction="vertical"></el-divider>
                            </template>
                            <el-link  type="primary"  size="small"  @click="DeleteInbound(scope.row.id)">删除</el-link>
                          </div>
                        </template>
                    </el-table-column>
                    <el-table-column
                        type="expand"
                        fixed="right"
                        
                      >
                      <!-- <template #default="scope">
                        <div class="steps_list--title">审核流程：</div>
                         <div class="steps_list">
                           <el-steps :active="2" align-center finish-status="success">
                            <el-step title="步骤1" description="这是一段很长很长很长的描述性文字"></el-step>
                            <el-step title="步骤2" description="这是一段很长很长很长的描述性文字"></el-step>
                            <el-step title="步骤3" description="这是一段很长很长很长的描述性文字"></el-step>
                            <el-step title="步骤4" description="这是一段很长很长很长的描述性文字"></el-step>
                          </el-steps>
                         </div>
                         asin: ""
                        condition: ""
                        create_time: 1655113414
                        delete_time: 0
                        deliver_date: 0
                        id: 1
                        name: "cscs"
                        outbound_date: 1655201085
                        product_fba_id: 1
                        quantity: 11
                        quantity_incase: 2
                        sku: "amazon-afaf-0000-0000-0006"
                        status: "3"
                        title: "123456"
                        update_time: 0
                        warehouse_name: "深圳"
                      </template> -->
                      <template #default="scope">
                            <div class="expand_props_list">
                              <div class="expand_stock_list">
                                <div class="expand_stock_list--title">基本信息：</div>
                                <el-descriptions  class="margin-top"  :column="3" :size="size" :border="true" width="150px"  >
                                  <el-descriptions-item label="编号">{{expand_list.id}}</el-descriptions-item>
                                  <el-descriptions-item label="名称">{{expand_list.title}}</el-descriptions-item>
                                  <el-descriptions-item label="SKU">{{expand_list.sku}}</el-descriptions-item>
                                  <el-descriptions-item label="创建时间">{{getLocalTime(expand_list.create_time)}}</el-descriptions-item>
                                  <el-descriptions-item label="出库时间">{{getLocalTime(expand_list.outbound_date)}}</el-descriptions-item>
                                  <el-descriptions-item label="库存数量">{{expand_list.quantity}}</el-descriptions-item>
                                  <el-descriptions-item label="出库数量">{{expand_list.quantity_incase}}</el-descriptions-item>
                                  <el-descriptions-item label="出库仓库">{{expand_list.warehouse_name}}</el-descriptions-item>
                                  <el-descriptions-item label="状态">
                                    <el-tag :type="parseInt(expand_list.status) == 2? 'info':parseInt(expand_list.status) == 3?'success':'error'">
                                      {{parseInt(expand_list.status) == 2? '未出库':parseInt(expand_list.status) == 3?'已出库':'被驳回'}}
                                    </el-tag>
                                  </el-descriptions-item>
                                  <el-descriptions-item label="描述">
                                    <div v-html="expand_list.note"></div>
                                  </el-descriptions-item>
                                </el-descriptions>
                              </div>
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
import { outboundList,outboundDetail,outboundCheck,outboundRefuse ,deleteOutbound} from '@/api/outofstock'
import { useStore } from 'vuex'
import { isNaLL } from '../../utils/utils'
import { getLocalTime } from '../../utils/utils'
import AddReceipt from './components/AddReceipt.vue'
import { GetwarehouseList } from "@/api/warehouseList";
import { companyUserList } from '@/api/memberCom';
import { shoElmessage, shoElMessageBox } from '../../utils/Elmessage'
export default defineComponent({
  components:{
    Sidebar,
    AddReceipt
  },

  setup(props,content) {
    const store = useStore();
    const data = reactive({
        Receipt_dialogVisible:false, //新建入库

        company_id:computed(() => store.state.userinfo.userinfo.company_id),
        title:"创建入库",
        search_from:{
          title:"",
          status:"",
          startTime:"",
          endTime:"",
          date:"",
        },

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

        expand_list:{},
        expands:[],
        Delete_list:[],
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
      if(isNaLL(data.search_from.date)){
        data.search_from.startTime = parseInt(data.search_from.date[0]) / 1000
        data.search_from.endTime = parseInt(data.search_from.date[1]) / 1000
      }
      outboundList({
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
      data.GetinboundList();
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
    function inbound_Refuse(id){
      shoElMessageBox('确认驳回当前入库信息，').then(res =>{
        if(res){
          outboundRefuse({
            outbound_id:id,
          }).then(res =>{
              if(res.code == 1){
                shoElmessage(true,'驳回成功','success')
                GetinboundList();
              }else{
                shoElmessage(true,`驳回失败，,${res.msg}`,'error')
              }
          })
        }
      })
    }
    function inbound_Check(item){
       shoElMessageBox('确定出库').then(res =>{
        console.log(res)
        if(res){
          outboundCheck({
            outbound_id:item,
          }).then(res =>{
              if(res.code == 1){
                shoElmessage(true,'出库成功','success')
                GetinboundList();
              }else{
                shoElmessage(true,`出库失败，,${res.msg}`,'error')
              }
          })
        }
      })
    }
    function CloseDialog(item){
      data[item] = false
      GetinboundList();
    }
    function DeleteInbound(item){
      shoElMessageBox('确认删除当前入库信息，').then(res =>{
        console.log(res)
        if(res){
          deleteOutbound({
            outbound_ids:item,
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
    function expandChange(row, expandedRows) {
      data.expands = [];
      if (expandedRows.length > 0) {
        row ? data.expands.push(row.id) : "";
      }
      outboundDetail({
        outbound_id: row.id,
      }).then((res) => {
        if (res.code == 1) {
          console.log(res)
          data.expand_list = res.data
          console.log(data.expand_list)
        }
      });
    }
    function getRowKeys(row) {
        return row.id;
    }
    return{
      expandChange,
      getRowKeys,
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
      inbound_Check,
      inbound_Refuse,
    }
  }
})
</script>
<style scoped lang="scss">
.expand_props_list{
  padding: 10px;
  background-color: #f0f2f5;
  .expand_stock_list--title{
    margin: 10px 0px;
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

.today_outstanding{
    background-color: #fff;
    // padding: 20px;
}
.today_outstanding--title{
    padding: 15px;
    border-bottom: 1px solid #d6d6d6;
}
.today_list{
    width: 100%;
    background-color: #fff;
    height: 100%;
    
}
.receipt_header--list{
  padding: 15px;
  // border-radius: 10px;
  height: auto;
  background-color: $navBg;
  box-shadow: 0 0px 20px 0 rgba(0, 0, 0, .10), 0 0 3px 0 rgba(0, 0, 0, .03);
  margin-bottom: 15px;
  .title{
    font-size: 17px;
    font-weight: bold;
  }
}
.receipt--list{
  padding: 15px;
  height: 100px;
  position: relative;
  &::before{
    content: '';
    background: url('../../assets/img/bj.png');
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}
.error{
  &::before{
    content: '';
    background: url('../../assets/img/bj-error.png');
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}
.warring{
  &::before{
    content: '';
    background: url('../../assets/img/bj-warring.png');
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}
.success{
  &::before{
    content: '';
    background: url('../../assets/img/bj-success.png');
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}
.all{
  &::before{
    content: '';
    background: url('../../assets/img/bj-all.png');
    position: absolute;
    background-size: 100% 100%;
    z-index: 0;
    width: 90%;
    height: 100%;
  }
}

.seceipt_img{
  width:70px;
  height: 70px;
  // border: 1px solid #000;
  z-index: 111;
  cursor: pointer;
 
  img{
    width: 100%;
    height: 100%;
    transition: all 0.5s;
   transform: scale(1);
  }
   &:hover{
    img{
      transition: all 0.5s;
      transform: scale(1.4);
    }
  }
}
.seceipt_text{
  // margin-left: ;
  width: 50%;
  z-index: 111;
}
.seceipt_span{
  font-size: 30px;
  font-weight: bold;
}
.el_button--list{
  margin: 5px;
}
.pagination{
  display: flex;
  padding-top: 20px;
}
.steps_list--title{
  padding: 20px 40px;
  font-size: 15px;
  font-weight: bold;
}
.steps_list{
  width: 50%;
}
.basic_infomation{
  padding: 15px;
  background-color: #fafafa;
}
.basic_infomation--warring{
  padding: 20px;
  margin-top: 20px;
  background-color: #fafafa;
  font-size: 14px;
  .warring_title{
    i{
      color: #ffae00;
      font-size: 20px;
    }
  }
  .warring_1{
    padding: 4px 0px;
  }
  .warring_2{
    padding: 4px 0px;
    a{
      color: #0d84ff;
    }
  }
}
.basic_infomaion--form{
  margin-top: 20px;
}
.form_dislog{
  padding: 20px;
}
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
