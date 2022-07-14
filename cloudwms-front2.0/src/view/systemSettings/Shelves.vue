<template>
  <!-- <el-container>
      <el-header>
          <sidebar></sidebar>
      </el-header>
      <el-main> -->
  <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">仓库选择：</div>
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
    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input placeholder="请输入商品名称" style="flex: 1"></el-input>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <!-- 中间新增 -->
  <div class="product_integration--btn--list flex">
    <el-button type="primary" @click="dialogVisible = true" icon="el-icon-plus"
      >新增货架</el-button
    >
    <el-dropdown trigger="click" class="product_integration_dropdown">
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
  <div class="table--list flex flex-wrap">
    <div class="tabs_list flex align-center">
      <div
        class="tabs_list--1"
        :class="{ tabs_active: tabs_status == 1 }"
        @click="Tabas(1)"
      >
        货架排号
      </div>
      <div
        class="tabs_list--2"
        :class="{ tabs_active: tabs_status == 2 }"
        @click="Tabas(2)"
      >
        货架区域
      </div>
    </div>
    <div class="table_list">
      <el-table
        ref="multipleTable"
        :data="tableData"
        tooltip-effect="dark"
        style="width: 100%"
        @selection-change="handleSelectionChange"
      >
        <el-table-column type="selection" width="55"> </el-table-column>
        <el-table-column label="编号" width="100">
          <template #default="scope">{{ scope.row.id }}</template>
        </el-table-column>
        <el-table-column prop="name" label="货架排号"> </el-table-column>
        <el-table-column prop="address" label="货架区域"> </el-table-column>
        <el-table-column prop="address" label="仓库地址"> </el-table-column>
        <el-table-column prop="address" label="创建人"> </el-table-column>

        <el-table-column prop="content" label="备注"> </el-table-column>
        <el-table-column
          label="操作"
          fixed="right"
          width="300px"
          align="center"
        >
          <template #default="scope">
            <div class="flex flex-wrap">
              <div class="el_button--list">
                <el-link
                  @click="handleClick(scope.row, scope.$index)"
                  type="primary"
                  size="small"
                  disabled
                  >等待审核</el-link
                >
              </div>
              <el-divider direction="vertical"></el-divider>
              <div class="el_button--list">
                <el-link
                  @click="handleClick(scope.row, scope.$index)"
                  type="primary"
                  size="small"
                  >通过</el-link
                >
              </div>
              <el-divider direction="vertical"></el-divider>
              <div class="el_button--list">
                <el-link
                  @click="handleClick(scope.row, scope.$index)"
                  type="primary"
                  size="small"
                  >编辑</el-link
                >
              </div>
              <el-divider direction="vertical"></el-divider>
              <div class="el_button--list">
                <el-link type="primary" size="small">删除</el-link>
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
        :total="400"
      >
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
    <el-form ref="form" :model="ruleForm" :rules="rules">
      <el-form-item label="货架排号：" label-width="18%" prop="name">
        <el-input style="max-width: 700px" v-model="ruleForm.name"></el-input>
      </el-form-item>
      <el-form-item label="货架区域：" label-width="18%" prop="country">
        <el-select
          v-model="ruleForm.country"
          multiple
          filterable
          allow-create
          default-first-option
          placeholder="请选择盘点类型"
        >
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="仓库地址：" label-width="18%" prop="name">
        <el-input style="max-width: 700px" v-model="ruleForm.name"></el-input>
      </el-form-item>
      <el-form-item label="创建人：" label-width="18%" prop="name">
        <el-select
          v-model="ruleForm.country"
          multiple
          filterable
          allow-create
          default-first-option
          placeholder="请选择盘点类型"
        >
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          >
          </el-option>
        </el-select>
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
import { reactive, toRefs } from "vue";
export default {
  components: { Sidebar , OrderlistwangEditor },
  setup(porps, content) {
    const data = reactive({
      tableData: [
        {
          id: 1,
          name: "大山创库",
          address: "中山",
          status: 1,
          content: "很大的创库,不信你来瞅瞅。",
        },
      ],
      title: "创建盘点",
      dialogVisible: false,
      ruleForm: {
        name: "",
        id: 12346578,
        address: "",
        status: null,
        content: "",
      },
      tabs_status: 1,
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
      console.log(item, index);
    }
    function Tabas(index) {
      data.tabs_status = index;
    }
    return {
      ...toRefs(data),
      onSubmit,
      Cancal,
      Delete,
      handleClick,
      Success,
      Tabas,
    };
  },
};
</script>
<style lang="scss" scoped>
// 头部
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
// 中间新增
.product_integration--btn--list {
  margin: 15px 0px;
  :deep(.product_integration_dropdown) {
    margin-left: 10px;
  }
}
.el-header {
  background-color: $navBg;
  height: auto;
  // box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
  color: #000;
}
.tabs_list {
  padding: 0px;
  width: 100%;
  // margin-bottom: 15px;

  .tabs_list--1 {
    cursor: pointer;
    padding: 10px 20px 20px 20px;
    position: relative;
    &.tabs_active {
      &::before {
        content: "";
        width: 30px;
        position: absolute;
        height: 4px;
        left: calc(50% - 15px);
        background-color: #0d84ff;
        bottom: 10px;
        border-radius: 10px;
        transition: all 0.5s;
      }
    }
  }
  .tabs_list--2 {
    cursor: pointer;
    padding: 10px 20px 20px 20px;
    position: relative;
    &.tabs_active {
      &::before {
        content: "";
        width: 30px;
        position: absolute;
        height: 4px;
        left: calc(50% - 15px);
        background-color: #0d84ff;
        bottom: 10px;
        border-radius: 10px;
        transition: all 0.5s;
      }
    }
  }
}
.search--condition_header {
  background-color: $navBg;
  padding: 10px;
  margin: 10px 0px;
  border-radius: 4px;
  box-shadow: 0 0px 20px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
  span {
    padding: 0px 5px;
  }
}
.search--condition_list {
  padding: 10px 5px;
}
.table--list {
  background-color: $navBg;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
  .pagination-list {
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
</style>
<style lang="scss">
.sales_dialog {
  .el-dialog__header {
    border-bottom: 1px solid #d6d6d6;
  }
}
</style>