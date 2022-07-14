<template>
  <!-- <el-container>
      <el-header>
          <sidebar></sidebar>
      </el-header>
      <el-main> -->
        <div class="loft_header">
       <div class="loft_header--list flex align-center">
          <div class="list--title">状态：</div>
          <el-select
                    v-model="ruleForm.userlist"
                
                    filterable
                    allow-create
                    default-first-option
                    placeholder="请选择状态">
                    <el-option label="启用" :value="1"></el-option>
                    <el-option label="停用" :value="0"></el-option>
                </el-select>
       </div>
       <div class="loft_header--list flex align-center">
            <div class="list--title" >关键词：</div>
            <el-input v-model="searchId" style="flex:1;"></el-input>
        </div>
        
           <!-- 中间商品搜索栏 -->
          <div class="loft_header--list">
            <el-button type="primary">查找</el-button>
            <el-button>重置</el-button>
          </div>
     </div>
     <!-- 新增 -->
     <div class="loftAdd_btn">
       <div class="loftAdd_btn--list flex">
          <el-button type="primary" class="el-icon-plus" @click="editVisible()">新增仓库</el-button>
          <el-dropdown trigger="click" class="product_type_dropdown" @command="Command">
                <el-button>
                  更多操作<i class="el-icon-arrow-down el-icon--right"></i>
                </el-button>
                <template #dropdown>
                  <el-dropdown-menu >
                    <el-dropdown-item command="a">
                    批量删除
                    </el-dropdown-item>
                  </el-dropdown-menu>
                </template>
            </el-dropdown>
        </div>
     </div>
         <div class="table--list flex flex-wrap">
           <div class="table_list">
             <el-table
                ref="multipleTable"
                :data="tableData"
                tooltip-effect="dark"
                style="width: 100%"
                 @select-all="SelectAll"
                @select="Select"
                :border="true"
                >
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
                        label="仓库名称"
                      >
                    </el-table-column>
                    <el-table-column
                        prop="postal_code"
                        label="编码"
                      >
                    </el-table-column>
                     <!-- <el-table-column
                        prop="address"
                        label="详细地址"
                      >
                    </el-table-column> -->
                    <el-table-column
                        prop="is_default"
                        label="默认"
                      >
                    <template #default="scope">
                      <el-tag :type="scope.row.is_default == 1?'success':'danger'">{{scope.row.is_default == 1?'是':'否'}}</el-tag>
                    </template>
                    </el-table-column>
                    <el-table-column
                        prop="status"
                        label="状态"
                      >
                      <template #default="scope">
                          <el-tag :type="scope.row.type == 1?'':'success'">{{scope.row.type == 1?'本地':'海外'}}</el-tag>
                      </template>
                    </el-table-column>
                    <el-table-column
                        prop="create_time"
                        label="创建时间"
                      >
                    </el-table-column>
                    <el-table-column
                        prop="phone"
                        label="联系电话"
                      >
                    </el-table-column>
                    <el-table-column
                        label="操作"
                        fixed="right"
                        min-width="150"
                        align="center"
                        show-overflow-tooltip>
                        <template #default="scope">
                            <el-link @click="editVisible(scope.row)" type="primary" size="small" >编辑</el-link>
                            <el-divider direction="vertical"></el-divider>
                            <el-link type="primary" size="small" @click="deleteLoft(scope.row,scope.row.id)"   >删除</el-link>
                        </template>
                    </el-table-column>
            </el-table>
           </div>
            <div class="pagination">
                <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="pageData.cur"
                    :page-sizes="[10, 20, 30, 40]"
                    :page-size="pageData.size"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="pageData.total">
            </el-pagination>
            </div>
         </div>
          <!-- 显示弹框 -->
  <el-dialog
    :title="title"
    v-model="editVisi"
    width="50%"
    top="20px"
    :before-close="handleClose"
    :show-close="false"
    :fullscreen="isFullscreen"
    custom-class="dialog_supplier"
  >
    <template #title>
      <div class="el-dialog_title">
        <div class="title">{{ title }}</div>
        <div class="icon_list">
          <div class="screenfull" @click="Screen">
            <svg
              class="screen-out"
              width="18"
              height="18"
              viewBox="0 0 48 48"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M33 6H42V15"
                stroke="#000000"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="miter"
              />
              <path
                d="M42 33V42H33"
                stroke="#000000"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="miter"
              />
              <path
                d="M15 42H6V33"
                stroke="#000000"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="miter"
              />
              <path
                d="M6 15V6H15"
                stroke="#000000"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="miter"
              />
            </svg>
          </div>
          <i class="el-icon-close" @click="Close"></i>
        </div>
      </div>
    </template>
    <el-form  :model="editList"  :rules="rules" ref="editLis">
      <el-form-item label="仓库名称：" label-width="18%" prop="name">
        <el-input
          style="max-width: 700px"
          v-model="editList.name"
        ></el-input>
      </el-form-item>
      <el-form-item label="编码：" label-width="18%" prop="postal_code">
        <el-input
          style="max-width: 700px"
          v-model="editList.postal_code"
        ></el-input>
      </el-form-item>
      <!-- <el-form-item label="详细地址：" label-width="18%" prop="address">
        <el-input
          style="max-width: 700px"
          v-model="editList.address"
        ></el-input>
      </el-form-item> -->
      <el-form-item
        prop="is_default"
        label="是否默认："
        label-width="18%"
      >
        <el-radio-group v-model="editList.is_default" size="medium">
          <el-radio border label='0' :value="0">否</el-radio>
          <el-radio border label="1" :value="1">是</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item prop="type" label="状态：" label-width="18%">
        <el-radio-group v-model="editList.type" size="medium">
          <el-radio border label="1" :value="1">本地</el-radio>
          <el-radio border label="2" :value="2">海外</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="联系电话：" label-width="18%" prop="phone">
        <el-input
          style="max-width: 700px"
          v-model="editList.phone"
        ></el-input>
      </el-form-item>
      <!-- <el-form-item label="备注：" label-width="18%" prop="textarea">
               <el-input
                    type="textarea"
                    :autosize="{minRows:4,maxRows:20}"
                    placeholder="请输入内容"
                    v-model="ruleForm.content">
                </el-input>
            </el-form-item> -->
    </el-form>
    <template #footer class="el-dialog-footer">
      <el-button @click="editVisi = false">重置</el-button>
      <el-button
        type="primary"
        @click="btn_loft== '立即创建'? addLoft_table('editLis'): loftUpdate_table('editLis')
        "
        >{{ btn_loft }}</el-button
      >
    </template>
  </el-dialog>
      <!-- </el-main>
  </el-container> -->
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { warehouseAdd,warehouseUpdate,warehouseDelete,warehouseList } from "@/api/warehouseManagement";
import { isNaLL } from "../../utils/utils";
import { shoElmessage } from "@/utils/Elmessage";
import { onMounted, reactive, toRefs } from 'vue';
import { useStore } from 'vuex';
export default {
  components: { Sidebar },
  setup(porps,content){
    const store = useStore();
    const data = reactive({
       //所有信息
      tableData: [],
       //批量删除文件
      Delete_list:[],
      title:'添加国家',
      dialogVisible:false,
      ruleForm:{
            name:"",
            id:12346578,
            status:null,
            content:'',
        },
        pageData: {
        cur: "",
        size: "",
        total: "",
      }, 
      // 仓库弹框
       editVisi:false,
       editList:{},
       // 规则
      rules: {
        name: [{ required: true, message: "必填项", trigger: "blur" }],
      },
       isFullscreen:false,
       title:'',
       btn_loft:"",
    })
    function onSubmit(){
      data.tableData.push(data.ruleForm)
    }
    // 从服务端获取列表数据
    function Cancal(){
      data.dialogVisible = false
      data.ruleForm = {
            name:"",
            id:12346578,
            status:0,
            content:'',
        }
    }
    // function handleClick(item,index){
    //   data.dialogVisible = true
    //   data.ruleForm = item
    // }
    function Delete(item,index){
      data.tableData.splice(index,1)
    }
    onMounted(() =>{
      Getwarehouse_List();
    })
    // 从服务端获取列表数据
    function Getwarehouse_List(){
      warehouseList({
        company_id: store.state.userinfo.userinfo.company_id,
        page_num: data.pageData.cur,
        per_page_num:data.pageData.size,
      }).then(res =>{
        if(res.code == 1){
            data.tableData = res.data.data
            data.pageData = res.data
        }else{
        }
      })
    }
    return {
      ...toRefs(data),
      onSubmit,
      Cancal,
      Delete,
      // handleClick,
      Getwarehouse_List,
    }
    
  },
  methods: {
    // 修改仓库弹框
    editVisible(item) {
      this.editList = {};
      this.title = "新增仓库";
      this.btn_loft = "立即创建";
      if (isNaLL(item)) {
        console.log(item)
        this.editList = item;
        this.title = "修改仓库";
        this.btn_loft = "立即修改";
      }
      this.editVisi = true;
    },
      //关闭dialog
    Close(item){
      this.isFullscreen=false
      this.editVisi = !this.editVisi;
      this.$refs['editLis'].resetFields()
    },
    //放大弹出框
    Screen(){
      this.isFullscreen = !this.isFullscreen
    },
    //新增仓库
    addLoft_table(formName) {
      warehouseAdd({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        name: this.editList.name,
        postal_code: this.editList.postal_code,
        country: this.editList.country,
        provinces:this.editList.provinces,
        city:this.editList.city,
        phone:this.editList.phone,
        is_default:this.editList.is_default,
        type:this.editList.type,
      }).then((res) => {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            console.log("success submit!!");
          } else {
            console.log("error submit!!");
          }
        });
        if (res.code == 1) {
          shoElmessage(true, "添加成功");
          this.Getwarehouse_List();
          this.Close();
        }
      });
    },
     //编辑仓库
     loftUpdate_table() {
      warehouseUpdate({
       company_id: this.$store.state.userinfo.userinfo.company_id,
        warehouse_id:this.editList.id,
        name: this.editList.name,
        postal_code: this.editList.postal_code,
        country: this.editList.country,
        provinces:this.editList.provinces,
        city:this.editList.city,
        phone:this.editList.phone,
        is_default:this.editList.is_default,
        type:this.editList.type,
      }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "修改成功");
          this.Getwarehouse_List();
          this.Close();
        }
      });
    }, 
    // 删除仓库
    deleteLoft(index, lis) {
      warehouseDelete({
        warehouse_id: lis,
      }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "删除成功");
          this.Getwarehouse_List();
        } else {
          shoElmessage("el-icon-warning", "删除失败", "error");
        }
      });
    },
    //全选
    SelectAll(item) {
      this.Delete_list = item;
    },
    //单选
   Select(item){
      this.Delete_list = item;
    },
    // 批量删除
    Command(command){
      if (command == "a"){
        if(this.Delete_list.length != 0){
        let item = [];
        this.Delete_list.forEach(el =>{
            item.push(el.id)
        })
        this.deleteLoft('批量删除',item.join());
      }else{
        shoElmessage('el-icon-warning','请选择删除列表','error')
      }
      }
    },

    // 监听pagenum的改变
    handleCurrentChange(newPage) {
      this.pageData.cur = newPage;
      this.Getwarehouse_List();
    },
    // 监听pagesize改变
    handleSizeChange(newSize) {
      this.pageData.size = newSize;
      this.Getwarehouse_List();
    },
  }
}
</script>
<style lang="scss" scoped>
.loft_header{
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  box-shadow: 0 1px 3px 0 rgb(0 0 0 / 10%), 0 0 3px 0 rgb(0 0 0 / 2%);
  .loft_header--list{
    margin:5px;
    .list--title{
      width: 70px;
      text-align: right;
    }
  }
  
}
.loftAdd_btn{
  margin:15px 0px;
  .loftAdd_btn--list{
    :deep(.product_type_dropdown){
      margin-left: 10px;
    }
  }
}
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
  background-color: #fff;
  box-sizing: border-box;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.03);
  padding: 20px;
}
.table_list{
  width: 100%;
  padding: 10px;
  background-color: $navBg;
  border-radius: 4px;
}
// 编辑仓库弹框
.el-dialog_title {
  width: 100%;
  display: flex;
  justify-content: space-between;
  font-size: 18px;
  cursor: pointer;
  .icon_list {
    display: flex;
    align-items: center;
    .screenfull {
      padding: 0px 10px;
      display: flex;
      align-items: center;
    }
    i {
      font-size: 20px;
      color: #000;
      font-weight: bold;
    }
  }
}
</style>
<style lang="scss">
.dialog_brand {
  .el-dialog__header {
    border-bottom: 1px solid #eee;
  }
  .el-dialog__body {
    padding: 20px;
  }
  .el-dialog__footer {
    border-top: 1px solid #eee;
  }
}
.sales_dialog{
    .el-dialog__header{
        border-bottom: 1px solid #d6d6d6;
    }
}
</style>