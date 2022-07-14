<template>
    <!-- <el-container>
     <el-header>
        <sidebar ></sidebar>
     </el-header>
     <el-main> -->
         <div class="search--condition_header flex align-center flex-wrap">
            <div class="search--condition_list flex align-center">
                <span>TAG：</span>
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
            <div class="search--condition_list flex align-center" @click="dialogVisible = true">
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
     <!-- </el-main>
    </el-container> -->
    <el-dialog
        title="导入报表"
        v-model="dialogVisible"
        width="50%"
        :before-close="handleClose"
        custom-class="sales_dialog"
        >
        <el-form ref="form" :model="form" >
            <el-form-item label="报表日期：" label-width="18%">
                <el-date-picker
                    v-model="form.date"
                    type="date"
                    placeholder="选择日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="市场：" label-width="18%">
                <el-input v-model="form.market" style="max-width:700px" disabled></el-input>
            </el-form-item>
            <el-form-item label="上传文件：" label-width="18%">
                <el-upload
                    class="upload-demo"
                    action="https://jsonplaceholder.typicode.com/posts/"
                    :on-change="handleChange"
                    :file-list="fileList">
                    <el-button size="small" type="primary">点击上传</el-button>
                </el-upload>
            </el-form-item>
        </el-form>

  </el-dialog>
</template>
<script>
import { defineComponent, reactive, toRefs } from 'vue'
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue"
export default defineComponent({
  components:{
    Sidebar
  },
  setup() {
    const data = reactive({
      tableData:[
                {id:123456789,shopanme:"商品名称",single:45789123456,content:"内容",status:0}
            ],
        dialogVisible:false,
        form:{
            date:'',
            market:'US-1'
        }
    })
    return{
      ...toRefs(data)
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



</style>
<style lang="scss">
.sales_dialog{
    .el-dialog__header{
        border-bottom: 1px solid #d6d6d6;
    }
}
</style>
