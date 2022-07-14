<template>
    <!-- <el-container>
     <el-header>
        <sidebar ></sidebar>
     </el-header>
     <el-main> -->
         <div class="Sales_data">
             <el-row span="24" class="justify-between">
                 <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12" class="sales_col--list">
                     <div class="today_outstanding">
                        <div class="today_outstanding--title">今日业绩</div>
                        <div class="today_list">
                            <el-row span="24">
                                <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8" >
                                    <div class="today_outstanding--view">
                                        
                                            <div class="view--list flex align-center">
                                                <div class="view--list_img">
                                                    <svg width="30" height="30" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                                                        <path d="M33.0499 7H38C39.1046 7 40 7.89543 40 9V42C40 43.1046 39.1046 44 38 44H10C8.89543 44 8 43.1046 8 42L8 9C8 7.89543 8.89543 7 10 7H16H17V10H31V7H33.0499Z" fill="none" stroke="#0d84ff" stroke-width="4" stroke-linejoin="round"/>
                                                        <rect x="17" y="4" width="14" height="6" stroke="#0d84ff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M26.9996 19L19 27.0012H29.004L21.0003 35.0018" stroke="#0d84ff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="view--list_text">
                                                    <div class="title">
                                                        <span>40</span>
                                                        <svg width="10" height="10" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 24L24 6L43 24H31V42H17V24H5Z" fill="#ff0000" stroke="#ff0000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </div>
                                                    <div class="title_tag">订单数</div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8" >
                                    <div class="today_outstanding--view ">
                                        
                                            <div class="view--list flex align-center active">
                                                <div class="view--list_img">
                                                    <svg width="30" height="30" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                                                        <path d="M44 24C44 35.0457 35.0457 44 24 44C12.9543 44 4 35.0457 4 24C4 12.9543 12.9543 4 24 4V24H44Z" fill="none" stroke="#67C23A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M43.0844 18H30V4.91553C36.2202 6.86917 41.1308 11.7798 43.0844 18Z" fill="none" stroke="#67C23A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="view--list_text">
                                                    <div class="title">
                                                        <span>40%</span>
                                                        <svg width="10" height="10" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 24L24 6L43 24H31V42H17V24H5Z" fill="#ff0000" stroke="#ff0000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </div>
                                                    <div class="title_tag">交易率</div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8" >
                                    <div class="today_outstanding--view">
                                        
                                            <div class="view--list flex align-center">
                                                <div class="view--list_img">
                                                    <svg width="30" height="30" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                                                        <path d="M33.0499 7H38C39.1046 7 40 7.89543 40 9V42C40 43.1046 39.1046 44 38 44H10C8.89543 44 8 43.1046 8 42L8 9C8 7.89543 8.89543 7 10 7H16H17V10H31V7H33.0499Z" fill="none" stroke="#E6A23C" stroke-width="4" stroke-linejoin="round"/>
                                                        <rect x="17" y="4" width="14" height="6" stroke="#E6A23C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M26.9996 19L19 27.0012H29.004L21.0003 35.0018" stroke="#E6A23C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="view--list_text">
                                                    <div class="title">
                                                        <span>10.8%</span>
                                                        <svg width="10" height="10" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 24L24 42L43 24H31V6H17V24H5Z" fill="#0d84ff" stroke="#0d84ff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </div>
                                                    <div class="title_tag">报警商品</div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                 </el-col>
                 <el-col :xs="24" :sm="24" :md="11" :lg="11" :xl="11" class="sales_col--list">
                     <div class="today_outstanding">
                        <div class="today_outstanding--title">待跟进任务</div>
                        <div class="today_list">
                            <el-row span="24">
                                <el-col :xs="24" :sm="24" :md="6" :lg="6" :xl="6" >
                                    <div class="task_list" @click="Manual()">
                                       <svg width="39" height="39" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                                       <path d="M5 7C5 5.34315 6.34315 4 8 4H32C33.6569 4 35 5.34315 35 7V44H8C6.34315 44 5 42.6569 5 41V7Z" fill="#0d84ff" stroke="#0d84ff" stroke-width="4" stroke-linejoin="round"/>
                                       <path d="M35 24C35 22.8954 35.8954 22 37 22H41C42.1046 22 43 22.8954 43 24V41C43 42.6569 41.6569 44 40 44H35V24Z" stroke="#0d84ff" stroke-width="4" stroke-linejoin="round"/><path d="M11 12H19" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                       <path d="M11 19H23" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <div class="task_title">人工报表</div>
                                    </div>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="6" :lg="6" :xl="6" >
                                    <div class="task_list" @click="dialogVisible = true">
                                        <svg width="39" height="39" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                                        <path d="M41 13.9997L24 4L7 13.9997L7 33.9998L24 44L41 33.9998V13.9997Z" fill="#0d84ff" stroke="#0d84ff" stroke-width="4" stroke-linejoin="round"/>
                                        <path d="M24 22V30" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M32 18V30" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16 26V30" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <div class="task_title">历史销售</div>
                                    </div>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="6" :lg="6" :xl="6" >
                                    <div class="task_list">
                                        <svg width="39" height="39" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 44H38C39.1046 44 40 43.1046 40 42V14L31 4H10C8.89543 4 8 4.89543 8 6V42C8 43.1046 8.89543 44 10 44Z" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M24 31V28C26.2091 28 28 25.9853 28 23.5C28 21.0147 26.2091 19 24 19C21.7909 19 20 21.0147 20 23.5" stroke="#0d84ff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M24 39C25.3807 39 26.5 37.8807 26.5 36.5C26.5 35.1193 25.3807 34 24 34C22.6193 34 21.5 35.1193 21.5 36.5C21.5 37.8807 22.6193 39 24 39Z" fill="#0d84ff"/>
                                            <path d="M30 4V14H40" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="task_title">问题处理</div>
                                    </div>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                 </el-col>
             </el-row>
         </div>
         <div class="search--condition_header flex align-center flex-wrap">
            <div class="search--condition_list flex align-center">
                <span>状态：</span>
                <el-select v-model="logisticsvalue">
                    <el-option v-for="item in logisticsoptionslist" :label="item.label" :key="item.value" :value="item.value"></el-option>
                </el-select>
            </div>
            <div class="search--condition_list flex align-center">
                <span>平台：</span>
                <el-select v-model="logisticsvalue">
                    <el-option v-for="item in logisticsoptionslist" :label="item.label" :key="item.value" :value="item.value"></el-option>
                </el-select>
            </div>
            <div class="search--condition_list flex align-center">
                <el-button type="primary">导入</el-button>
            </div>
             <div class="search--condition_list flex align-center">
                <el-input v-model="searchId"></el-input>
            </div>
            
            <div class="search--condition_list flex align-center">
                <el-button type="primary">查找</el-button>
            </div>

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
                        label="商品编号"
                         width="120"
                         >
                        <template #default="scope">{{ scope.row.id }}</template>
                    </el-table-column>
                    <el-table-column
                        prop="shopanme"
                        label="商品"
                        min-width="200"

                      >
                    </el-table-column>
                    <el-table-column
                        prop="single"
                        label="市场"
                        
                    >
                    <template #default="scope">
                        <!-- <div>{{scope.row.single}}</div> -->
                        <div class="content_release">
                            <chat></chat>
                        </div>
                    </template>
                    </el-table-column>
                    <el-table-column
                        prop="affairstatus"
                        label="状态"
                    >
                    <template #default="scope">
                        <div>{{scope.row.status?'完成':'未完成'}}</div>
                    </template>
                    </el-table-column>
                    <el-table-column
                        prop="affairstatus"
                        label="in"
                    >
                    <template #default="scope">
                        <div>{{scope.row.status?'完成':'未完成'}}</div>
                    </template>
                    </el-table-column>
                    <el-table-column
                        prop="affairstatus"
                        label="是否可售"
                    >
                    <template #default="scope">
                        <div>{{scope.row.status?'完成':'未完成'}}</div>
                    </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="1天"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="周"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="月"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="季度"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="半年"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="年"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                        label="操作"
                        fixed="right"
                        min-width="150"
                        show-overflow-tooltip>
                        <template #default="scope">
                           
                             <el-link type="primary" size="small" @click="handleClick(scope.row)">编辑</el-link>
                                <el-divider direction="vertical"></el-divider>
                                <el-link type="primary" size="small" >删除</el-link>
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
    <el-dialog
        title="历史报表"
        v-model="dialogVisible"
        width="90%"
        :before-close="handleClose"
        custom-class="sales_dialog"
        top="2vh"
        >
        <div class="dialog_search">
            <div class="search--condition_list flex align-center">
                <span>平台：</span>
                <el-select v-model="logisticsvalue">
                    <el-option v-for="item in logisticsoptionslist" :label="item.label" :key="item.value" :value="item.value"></el-option>
                </el-select>
            </div>
            <div class="search--condition_list flex align-center">
                <span>分类：</span>
                <el-select v-model="logisticsvalue">
                    <el-option v-for="item in logisticsoptionslist" :label="item.label" :key="item.value" :value="item.value"></el-option>
                </el-select>
            </div>
            <div>
                <el-input v-model="searchId"></el-input>
            </div>
            
            <div class="search--condition_list flex align-center">
                <el-button type="primary">查找</el-button>
            </div>

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
                        label="商品编号"
                         width="120"
                         >
                        <template #default="scope">{{ scope.row.id }}</template>
                    </el-table-column>
                    <el-table-column
                        prop="shopanme"
                        label="商品"
                        min-width="200"

                      >
                    </el-table-column>
                    <el-table-column
                        prop="single"
                        label="市场"
                        
                    >
                    <template #default="scope">
                        <!-- <div>{{scope.row.single}}</div> -->
                        <div class="content_release">
                            <chat></chat>
                        </div>
                    </template>
                    </el-table-column>
                    <el-table-column
                        prop="affairstatus"
                        label="状态"
                    >
                    <template #default="scope">
                        <div>{{scope.row.status?'完成':'未完成'}}</div>
                    </template>
                    </el-table-column>
                    <el-table-column
                        prop="affairstatus"
                        label="in"
                    >
                    <template #default="scope">
                        <div>{{scope.row.status?'完成':'未完成'}}</div>
                    </template>
                    </el-table-column>
                    <el-table-column
                        prop="affairstatus"
                        label="是否可售"
                    >
                    <template #default="scope">
                        <div>{{scope.row.status?'完成':'未完成'}}</div>
                    </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="1天"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="周"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="月"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="季度"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="半年"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                          prop="affairstatus"
                          label="年"
                      >
                      <template #default="scope">
                          <div>{{scope.row.status?'完成':'未完成'}}</div>
                      </template>
                    </el-table-column>
                    <el-table-column
                        label="操作"
                        fixed="right"
                        min-width="150"
                        show-overflow-tooltip>
                        <template #default="scope">
                            <el-button @click="handleClick(scope.row)" type="primary" size="small">编辑</el-button>
                            <el-button type="danger" size="small">删除</el-button>
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
  </el-dialog>
</template>
<script>
import { defineComponent, reactive, toRefs } from 'vue'
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue"
import { useRouter } from 'vue-router'
export default defineComponent({
  components:{
    Sidebar
  },
  setup() {
    const router = useRouter();
    const data = reactive({
      tableData:[
                {id:123456789,shopanme:"商品名称",single:45789123456,content:"内容",status:0}
            ],
        dialogVisible:false,
    })
    function Manual(){
        router.push({path:'/Sales/manualreport'})
    }
    return{
      ...toRefs(data),
      Manual
    }
  },
})
</script>
<style scoped lang="scss">
.el-header{
  background-color: $navBg;
  height: auto;
//   box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
}
.search--condition_header{
    background-color: $navBg;
    padding: 10px;
    margin:10px 0px;
    border-radius: 4px;
     box-shadow: 0 0px 20px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
    span{
        padding: 0px 5px;
    }
}
.table--list{
    //  box-shadow: 0 0px 20px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
}
.search--condition_list{
    padding: 10px 5px;
}
.table--list{
    padding: 10px;
    background-color: $navBg;
    border-radius: 4px;
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
.today_outstanding--view{
    padding: 30px 0px;
    height: auto;
    &:lang(2){
        border: 1px solid #100010;
    }
    .view--list{
        // width: ;
        padding: 5px 0px;
        justify-content: center;
    }
    .view--list_img{
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        
    }
    .view--list_text{
        .title{
            font-size: 30px;
            font-weight: bold;
            display: flex;
        }
        .title_tag{
            font-size: 12px;
            color: #747474;
            text-align: center;
        }
    }
}
.view--list.active{
    border-left: 1px solid #b8b8b8;
    border-right: 1px solid #b8b8b8;
}
.sales_col--list{
    // margin-left: 10px;
    box-shadow: 0 0px 20px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
    background-color: #fff;
}
.task_list{
    padding: 30px 0px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    cursor: pointer;
    .task_title{
        width: 100%;
        text-align: center;
        margin-top: 5px;
        color: #747474;
    }
}
.dialog_search{
    display: flex;
    align-items: center;

}
</style>
<style lang="scss">
.sales_dialog{
    .el-dialog__header{
        border-bottom: 1px solid #d6d6d6;
    }
}
</style>