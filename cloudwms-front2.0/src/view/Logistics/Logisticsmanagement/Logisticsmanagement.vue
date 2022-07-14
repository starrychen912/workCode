<template>
  <!-- 头部 -->
  <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">仓库：</div>
      <el-select v-model="search_from.warehouse_id">
        <el-option v-for="item in warehouse_list" :key="item.id" :label="item.name" :value="item.id" style="display: flex">
        </el-option>
      </el-select>
    </div>
    <div class="brandMan_list flex align-center">
      <div class="label">时间：</div>
      <el-date-picker
        v-model="search_from.Time"
        type="daterange"
        :align="'right'"
        unlink-panels
        range-separator="-"
        start-placeholder="开始日期"
        end-placeholder="结束日期"
      >
      </el-date-picker>
    </div>
    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input v-model="search_from.name" placeholder="请输入FBA名称" style="flex: 1"></el-input>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary" @click="GetTableList()">查询</el-button>
      <el-button @click="Cancal">重置</el-button>
    </div>
  </div>
  <!--中间新增 -->
  <div class="product_integration--btn--list flex">
    <router-link to="/Logisticsmanagement/AddFBA">
      <el-button type="primary">
          添加FBA
      </el-button>
    </router-link>
    <router-link to="/Logisticsmanagement/importFba">
      <el-button type="primary">
          导入FBA
      </el-button>
    </router-link>
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
  <div class="table--list">
    <el-skeleton :rows="10" animated v-show="table_loadding" />
    <el-empty v-show="tableData.length == 0 && !table_loadding"></el-empty>
    <el-table
      ref="multipleTable"
      :data="tableData"
      tooltip-effect="dark"
      style="width: 100%"
      @selection-change="handleSelectionChange"
      :border="true"
      v-show="tableData.length > 0"
    >
      <el-table-column type="selection" width="55"> </el-table-column>
      <el-table-column label="编号" width="120">
        <template #default="scope">{{ scope.row.id }}</template>
      </el-table-column>
      <el-table-column prop="name" label="名称" width="120">
      </el-table-column>
      <el-table-column prop="warehouse_name" label="仓库" show-overflow-tooltip>
      </el-table-column>
      <el-table-column prop="shop_name" label="店铺" show-overflow-tooltip>
      </el-table-column>
      <el-table-column prop="market_name" label="市场" show-overflow-tooltip>
      </el-table-column>
      <el-table-column prop="fba_warehouse_name" label="FBA仓库" show-overflow-tooltip>
      </el-table-column>
      <el-table-column  prop="inbound_date"  label="创建时间" >
          <template #default="scope">
            <span>{{getLocalTime(scope.row.create_time)}}</span>
          </template>
        </el-table-column>
      <el-table-column prop="create_type" label="创建类型" show-overflow-tooltip>
          <template #default="scope">
              <el-tag :type="parseInt(scope.row.create_type) == 1?'':'success'">{{parseInt(scope.row.create_type) == 1?'创建FBA':'补充FBA信息'}}</el-tag>
          </template>
      </el-table-column>
      <el-table-column prop="packing_type" label="包装类型" show-overflow-tooltip>
        <template #default="scope">
              <el-tag :type="parseInt(scope.row.packing_type) == 1?'':'success'">{{parseInt(scope.row.create_type) == 1?'组合':'混装'}}</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="logistics_status" label="物流状态" show-overflow-tooltip>
         <template #default="scope">
              <el-tag :type="parseInt(scope.row.logistics_status) == 1?'':'success'">{{parseInt(scope.row.logistics_status) == 1?'空运':'船运'}}</el-tag>
        </template>
      </el-table-column>
      <el-table-column prop="mark" label="备注" show-overflow-tooltip>
        <template #default="scope">
          <div v-html="scope.row.mark"></div>
        </template>
      </el-table-column>
      <el-table-column label="操作" fixed="right" min-width="150" show-overflow-tooltip :align="'center'">
        <template #default="scope">
          <el-link  @click="handleClick(scope.row)" type="primary" size="small" >查看</el-link>
          <el-divider direction="vertical"></el-divider>
          <el-link @click="handEdit(scope.row)" type="primary" size="small" >编辑</el-link>
          <el-divider direction="vertical"></el-divider>
          <el-link type="error" size="small" @click="Delete_FBA(scope.row.id)">删除</el-link>
        </template>
      </el-table-column>
    </el-table>
    <div class="pagination">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="pagination.page_num"
        :page-sizes="[100, 200, 300, 400]"
        :page-size="pagination.per_page_num"
        layout="total, sizes, prev, pager, next, jumper"
        :total="pagination.total"
      >
      </el-pagination>
    </div>
  </div>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { onMounted, reactive, toRefs } from "vue";
import {fbaList,deletefba,fbaAdd,fbaPlanAdd,fbaDetail} from '@/api/FBA.js'
import { useStore } from "vuex";
import { GetwarehouseList } from "@/api/warehouseList";
import { isNaLL,getLocalTime } from "@/utils/utils";
import { shoElmessage } from "../../../utils/Elmessage";
import router from "../../../router";

export default {
  components: {
    Sidebar,
  },
  setup(props,content) {
    const store = useStore();
    const data = reactive({
      tableData: [ ],
      
      search_from:{
        name:"",
        warehouse_id:"",
        startTime:"",
        endTime:"",
        Time:""
      },
      pagination:{
        per_page_num:10,
        page_num:1,
        total:10,
      },
      table_loadding:false,
    });
    onMounted(() =>{
      GetTableList()
    })
    function Cancal(){
      data.search_from = {
            name:"",
            warehouse_id:"",
            startTime:"",
            endTime:"",
            Time:""
          }
    }
    function GetTableList(){
      data.table_loadding = true
      if(isNaLL(data.search_from.Time)){
        data.search_from.startTime = data.search_from.Time[0] / 1000
        data.search_from.endTime = data.search_from.Time[1] / 1000
      }else{
        data.search_from.startTime = ''
        data.search_from.endTime = ''
      }
      GetwarehouseList({
        company_id:store.state.userinfo.userinfo.company_id,
      }).then(res =>{
        if(res.code == 1){
          data.warehouse_list = res.data.data
        }
      })
      fbaList({
        company_id:store.state.userinfo.userinfo.company_id,
        ...data.search_from,
        ...data.pagination,
      }).then(res =>{
        if(res.code == 1){
          data.table_loadding = false
          data.tableData = res.data.data
          data.pagination.total = res.data.total;
          data.pagination.page_num = res.data.cur;
          data.pagination.per_page_num= res.data.size
        }
      })
    }
    function Delete_FBA(item){
      deletefba({
        company_id:store.state.userinfo.userinfo.company_id,
        fba_ids:item
      }).then(res =>{
        if(res.code == 1){
          shoElmessage(true,'删除成功','success')
          GetTableList()
        }else{
          shoElmessage(true,`删除失败，原因${res.msg}`,'success')
        }
      })
    }
    function handEdit(item){
      router.push({
        path:'/Logisticsmanagement/perFBA',
        query:{
          fba_id:item.id,
          title:"修改FBA"
        }
      })
    }
    function handleClick(item){
      router.push({
        path:'/Logisticsmanagement/FbaDetail',
        query:{
          fba_id:item.id,
          title:"商品详情"
        }
      })
    }
    return {
      handleClick,
      handEdit,
      GetTableList,
      ...toRefs(data),
      Cancal,
      getLocalTime,
      Delete_FBA
    };
  },
};
</script>

<style lang="scss" scoped>

.el-header {
  background-color: $navBg;
  height: auto;
  //   box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
}
.search--condition_header {
  background-color: $navBg;
  padding: 10px;
  margin: 10px 0px;
  border-radius: 4px;

  span {
    padding: 0px 5px;
  }
}
.search--condition_list {
  padding: 10px 5px;
}
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
.product_integration--btn--list {
  margin: 15px 0px;
  :deep(.product_integration_dropdown) {
    margin-left: 10px;
  }
  a{
    color: #fff;
    margin-left: 10px;
    &:first-child{
      margin-left: 0px;
    }
  }
}
.table--list {
  background-color: $navBg;
  background-color: #fff;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
}
.pagination {
  padding: 15px 0px;
}
</style>

