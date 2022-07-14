<template>
  <!-- <el-container>
      <el-header>
          <sidebar></sidebar>
      </el-header>
      <el-main> -->
         <div class="table--list flex flex-wrap">
           <div class="search--condition_list flex align-center">
                <el-button type="primary" @click="dialogVisible = true" icon="el-icon-plus">创建包装</el-button>
            </div>
            <div class="search--condition_list flex align-center">
                
                <el-select
                    v-model="ruleForm.userlist"
                
                    filterable
                    allow-create
                    default-first-option
                    placeholder="请选择仓库">
                    <el-option label="123456" :value="1"></el-option>
                    <el-option label="78945132" :value="0"></el-option>
                </el-select>
            </div>
            <div class="search--condition_list flex align-center">
                <el-input v-model="searchId"></el-input>
            </div>
            <div class="search--condition_list flex align-center">
                <el-button type="primary">查找</el-button>
            </div>
           <div class="table_list">
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
                         width="100"
                         >
                        <template #default="scope">{{ scope.row.id }}</template>
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="名称"
                      >
                    </el-table-column>
                     <el-table-column
                        prop="address"
                        label="包装类型"
                      >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="包装规格"
                      >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="包装大小"
                      >
                    </el-table-column>
                    
                    <el-table-column
                        prop="address"
                        label="创建人"
                      >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="创建时间"
                      >
                    </el-table-column>
                    <el-table-column
                        prop="status"
                        label="状态"
                      >
                      <template #default="scope">
                          <el-tag :type="scope.row.status == 1?'success':'error'">{{scope.row.status == 1?'启用':'停用'}}</el-tag>
                      </template>
                    </el-table-column>
                    <el-table-column
                        prop="content"
                        label="备注"
                       

                      >
                    </el-table-column>
                    <el-table-column
                        label="操作"
                        fixed="right"
                        min-width="150"
                    >
                        <template #default="scope">
                          <div class="flex flex-wrap">
                            <div class="el_button--list">
                                <el-button @click="handleClick(scope.row,scope.$index)" type="primary" size="small">编辑</el-button>
                            </div>
                            <div class="el_button--list">
                                <el-button type="danger" size="small">删除</el-button>
                            </div>  
                          </div>
                        </template>
                    </el-table-column>
            </el-table>
           </div>
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
        :title="title"
        v-model="dialogVisible"
        width="50%"
        :before-close="handleClose"

        >
        <el-form ref="form" :model="ruleForm" :rules="rules" >
            <el-form-item label="包装名称：" label-width="18%" prop="name">
                <el-input style="max-width:700px" v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-form-item label="包装类型：" label-width="18%" prop="country">
                <el-select
                    v-model="ruleForm.country"
                    multiple
                    filterable
                    allow-create
                    default-first-option
                    placeholder="请选择包装类型">
                    <el-option
                        v-for="item in options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="包装大小：" label-width="18%" prop="name">
                <el-input style="max-width:700px" v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-form-item label="包装规格：" label-width="18%" prop="name">
                <el-input style="max-width:700px" v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-form-item label="储放仓库：" label-width="18%" prop="country">
                <el-select
                    v-model="ruleForm.country"
                    multiple
                    filterable
                    allow-create
                    default-first-option
                    placeholder="请选择包装入仓库">
                    <el-option
                        v-for="item in options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item prop="resource" label="状态：" label-width="18%" >
                <el-radio-group v-model="ruleForm.status" size="medium">
                    <el-radio border :label="0" :value="0">启动</el-radio>
                    <el-radio border :label="1" :value="1">停用</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="备注：" label-width="18%" prop="textarea">
               <orderlistwang-editor
                :editor="ruleForm.content"
                @Change="editorChange"
                @Onfocus="Onfocus"
                @Onblur="Onblur"
              ></orderlistwang-editor>
            </el-form-item>
            <el-form-item label-width="18%">
                <el-button type="primary" @click="onSubmit">立即创建</el-button>
                <el-button @click="Cancal">取消</el-button>
            </el-form-item>
        </el-form>
  </el-dialog>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { reactive, toRefs } from 'vue';
import OrderlistwangEditor from "../Shopfly/Orderlist/OrderlistwangEditor.vue";
export default {
  components: { Sidebar , OrderlistwangEditor },
  setup(porps,content){
    const data = reactive({
      tableData:[
        {id:1,name:"大山创库",address:'中山',status:1,content:"很大的创库,不信你来瞅瞅。"}
      ],
      title:'创建盘点',
      dialogVisible:false,
      ruleForm:{
            name:"",
            id:12346578,
            address:'',
            status:null,
            content:'',
        },
    })
    function onSubmit(){
      data.tableData.push(data.ruleForm)
    }
    function Cancal(){
      data.dialogVisible = false
      data.ruleForm = {
            name:"",
            id:12346578,
            address:'',
            status:0,
            content:'',
        }
    }
    function handleClick(item,index){
      data.dialogVisible = true
      data.ruleForm = item
    }
    function Delete(item,index){
      data.tableData.splice(index,1)
    }
    function Success(item,index){
      console.log(item,index)
    }
    return {
      ...toRefs(data),
      onSubmit,
      Cancal,
      Delete,
      handleClick,
      Success
    }
  }
}
</script>
<style lang="scss" scoped>
.el-header{
  background-color: $navBg;
  height: auto;
  // box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
  color: #000;
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
.search--condition_list{
    padding: 10px 5px;
}
.table--list{
    padding: 10px;
    background-color: $navBg;
    border-radius: 4px;
}
.table_list{
  width: 100%;
  padding: 10px;
  background-color: $navBg;
  border-radius: 4px;
}
.el_button--list{
  margin: 5px;
}
</style>
<style lang="scss">
.sales_dialog{
    .el-dialog__header{
        border-bottom: 1px solid #d6d6d6;
    }
}
</style>