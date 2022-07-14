<template>
  <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input placeholder="" style="flex: 1" v-model="searchId"></el-input>
    </div>

    <div class="brandMan_list">
      <el-button type="primary">查询</el-button>
    </div>
  </div>
  <div class="product_integration--btn--list flex">
    <div class="logistics_header flex">
      <el-button type="primary" @click="AddDepartmentDialog"
        >创建部门</el-button
      >
    </div>

    <el-dropdown trigger="click" class="product_integration_dropdown" @command="handCommand">
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
      @select="handSelect"
      @select-all="handSelectAll"
    >
      <el-table-column type="selection" width="55"> </el-table-column>
      <el-table-column label="编号" width="120">
        <template #default="scope">{{ scope.row.id }}</template>
      </el-table-column>
      <el-table-column prop="name" label="部门名称" min-width="200">
      </el-table-column>
      <el-table-column prop="pid" label="上级部门" min-width="200">
      </el-table-column>
      <el-table-column prop="sort" label="权重" min-width="200">
      </el-table-column>
      <el-table-column prop="resource" label="状态" min-width="200">
        <template #default="scope">
          <el-tag :type="scope.row.resource == 1 ? 'success' : 'error'">{{
            scope.row.resource == 1 ? "启用" : "停用"
          }}</el-tag>
        </template>
      </el-table-column>
      <!-- <el-table-column prop="content" label="备注" min-width="200">
      </el-table-column> -->
      <el-table-column
        label="操作"
        fixed="right"
        min-width="150"
        show-overflow-tooltip
      >
        <template #default="scope">
          <el-link type="primary" size="small" @click="handleClick(scope.row, scope.$index)">编辑</el-link>
          <el-divider direction="vertical"></el-divider>
          <el-link type="primary" size="small" @click="DeleteClick(scope.row.id,scope.$index)">删除</el-link>
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
  <add-department
    :dialogVisible="dialogVisible"
    :Departmentlist="tableData"
    @DialogClose="Dialog_Close"
    ref="department"
  >

  </add-department>
</template>
<script>
import { defineComponent, onMounted, reactive, toRefs,ref } from "vue";
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import {GetdepartmentList,Deletedepartment } from '@/api/department.js'
import { useStore } from "vuex";
import AddDepartment from "./components/AddDepartment.vue";
import { shoElmessage } from "../../utils/Elmessage";
export default defineComponent({
  components: {
    Sidebar,
    AddDepartment,
  },
  setup(props,content) {
    const store = useStore();
    const department = ref(null);
    const data = reactive({
      tableData: [ ],
      dialogVisible: false,
      pagination:{
        page_num:1,
        per_page_num:100,
        total:10,
      },
      deletelist:[],
    });
    function onSubmit() {
      data.tableData.push(data.ruleForm);
    }
    function Cancal() {
      data.dialogVisible = false;
      data.ruleForm = {
        Managementname: "",
        id: 12346578,
        mobile: "",
        market: "",
        resource: "",
        userlist: "",
        textarea: "",
        managementuser: "",
      };
    }

    function handleClick(item, index) {
      AddDepartmentDialog()
      let data = {
        title:'编辑',
        ...item
      }
      console.log(department)
      department.value.Init(data)
    }
    function GetTableList(){
      GetdepartmentList({
        company_id:store.state.userinfo.userinfo.company_id,
        ...data.pagination
      }).then(res =>{
        if(res.code == 1){
          data.tableData = res.data.data
        }
      })
    }
    //添加部门
    function AddDepartmentDialog(){
      data.dialogVisible = true;
    }
    //关闭弹出框
    function Dialog_Close(){
      console.log('ss')
      data.dialogVisible = false;
      GetTableList()
    }
    //删除table列表
    function DeleteClick(item,index){
      Deletedepartment({
        department_id:item
      }).then(res =>{
        if(res.code ==1){
          GetTableList()
          shoElmessage(true,'删除成功','success')
        }else{
          shoElmessage(true,'删除失败','error')
        }
      })
    }
    //单选
    function handSelect(item){
      console.log(item)
      data.deletelist= item
    }
    //多选
    function handSelectAll(item){
      data.deletelist= item
    }
    function handCommand(){
      if(data.deletelist.length){
        data.deletelist.forEach(el =>{
          DeleteClick(el.id,data.tableData.indexOf(el))
        })
      }
    }
    onMounted(() =>{
      GetTableList()
    })
    return {
      ...toRefs(data),
      onSubmit,
      Cancal,
      handleClick,
      AddDepartmentDialog,
      DeleteClick,
      Dialog_Close,
      handSelect,
      handSelectAll,
      handCommand,
      department
    };
  },
});
</script>
<style scoped lang="scss">
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
.product_integration--btn--list {
  margin: 15px 0px;
  :deep(.product_integration_dropdown) {
    margin-left: 10px;
  }
}
.table--list {
  background-color: $navBg;
  background-color: #fff;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);}
.search--condition_list {
  padding: 10px 5px;
}
.table--list {
  padding: 10px;
  background-color: $navBg;
  border-radius: 4px;
}

.today_outstanding {
  background-color: #fff;
  // padding: 20px;
}
.today_outstanding--title {
  padding: 15px;
  border-bottom: 1px solid #d6d6d6;
}
.today_list {
  width: 100%;
  background-color: #fff;
  height: 100%;
}
</style>
