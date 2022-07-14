<template>
  <!-- <el-container>
     <el-header>
        <sidebar ></sidebar>
     </el-header>
     <el-main> -->
         <div class="logistics_header flex flex-wrap">
             <el-button type="primary">添加直发</el-button>
             <el-button type="primary">导入</el-button>
         </div> 
         <div class="search--condition_header flex align-center flex-wrap">
            <div class="search--condition_list flex align-center">
                <span>物流：</span>
                <el-cascader :options="options">
                    <template #default="{ node, data }">
                        <span>{{ data.label }}</span>
                        <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>
                    </template>
                </el-cascader>
            </div>
            <div class="search--condition_list flex align-center">
                <span>日期：</span>
                <el-date-picker
                        v-model="datepicker"
                        type="datetimerange"
                        :shortcuts="shortcuts"
                        range-separator="至"
                        start-placeholder="开始时间"
                        end-placeholder="结束时间"
                    />

            </div>
             <div class="search--condition_list flex align-center">
                 <span>ID：</span>
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
                        label="发布日期"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="发货数量"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="是否发货"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="创库"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="物流"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="是否完成"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="是否签收"
                        show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                        label="操作"
                        fixed="right"
                        min-width="150"
                        show-overflow-tooltip>
                        <template #default="scope">
                            <el-button @click="handleClick(scope.row)" type="success" size="small">发货</el-button>
                            <el-button type="danger" size="small">删除</el-button>
                            <el-button type="warning" size="small">取消</el-button>
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
     <!-- </el-main> -->
<!-- </el-container> -->
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
            logisticsvalue:"",
            logisticsoptionslist:[{value:0,label:"顺丰"}],

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
                {id:123456789,shopanme:"商品名称",single:45789123456,address:'地址'}
            ]
        })
        return{
            ...toRefs(data)
        }

    }

}
</script>

<style lang="scss" scoped>
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
    
    span{
        padding: 0px 5px;
    }
}
.search--condition_list{
    padding: 10px 5px;
}
.table--list{
    padding: 10px;
    background-color: $navBg;
    border-radius: 4px;
}
.pagination{
    padding: 10px 0px;
}
</style>

