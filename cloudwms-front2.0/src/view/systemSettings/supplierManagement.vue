<template>
  <!-- <el-container>
    <el-header>
      <sidebar></sidebar>
    </el-header>
    <el-main> -->
  <!-- 头部 -->
  <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input placeholder="" style="flex: 1"></el-input>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <!-- 新增 -->
  <div class="supplierMan--btn--list flex">
    <el-button type="primary" class="el-icon-plus" @click="editVisible()"
      >新增供应商</el-button
    >
    <el-dropdown trigger="click" class="supplierMan_dropdown"  @command="Command">
      <el-button>
        更多操作<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <template #dropdown>
        <el-dropdown-menu>
          <el-dropdown-item command="a"> 批量删除 </el-dropdown-item>
        </el-dropdown-menu>
      </template>
    </el-dropdown>
  </div>
  <!--表格-->
  <el-tabs type="border-card">
    <el-tab-pane label="供应商列表">
      <div class="table_backCol">
        <!-- 表格 -->
        <div class="itemList">
          <el-table
            :data="lis"
            style="width: 100%"
            :border="true"
            @select-all="SelectAll"
            @select="Select"
          >
            <el-table-column type="selection" width="55"> </el-table-column>
            <el-table-column
              label="编号"
              prop="id"
              width="100px"
              align="center"
              @rowIndex="lastRow"
            >
            </el-table-column>
            <el-table-column
              label="供应商名称"
              prop="supplier_name"
              align="center"
            >
            </el-table-column>
            <el-table-column label="联系人" prop="link_man" align="center">
            </el-table-column>
            <el-table-column
              label="联系方式"
              prop="phone_number"
              align="center"
            >
            </el-table-column>
            <el-table-column label="联系地址" prop="address" align="center">
            </el-table-column>
            <el-table-column
              label="修改时间"
              prop="modified_time"
              align="center"
            >
            </el-table-column>
            <el-table-column
              label="银行账户"
              prop="bank_account"
              align="center"
            >
            </el-table-column>
            <el-table-column label="银行名称" prop="bank_name" align="center">
            </el-table-column>
            <el-table-column label="状态" prop="supplier_status" align="center">
              <template #default="scope">
                <el-tag
                  :type="
                    scope.row.supplier_status == 0 || scope.row.supplier_status == ''
                      ? 'warning'
                      : scope.row.supplier_status == 1
                      ? 'success'
                      : ''
                  "
                >
                  {{
                    scope.row.supplier_status == 0 || scope.row.supplier_status == ''
                      ? "禁止"
                      : scope.row.supplier_status == 1
                      ? "启用"
                      : ""
                  }}
                </el-tag>
              </template>
            </el-table-column>
            <el-table-column label="类型" prop="supplier_type" align="center">
              <template #default="scope">
                <el-tag
                  :type="
                    scope.row.supplier_type == 1 ||  scope.row.supplier_type == ''
                      ? 'warning'
                      : scope.row.supplier_type == 2
                      ? 'success'
                      : ''
                  "
                >
                  {{
                    scope.row.supplier_type == 1 ||  scope.row.supplier_type == ''
                      ? "自营"
                      : scope.row.supplier_type == 2
                      ? "平台"
                      : ""
                  }}
                </el-tag>
              </template>
            </el-table-column>
            <el-table-column
              label="操作"
              prop="operate"
              size="small"
              align="center"
              width="150px"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-link
                    type="primary"
                    size="small"
                    @click="editVisible(scope.row)"
                    
                    >编辑</el-link
                  >
                  <el-divider direction="vertical"></el-divider>
                  <el-link
                    type="primary"
                    size="small"
                    @click="supplierDelete_table(scope.$index, scope.row.id)"
                      
                    >删除</el-link
                  >
                </div>
              </template>
            </el-table-column>
          </el-table>
        </div>
        <!-- 分页 -->
        <div class="pagination-list">
          <el-pagination
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            :current-page="data.cur"
            :page-size="data.size"
            layout="total, sizes, prev, pager, next, jumper"
            :total="data.total"
          >
          </el-pagination>
        </div>
      </div>
    </el-tab-pane>
  </el-tabs>
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
    <el-form ref="editList" :model="editList" :rules="rules">
      <el-form-item label="供应商名称：" label-width="18%" prop="supplier_name">
        <el-input
          style="max-width: 700px"
          v-model="editList.supplier_name"
        ></el-input>
      </el-form-item>
      <el-form-item label="联系人：" label-width="18%" prop="link_man">
        <el-input
          style="max-width: 700px"
          v-model="editList.link_man"
        ></el-input>
      </el-form-item>
      <el-form-item label="联系方式：" label-width="18%" prop="phone_number">
        <el-input
          style="max-width: 700px"
          v-model="editList.phone_number"
        ></el-input>
      </el-form-item>
      <el-form-item label="联系地址：" label-width="18%" prop="address">
        <el-input
          style="max-width: 700px"
          v-model="editList.address"
        ></el-input>
      </el-form-item>
      <el-form-item label="银行账户：" label-width="18%" prop="bank_account">
        <el-input
          style="max-width: 700px"
          v-model="editList.bank_account"
        ></el-input>
      </el-form-item>
      <el-form-item label="银行名称：" label-width="18%" prop="bank_name">
        <el-input
          style="max-width: 700px"
          v-model="editList.bank_name"
        ></el-input>
      </el-form-item>
      <el-form-item
        prop="supplier_status"
        label="供应商状态："
        label-width="18%"
      >
        <el-radio-group v-model="editList.supplier_status" size="medium">
          <el-radio border :label="0" :value="0">禁止</el-radio>
          <el-radio border :label="1" :value="1">启用</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item prop="supplier_type" label="供应商类型：" label-width="18%">
        <el-radio-group v-model="editList.supplier_type" size="medium">
          <el-radio border :label="1" :value="1">自营</el-radio>
          <el-radio border :label="2" :value="2">平台</el-radio>
        </el-radio-group>
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
        @click="btn_supplier == '立即创建'? supplierAdd_table('editList'): supplierUpdate_table('editList')
        "
        >{{ btn_supplier }}</el-button
      >
    </template>
  </el-dialog>
  <!-- </el-main>
  </el-container> -->
</template>

<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import {
  GetSupplierList,
  supplierAdd,
  supplierDelete,
  supplierUpdate,
} from "../../api/supplierManagement";
import { isNaLL } from "../../utils/utils";
import { shoElmessage } from "@/utils/Elmessage";
export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      value1: [],
      keyWord: "",
      options1: [
        {
          value: "选项1",
          label: "全部",
        },
        {
          value: "选项2",
          label: "深圳",
        },
        {
          value: "选项3",
          label: "中山",
        },
        {
          value: "选项4",
          label: "北京 ",
        },
        {
          value: "选项5",
          label: "MV",
        },
      ],
      editVisi: false,
      lis: [
        
      ],
      data: {
        cur: "",
        size: "",
        total: "",
      },
      checkList: ["复选框 A"],
      editList: {
      },
      title: "",
      isFullscreen: false,
      btn_supplier: "",
      // 规则
      rules: {
        supplier_name: [
          { required: true, message: "请输入供应商名称", trigger: "blur" },
        ],
      },
      //批量删除
      Delete_list:[]
    };
  },
  //生命周期
  mounted() {
    this.Getlist();
  },
  created() {
    this.value1 = this.options1[0].value;
  },
  methods: {
    Getlist() {
      GetSupplierList({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        page_num: this.data.cur,
        per_page_num: this.data.size,
      }).then((res) => {
        console.log(res);
        if (res.code == 1) {
          this.lis = res.data.data;
          this.data = res.data;
        }
      });
    },
    // 全选
     SelectAll(item) {
      this.Delete_list = item;
    },
    //单选
   Select(item){
      this.Delete_list = item;
    },
    Command(command){
      if (command == "a"){
        if(this.Delete_list.length != 0){
        let item = [];
        this.Delete_list.forEach(el =>{
            item.push(el.id)
        })
        this.supplierDelete_table('批量删除',item.join());
      }else{
        shoElmessage('el-icon-warning','请选择删除列表','error')
      }
      }
    },
    // 监听pagenum的改变
    handleCurrentChange(newPage) {
      this.data.cur = newPage;
      this.Getlist();
    },
    // 监听pagesize改变
    handleSizeChange(newSize) {
      this.data.size = newSize;
      this.Getlist();
    },
    // 打开供应商的弹框
    editVisible(item) {
      this.editList = {};
      this.title = "新增供应商";
      this.btn_supplier = "立即创建";
      if (isNaLL(item)) {
        // this.form = [];
        this.editList = item;
        this.title = "修改供应商";
        this.btn_supplier = "立即修改";
      }
      this.editVisi = true;
    },
    // 新增供应商
    supplierAdd_table(formName) {
      supplierAdd({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        supplier_name: this.editList.supplier_name,
        supplier_code: this.editList.supplier_code,
        supplier_type: this.editList.supplier_type,
        link_man: this.editList.link_man,
        phone_number: this.editList.phone_number,
        bank_name: this.editList.bank_name,
        bank_account: this.editList.bank_account,
        address: this.editList.address,
        supplier_status: this.editList.supplier_status,
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
          this.Getlist();
          this.Close();
        }
      });
    },
    // 删除供应商
    supplierDelete_table(index, lis) {
      supplierDelete({
        supplier_id: lis,
      }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "删除成功");
          this.Getlist();
          this.lis.splice(index, 1);
        } else {
          shoElmessage("el-icon-warning", "删除失败", "error");
        }
      });
    },
    // 编辑供应商
    supplierUpdate_table() {
      console.log('123')
      supplierUpdate({
        supplier_id: this.editList.id,
        supplier_name: this.editList.supplier_name,
        supplier_code: this.editList.supplier_code,
        supplier_type: this.editList.supplier_type,
        link_man: this.editList.link_man,
        phone_number: this.editList.phone_number,
        bank_name: this.editList.bank_name,
        bank_account: this.editList.bank_account,
        address: this.editList.address,
        supplier_status: this.editList.supplier_status,
      }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "修改成功");
          this.Getlist();
          this.Close();
        }
      });
    },
    // 弹框全屏
    Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    // 关闭弹框
    Close() {
      this.editVisi = !this.editVisi;
      this.isFullscreen = false;
      this.$refs["editList"].resetFields();
    },
  },
};
</script>
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
</style>


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
// 新增
.supplierMan--btn--list {
  margin: 15px 0px;
  :deep(.supplierMan_dropdown) {
    margin-left: 10px;
  }
}
.el-tabs--border-card {
  background-color: $navBg;
  background-color: #fff;
  border-radius: 2px;
  // padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .pagination-list {
    padding: 15px 0px;
  }
}
// 供应商弹框
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
.pagination-list {
  padding: 15px 0px;
}
</style>