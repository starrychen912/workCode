<template>
  <!-- <el-container>
      <el-header>
          <sidebar></sidebar>
      </el-header>
      <el-main> -->
        <div class="search--condition_header flex align-center flex-wrap">
            <div class="search--condition_list flex align-center">
              
          <div class="label">国家：</div>
          
                <el-select
                    v-model="ruleForm.userlist"
                    multiple
                    filterable
                    allow-create
                    default-first-option
                    placeholder="请选择国家">
                    <el-option
                        v-for="item in options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="search--condition_list flex align-center">
              <div class="label">关键字：</div>
                <el-input v-model="searchId" style="flex:1;"></el-input>
            </div>
            <div class="search--condition_list flex align-center">
                <el-button type="primary">查找</el-button>
            </div>
         </div>
         <!-- 中间新增 -->
         <div class="product_integration--btn--list flex">
        <el-button type="primary" @click="dialogVisible = true">新增平台</el-button>
        <el-dropdown trigger="click" class="product_integration_dropdown">
              <el-button>
                更多操作<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <template #dropdown>
                <el-dropdown-menu >
                  <el-dropdown-item>
                   批量删除
                  </el-dropdown-item>
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
                        prop="country"
                        label="国家"
                       

                      >
                    </el-table-column>
                    <el-table-column
                        prop="currency"
                        label="货币"
                       

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
                        align="center"
                        show-overflow-tooltip>
                        <template #default="scope">
                            <el-link @click="handleClick(scope.row,scope.$index)" type="primary" size="small">编辑</el-link>
                            <el-divider direction="vertical"></el-divider>
                            <el-link type="primary" size="small" @click="Delete(scope.row,scope.$index)">删除</el-link>
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
        :title="title"
        v-model="dialogVisible"
        width="50%"
        :before-close="handleClose"
        custom-class="sales_dialog"
        >
        <el-form ref="form" :model="ruleForm" :rules="rules" >
            <el-form-item label="名称：" label-width="18%" prop="Managementname">
                <el-input style="max-width:700px" v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-form-item label="货币：" label-width="18%" prop="Managementname">
                <el-input style="max-width:700px" v-model="ruleForm.currency"></el-input>
            </el-form-item>
            <el-form-item label="国家：" label-width="18%" prop="country">
                <el-select
                    v-model="ruleForm.country"
                    multiple
                    filterable
                    allow-create
                    default-first-option
                    placeholder="请选择国家">
                    <el-option
                        v-for="item in options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item prop="resource" label="店铺状态：" label-width="18%" >
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
import OrderlistwangEditor from "../Shopfly/Orderlist/OrderlistwangEditor.vue";
import { reactive, toRefs } from 'vue';
export default {
  components: { Sidebar,OrderlistwangEditor },
  setup(porps,content){
    const data = reactive({
      tableData:[
        {id:1,name:"美国",country:'美国,加拿大,日本,英国,德国',currency:'US',status:1,content:"美国佬",continent:'洲'}
      ],
      title:'添加国家',
      dialogVisible:false,
      ruleForm:{
            name:"",
            id:12346578,
            country:'',
            currency:'',
            status:null,
            content:'',
            continent:'',
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
            country:'',
            currency:'',
            status:0,
            content:'',
            continent:'',
        }
    }
    function handleClick(item,index){
      data.dialogVisible = true
      data.ruleForm = item
    }
    function Delete(item,index){
      data.tableData.splice(index,1)
    }
    return {
      ...toRefs(data),
      onSubmit,
      Cancal,
      Delete,
      handleClick
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
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  font-size: 14px;
  padding: 20px 10px;
    span{
        padding: 0px 5px;
    }
    .search--condition_list{
    padding: 10px 5px;
}
}
// 中间新增
.product_integration--btn--list{
  margin: 15px 0px;
  :deep(.product_integration_dropdown){
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
  .pagination{
    padding: 15px 0px;
  }

}

</style>
<style lang="scss">
.sales_dialog{
    .el-dialog__header{
        border-bottom: 1px solid #d6d6d6;
    }
}
</style>