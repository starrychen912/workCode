<template>
  <!-- <el-container>
      <el-header>
          <sidebar></sidebar>
      </el-header>
      <el-main> -->
  <div class="productInfo_header">
    <div class="product_info--list flex align-center">
      <div class="label">仓库：</div>
      <el-select v-model="value1">
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
    <div class="product_info--list flex align-center">
      <div class="label">物料类型：</div>
      <el-select v-model="value1">
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
    <div class="product_info--list flex align-center">
      <div class="label">关键字：</div>
      <el-input
        placeholder="请输入商品名称"
        style="flex: 1"
        v-model="keywords"
      ></el-input>
    </div>

    <!-- 中间商品搜索栏 -->
    <div class="product_info--list">
      <el-button type="primary" @click="Getlist">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <!-- 中间新增 -->
  <div class="product_integration--btn--list flex">
    <el-button type="primary" class="el-icon-plus" @click="editVisible()"
      >新增物料</el-button
    >
    <el-dropdown trigger="click" class="product_integration_dropdown" @command="Command"> 
      <el-button>
        更多操作<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <template #dropdown>
        <el-dropdown-menu>
          <el-dropdown-item  command="a"> 批量删除 </el-dropdown-item>
        </el-dropdown-menu>
      </template>
    </el-dropdown>
  </div>
  <div class="table--list flex flex-wrap">
    <div class="table_list">
      <el-table
        ref="multipleTable"
        :data="tableData"
        tooltip-effect="dark"
        style="width: 100%"
        @selection-change="handleSelectionChange"
        :row-class-name="tableRowClassName"
        @select-all="SelectAll"
        @select="Select"
      >
        <el-table-column type="selection" width="55"> </el-table-column>
        <el-table-column label="编号" width="100">
          <template #default="scope">{{ scope.row.id }}</template>
        </el-table-column>
        <el-table-column prop="name" label="物料名称"> </el-table-column>
        <el-table-column prop="sku_id" label="sku"> </el-table-column>
        <el-table-column prop="weight" label="重量"> </el-table-column>
        <el-table-column prop="weight_unit" label="重量单位"> </el-table-column>
        <el-table-column prop="length" label="长度"> </el-table-column>
        <el-table-column prop="width" label="宽度"> </el-table-column>
        <el-table-column prop="height" label="高度"> </el-table-column>
                <el-table-column prop="dimensions_unit" label="测量单位"> </el-table-column>

        <el-table-column prop="type" label="类型"> </el-table-column>
        <el-table-column prop="stock_warning" label="库存警告"> </el-table-column>
        <el-table-column prop="mark" label="备注"> </el-table-column>
        <el-table-column label="操作" fixed="right" min-width="150">
          <template #default="scope">
            <div class="flex flex-wrap">
              <div class="el_button--list">
                <el-button
                  @click="editVisible(scope.row)"
                  type="primary"
                  size="small"
                  >编辑</el-button
                >
              </div>
              <div class="el_button--list">
                <el-button type="danger" size="small" @click="deleteMaterial(scope.$index, scope.row.id)">删除</el-button>
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
        :current-page="querInfo.pagenum"
        :page-sizes="[10, 20, 30, 40]"
        :page-size="querInfo.pagesize"
        layout="total, sizes, prev, pager, next, jumper"
        :total="querInfo.total"
      >
      </el-pagination>
    </div>
  </div>
  <!-- </el-main>
  </el-container> -->
 
  <el-dialog
    v-model="editVisi"
    width="50%"
    top="20px"
    :before-close="handleClose"
    :show-close="false"
    :fullscreen="isFullscreen"
    custom-class="dialog_member"
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
    <el-form ref="editlist" :model="editList" :rules="rules">
      <el-form-item label="名称：" label-width="18%" prop="name">
        <el-input style="max-width: 700px" v-model="editList.name"></el-input>
      </el-form-item>
      <el-form-item label="类型：" label-width="18%" prop="type">
        <el-select v-model="editList.type" placeholder="请选择">
          <el-option
           
            label="纸箱盒子"
            value="纸箱盒子"
          >
          </el-option>
           <el-option
           
            label="胶带包装"
            value="胶带包装"
          >
          </el-option>
          <el-option
           
            label="材料工具"
            value="材料工具"
          >
          </el-option>
          <el-option
           
            label="赠品附件"
            value="赠品附件"
          >
          </el-option>
        </el-select>
      </el-form-item>

      <el-form-item label="重量：" label-width="18%" prop="weight">
        <el-input style="max-width: 700px" v-model="editList.weight"></el-input>
      </el-form-item>
      <el-form-item label="长度: " label-width="18%" prop="length">
        <el-input style="max-width: 700px" v-model="editList.length"></el-input>
      </el-form-item>
      <el-form-item label="宽度: " label-width="18%" prop="width">
        <el-input style="max-width: 700px" v-model="editList.width"></el-input>
      </el-form-item>
      <el-form-item label="高度: " label-width="18%" prop="height">
        <el-input style="max-width: 700px" v-model="editList.height"></el-input>
      </el-form-item>
      <el-form-item label="库存预警数: " label-width="18%" prop="stock_warning">
        <el-input
          style="max-width: 700px"
          v-model="editList.stock_warning"
        ></el-input>
      </el-form-item>
      <el-form-item label="备注: " label-width="18%" prop="mark">
        <EditWangeditor
          ref="editwangeditor"
          :editor="editList.mark"
          v-model="editList.mark"
        ></EditWangeditor>
      </el-form-item>
    </el-form>
    <template #footer class="el-dialog-footer">
      <el-button @click="editVisi = false">取消</el-button>
      <el-button
        type="primary"
        @click="
          btn_brand == '新增'
            ? materialAdd_table('editlist')
            : materialUpdate_table('editlist')
        "
        >{{ btn_brand }}</el-button
      >
    </template>
  </el-dialog>
</template>
<script>
import { isNaLL } from "../../utils/utils";
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import {
  materialList,
  materialAdd,
  materialDelete,
  materialUpdate,
} from "../../api/material";
import { reactive, toRefs } from "vue";
import EditWangeditor from "../../components/EditWangeditor/EditWangeditor.vue";
import { shoElmessage } from "@/utils/Elmessage";
export default {
  components: { Sidebar, EditWangeditor },
  setup(porps, content) {
    const data = reactive({
      tableData: [],
      title2: "出库",
      dialogVisible2: false,
      keywords: "",
      title: "新建物料",
      dialogVisible: false,
      ruleForm: {
        name: "",
        id: 12346578,
        address: "",
        status: null,
        content: "",
        narerialstype: "",
        materials: "",
        warehouse: "",
      },
      list: [
        "https://fuss10.elemecdn.com/a/3f/3302e58f9a181d2509f3dc0fa68b0jpeg.jpeg",
        "https://fuss10.elemecdn.com/1/34/19aa98b1fcb2781c4fba33d850549jpeg.jpeg",
        "https://fuss10.elemecdn.com/0/6f/e35ff375812e6b0020b6b4e8f9583jpeg.jpeg",
        "https://fuss10.elemecdn.com/9/bb/e27858e973f5d7d3904835f46abbdjpeg.jpeg",
        "https://fuss10.elemecdn.com/d/e6/c4d93a3805b3ce3f323f7974e6f78jpeg.jpeg",
        "https://fuss10.elemecdn.com/3/28/bbf893f792f03a54408b3b7a7ebf0jpeg.jpeg",
        "https://fuss10.elemecdn.com/2/11/6535bcfb26e4c79b48ddde44f4b6fjpeg.jpeg",
      ],
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
      // 弹框
      editVisi: false,
      isFullscreen: false,
      rules: {
        name: [{ required: true, message: "必填项", trigger: "blur" }],
        type: [{ required: true, message: "必填项", trigger: "blur" }],
      },
      Delete_list: [],
      lis: [],
      querInfo: {},
      editList: {},
      btn_brand:'新增'

    });
    function onSubmit() {
      data.tableData.push(data.ruleForm);
    }
    function Cancal() {
      data.dialogVisible = false;
      data.ruleForm = {
        name: "",
        id: 12346578,
        address: "",
        status: 0,
        content: "",
      };
    }
    function handleClick(item, index) {
      data.dialogVisible = true;
      data.ruleForm = item;
    }
    function Delete(item, index) {
      data.tableData.splice(index, 1);
    }
    function Success(item, index) {
      // console.log(item,index)
    }
    function handleCurrentChange() {}
    function OpenMaterials() {
      data.dialogVisible2 = true;
    }
    function tableRowClassName({ row, rowIndex }) {
      // console.log(row,rowIndex)
      if (rowIndex === 0) {
        return "warning-row";
      }
      return "";
    }
    return {
      ...toRefs(data),
      onSubmit,
      Cancal,
      Delete,
      handleClick,
      Success,
      handleCurrentChange,
      OpenMaterials,
      tableRowClassName,
    };
  },
  mounted() {
    this.Getlist();
  },
  methods: {
    Getlist() {
      materialList({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        name: this.keywords,
      }).then((res) => {
        if (res.code == 1) {
          this.tableData = res.data.data;
          this.querInfo.total = res.data.total;
          this.querInfo.pagenum = res.data.cur;
          this.querInfo.pagesize = res.data.size;
        }
      });
    },
    // 监听pagesize改变
    handleSizeChange(newSize) {
      this.lis = [];
      this.querInfo.pagesize = newSize;
      this.Getlist();
    },
    // 监听pagenum的改变
    handleCurrentChange(newPage) {
      this.lis = [];
      this.querInfo.pagenum = newPage;
      this.Getlist();
    },
    //全选
    SelectAll(item) {
      this.Delete_list = item;
    },
    //单选
    Select(item) {
      this.Delete_list = item;
    },
    
    // 批量删除
    Command(command) {
      if (command == "a") {
        console.log('aaa')
        if (this.Delete_list.length != 0) {
          let item = [];
          this.Delete_list.forEach((el) => {
            item.push(el.id);
          });
          this.deleteMaterial("批量删除", item.join());
        } else {
          shoElmessage("el-icon-warning", "请选择删除列表", "error");
        }
      }
    },
    editVisible(item) {
      this.editList = {};
      this.title = "新增物料";
      this.btn_brand = "新增";
      if (isNaLL(item)) {
        this.editList = item;
        this.title = "编辑物料";
        this.btn_brand = "编辑";
        console.log(this.editList);
        // console.log(this.filelist)
      }
      this.editVisi = true;
    },

    Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    Close() {
      this.editVisi = !this.editVisi;
      this.isFullscreen = false;
      this.filelist = [];
      this.$refs["editlist"].resetFields();
    },
    materialAdd_table(formName) {
      console.log('qqq')
      materialAdd({
        company_id: this.$store.state.userinfo.userinfo.company_id,
          ...this.editList,
      }).then((res) => {
        this.$refs[formName].validate((valid) => {
          if (valid) {
             if (res.code == 1) {
          shoElmessage(true, "添加成功");
          this.Getlist();
          this.Close();
        }else{
           shoElmessage(true, `添加失败，原因：${res.msg}`, "error");
        }
          } else {
            console.log("error submit!!");
          }
        });
       
      });
    },
     // 编辑物料
     materialUpdate_table() {
      materialUpdate({
        material_id:this.editList.id,
        ...this.editList,
      }).then((res) => {
       if (res.code == 1) {
          shoElmessage(true, "修改成功");
          this.Getlist();
          this.Close();
        }else{
           shoElmessage(true, `修改失败，原因：${res.msg}`, "error");
        }
      });
    },
     deleteMaterial(index, lis) {
       materialDelete({
        material_ids:lis
      }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "删除成功");
          this.Getlist();
        } else {
          shoElmessage("el-icon-warning", "删除失败", "error");
        }
      });
    },
  },
};
</script>
<style lang="scss" scoped>
.productInfo_header {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .product_info--list {
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
  background-color: #fff;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  // 分页
  .pagination {
    padding: 15px 0px;
  }
}
.table_list {
  width: 100%;
  padding: 10px;
  background-color: $navBg;
  border-radius: 4px;
}
.el_button--list {
  margin: 5px;
}

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
.dialog_member {
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