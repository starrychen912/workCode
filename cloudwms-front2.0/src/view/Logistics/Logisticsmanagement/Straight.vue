<template>
  <!-- <el-container>
     <el-header>
        <sidebar ></sidebar>
     </el-header>
     <el-main> -->
         <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">物流：</div>
      <el-select v-model="value1" >
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
      <div class="label">物流状态：</div>
      <el-select v-model="value1" >
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
      <el-date-picker
          v-model="value12"
          type="daterange"
          align="right"
          unlink-panels
          range-separator="-"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        >
        </el-date-picker>
    </div>
    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input placeholder="" style="flex: 1"></el-input>
    </div>
    <div class="brandMan_list flex align-center">
      <router-link to="/">
        <div class="btn--button">导入直发</div>
      </router-link>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <div class="product_integration--btn--list flex">
    <router-link to="/Logisticsmanagement/AddFBA">
      <div class="btn--button">添加直发</div>
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
            <el-table
                ref="multipleTable"
                :data="tableData"
                tooltip-effect="dark"
                style="width: 100%"
                @selection-change="handleSelectionChange">
                    <el-table-column
                        type="selection"
                        width="55">
                    </el-table-column>
                    <el-table-column
                        label="编号"
                         width="120"
                         >
                        <template #default="scope">{{ scope.row.id }}</template>
                    </el-table-column>
                    <el-table-column
                        prop="shopanme"
                        label="商品"
                        width="120">
                    </el-table-column>
                    <el-table-column
                        prop="single"
                        label="单号"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="日期"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="number"
                        label="数量"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="是否发货"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="收货人"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="国家"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="是否打包"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="是否分配"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="remark"
                        label="备注"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        label="操作"
                        min-width="200"
                        align="center"
                        >
                        <template #default="scope">
                            <div class="button_list flex align-center flex-wrap">
                                <div class="column_list--button">
                                    <el-link @click="handleClick(scope.row)" type="primary" size="small">发货</el-link>
                                </div>
                                <el-divider direction="vertical"></el-divider>
                                <div class="column_list--button">
                                    <el-link type="primary" size="small">删除</el-link>
                                </div>
                                <el-divider direction="vertical"></el-divider>
                                <div class="column_list--button">
                                    <el-link type="primary" size="small">取消</el-link>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
            </el-table>
            <div class="pagination">
                <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage4"
                    :page-sizes="[100, 200, 300, 400]"
                    :page-size="100"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="400">
            </el-pagination>
            </div>
         </div>
     <!-- </el-main>
</el-container> -->
</template>

<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue"
import { reactive, toRefs } from 'vue'
export default {
    components:{
        Sidebar
    },
    setup(){
        const data = reactive({
            options:[

            ],
            status:"",
            statuslist:[
                {value:0,label:"未完成"},
                {value:1,label:"已完成"},
                {value:2,label:"未发货"},
                {value:3,label:"已发货"},
                {value:4,label:"已取消"}
            ],
            searchId:"",
            datepicker:"",
            shortcuts: [{
                    text: '最近一周',
                    onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                    picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: '最近一个月',
                    onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                    picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: '最近三个月',
                    onClick(picker) {
                    const end = new Date();
                    const start = new Date();
                    start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                    picker.$emit('pick', [start, end]);
                    }
            }],
            tableData:[
                {id:'2112253F2TFT66',number:1,shopanme:"商品名称",single:45789123456,address:'地址',remark:'备注很让人意外'}
            ]
        })
        return{
            ...toRefs(data)
        }

    }

}
</script>

<style lang="scss" scoped>
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
.btn--button {
  --el-button-font-color: #ffffff;
  --el-button-background-color: #409eff;
  --el-button-border-color: #409eff;
  --el-button-hover-color: #66b1ff;
  --el-button-active-font-color: #e6e6e6;
  --el-button-active-background-color: #0d84ff;
  --el-button-active-border-color: #0d84ff;
  display: inline-block;
  line-height: 1;
  min-height: 40px;
  white-space: nowrap;
  cursor: pointer;
  background: var(--el-button-background-color, var(--el-color-white));
  border: var(--el-border-base);
  border-color: var(--el-button-border-color, var(--el-border-color-base));
  color: var(--el-button-font-color, var(--el-text-color-regular));
  -webkit-appearance: none;
  text-align: center;
  box-sizing: border-box;
  outline: 0;
  margin: 0;
  transition: 0.1s;
  font-weight: var(--el-button-font-weight);
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  padding: 12px 20px;
  font-size: var(--el-font-size-base, 14px);
  border-radius: var(--el-border-radius-base);
}
.product_integration--btn--list {
  margin: 15px 0px;
  :deep(.product_integration_dropdown) {
    margin-left: 10px;
  }
}
.table--list{
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
.column_list--button{
    padding: 5px ;
}
</style>

