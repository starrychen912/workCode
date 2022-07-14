<template>
         <div class="search--condition_header flex align-center flex-wrap">
            <div class="search--condition_list flex align-center">
                <span>状态：</span>
                <el-select v-model="logisticsvalue">
                    <el-option v-for="item in logisticsoptionslist" :label="item.label" :key="item.value" :value="item.value"></el-option>
                </el-select>
            </div>
            <div class="search--condition_list flex align-center">
                <span>事务类型：</span>
                <el-select v-model="affairvalue">
                    <el-option v-for="item in affairlist" :label="item.label" :key="item.value" :value="item.value"></el-option>
                </el-select>
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
                <el-input v-model="searchId"></el-input>
            </div>
            <div class="search--condition_list flex align-center">
                <el-button type="primary">查找</el-button>
            </div>
         </div>
         <div class="logistics_header flex">
            <el-button type="primary" @click="addAffaiirClose()">添加事务</el-button>
            <el-dropdown trigger="click" style="margin-left:10px" @command="Command">
              <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item command="批量删除" > 批量删除 </el-dropdown-item>
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
                @select="handSelect"
                @select-all="handSelectAll"
                >
                    <el-table-column
                        type="selection"
                        width="55"
                        >
                    </el-table-column>
                    <el-table-column
                        label="编号"
                         width="120"
                         >
                        <template #default="scope">{{ scope.row.id }}</template>
                    </el-table-column>
                    <el-table-column
                        prop="title"
                        label="标题"
                        min-width="200"

                      >
                    </el-table-column>
                    <el-table-column
                        label="内容"
                        min-width="350"
                    >
                    <template #default="scope">
                        <div class="content_release">
                            <chat :chatlist="scope.row" @change="Change" ></chat>
                            <div class="show_more">
                                    展示更多
                            </div>
                        </div>
                    </template>
                    </el-table-column>
                    <el-table-column
                        prop="affairstatus"
                        label="是否处理"
                    >
                    <template #default="scope">
                        <el-tag :type="scope.row.status == 0?'info':scope.row.status == 1?'warning':scope.row.status == 2?'success':'error'">
                            {{scope.row.status == 0?'待处理':scope.row.status == 1?'处理中':scope.row.status == 2?'已处理':'已关闭'}}
                        </el-tag>
                    </template>
                    </el-table-column>
                    <el-table-column label="操作" width="150px" header-align="center" align="center" fixed="right">
                           <template #default="scope" >
                                <el-link type="primary" size="small" @click="EditAffair(scope.row)">编辑</el-link>
                                <el-divider direction="vertical"></el-divider>
                                <el-link type="primary" size="small" @click="Delete_TableData(scope.row)">删除</el-link>
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
                    :total="pagination.total">
            </el-pagination>
            </div>
         </div>
        <addaffair
            v-model="dialogVisible"
            ref="addaffair"
            @CloseBusinesses="CloseBusinesses"
            :responsible_person_list="responsible_person_list"
        >
            
        </addaffair>
        <editaffair
            v-model="EditaffairVisible"
            @CloseBusinesses="CloseEditBu"
            ref="editaffair"
            :responsible_person_list="responsible_person_list"
        >

        </editaffair>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue"
import {  onMounted, reactive, ref, toRefs,watch } from 'vue'
import Chat from "./components/chat.vue";
import {GettransactionList,DeleteTransaction} from '@/api/transaction.js'
import Addaffair from "./components/Addaffair.vue";
import Editaffair from "./components/Editaffair.vue";
import { useStore } from 'vuex';
import { shoElmessage, shoElMessageBox } from '../../utils/Elmessage';
import { companyUserList } from '@/api/memberCom';
export default {
    components:{
        Sidebar,
        Chat,
        Addaffair,
        Editaffair
    },
    setup(){
        const addaffair = ref(null);
        const editaffair = ref(null)
        const store = useStore();
        const data = reactive({
            dialogVisible:false,//新增弹出框
            EditaffairVisible:false, //修改弹出框
            logisticsvalue:"",
            logisticsoptionslist:[
                {value:0,label:"已处理"},
                {value:1,label:"未处理"},
                {value:2,label:"普通"},
                {value:3,label:"优先"},
                {value:4,label:"紧急"},
            ],
            affairvalue:"",
            affairlist:[
                {value:0,label:"商品事务"},
                {value:1,label:"采购事务"},
                {value:2,label:"仓储事务"},
                {value:3,label:"个人事务"},
                {value:4,label:"公开事务"},
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
            tableData:[],
            pagination:{
                per_page_num:10,
                page_num:1,
                total:10,
            },
            delete_list:[],
            responsible_person_list:[],
        })
        function CloseBusinesses(e){
            addAffaiirClose()
            GetTableList()
        }
        //修改关闭弹出框
        function CloseEditBu(e){
            EditAffair()
            GetTableList()
        }
        function handleCurrentChange(){
            
        }
        function Delete_TableData(item){
            DeleteAddair(item.id)
        }
        function DeleteAddair(id){
            shoElMessageBox('确定删除事务？','提示删除事务').then(res =>{
                DeleteTransaction({
                    transaction_ids:id
                }).then(res =>{
                    if(res.code ==1){
                        shoElmessage(true,'删除成功')
                        GetTableList()
                    }else{
                        shoElmessage(true,`删除失败，原因${res.msg}`,'error')
                    }
                })
            })
        }
        function AddTransaction(){

        }
        //添加
        function addAffaiirClose(){
            data.dialogVisible = !data.dialogVisible
            addaffair.value.Init();
        }
        //修改
        function EditAffair(item){
            data.EditaffairVisible = !data.EditaffairVisible
            editaffair.value.Init(item);
        }
        function handleClose(){
            data.dialogVisible = false
        }
        function Change(item){
            if(item == '删除'){
                GetTableList();
            }
        }
        function handSelectAll(e){
            data.delete_list = e
        }
        function handSelect(e){
            data.delete_list = e
        }
        onMounted(() =>{
            GetTableList()
        })
        //事务列表
        function GetTableList(){
            GettransactionList({
                company_id:store.state.userinfo.userinfo.company_id,
                ...data.pagination,
            }).then(res =>{
                if(res.code == 1){
                    data.tableData = res.data.data
                    data.pagination.total = res.data.total
                    data.pagination.page_num = res.data.page_num
                    data.pagination.per_page_num = res.data.per_page_num
                }
            })
            companyUserList({
                company_id:store.state.userinfo.userinfo.company_id,
                per_page_num:1000000,
            }).then(res =>{
                if(res.code == 1){
                    data.responsible_person_list = res.data.data
                }
            })
        }
        //批量删除
        function Command(e){
            if(e){
                let list_id = data.delete_list.map(el =>{
                    return el.id;
                })
                DeleteAddair(list_id.join())
            }else{
                shoElmessage(true,'请选择删除列表')
            }
        }
        return{
            handSelect,
            handSelectAll,
            Command,
            ...toRefs(data),
            handleCurrentChange,
            addAffaiirClose,
            handleClose,
            GetTableList,
            DeleteAddair,
            Delete_TableData,
            EditAffair,
            editaffair,
            addaffair,
            AddTransaction,
            CloseBusinesses,
            Change,
            CloseEditBu
        }

    }

}
</script>

<style lang="scss" scoped>
.logistics_header{
    margin-bottom: 10px;
}
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
    padding: 20px;
    background-color: $navBg;
    border-radius: 4px;
}
.pagination{
    padding: 10px 0px;
}
.dialogvisible_list--input{
    max-width: 700px;
}
.el-radio{
    margin-right: 0px;
}
:deep(.el-table .el-table__row .el-table__cell){
    vertical-align: top ;
}
.show_more{
      width: 100%;
      cursor: pointer;
}
</style>
<style lang="scss">
.affair_dialog{
    .el-dialog__header{
        border-bottom: 1px solid #d6d6d6;   
        padding: var(--el-dialog-padding-primary);
    }
    .el-dialog__body{
        overflow: auto;
        height: 80vh;
    }
    .el-dialog__footer{
        border-top: 1px solid #d6d6d6;
        padding: var(--el-dialog-padding-primary);
    }
}
</style>

