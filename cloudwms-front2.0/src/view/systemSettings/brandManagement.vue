<template>
  <div class="brandMan_header">
    <!-- <div class="brandMan_list flex align-center">
      <div class="label">品牌：</div>
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
    </div> -->
    <!-- <div class="brandMan_list flex align-center">
      <div class="label">厂家：</div>
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
    </div> -->
    <div class="brandMan_list flex align-center">
      <div class="label">名称：</div>
      <el-input placeholder="请输入商品名称"></el-input>
    </div>
    <!-- <div class="brandMan_list flex align-center">
      <div class="label">市场：</div>
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
    </div> -->
    <!-- <div class="brandMan_list flex align-center">
      <el-dropdown trigger="click">
        <el-button>
          更多操作<i class="el-icon-arrow-down el-icon--right"></i>
        </el-button>
        <template #dropdown>
          <el-dropdown-menu>
            <el-dropdown-item>
              <router-link to="#">店铺管理</router-link>
            </el-dropdown-item>
            <el-dropdown-item>
              <router-link to="#">货币管理</router-link>
            </el-dropdown-item>
            <el-dropdown-item>
              <router-link to="#">国家管理</router-link>
            </el-dropdown-item>
            <el-dropdown-item>
              <router-link to="#">市场管理</router-link>
            </el-dropdown-item>
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </div> -->
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <div class="brandMan--btn--list flex">
    <el-button type="primary" class="el-icon-plus" @click="editVisible()"
      >新增</el-button
    >
    <el-dropdown trigger="click" class="brandMan_dropdown" @command="Command">
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
  <div class="table_backCol">
    <!-- 表格 -->
    <div class="itemList">
      <!-- 列表 -->
      <el-table
        :data="lis"
        style="width: 100%"
        :border="true"
        @select-all="SelectAll"
        @select="Select"
      >
        <el-table-column type="selection" width="55"> </el-table-column>
        <el-table-column prop="id" label="编号" width="100" align="center" />
        <el-table-column
          prop="name"
          label="品牌"
          align="center"
          v-model="rules.name"
        >
          <template #default="scope">
            <el-link :href="scope.row.url">{{ scope.row.name }}</el-link>
          </template>
        </el-table-column>
        <el-table-column
          prop="eng_name"
          label="英文名称"
          align="center"
          v-model="rules.eng_name"
        >
          <template #default="scope">
            {{ scope.row.eng_name }}
          </template>
        </el-table-column>
        <el-table-column label="logo" prop="logo" align="center">
          <template #default="scope">
            <el-image style="width: 80px; height: 80px" :src="scope.row.logo">
            </el-image>
          </template>
        </el-table-column>
        <el-table-column prop="create_time" label="创建时间" align="center">
          <template #default="scope">
            {{ getLocalTime(scope.row.create_time) }}
          </template>
        </el-table-column>
        <el-table-column prop="orders" label="订单数" align="center">
          <template #default="scope">
            <el-tag type="warning">{{ scope.row.orders }}</el-tag>
          </template>
        </el-table-column>
        <el-table-column prop="introduction" label="介绍" align="center" />

        <!-- 按钮列 -->
        <el-table-column
          label="操作"
          prop="operate"
          size="small"
          width="150px"
          align="center"
        >
          <template #default="scope">
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
                @click="deleteBrand(scope.$index, scope.row.id)"
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
        :page-sizes="[10, 20, 30, 40]"
      >
      </el-pagination>
    </div>
  </div>
  <!-- 编辑品牌信息 -->
  <el-dialog
    :title="title"
    v-model="editVisi"
    width="50%"
    top="20px"
    :before-close="handleClose"
    :show-close="false"
    :fullscreen="isFullscreen"
    custom-class="dialog_brand"
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
      <el-form-item label="品牌名称：" label-width="18%" prop="name">
        <el-input style="max-width: 700px" v-model="editList.name"></el-input>
      </el-form-item>
      <el-form-item label="品牌链接：" label-width="18%" prop="url">
        <el-input style="max-width: 700px" v-model="editList.url"></el-input>
      </el-form-item>
      <el-form-item label="英文名称：" label-width="18%" prop="eng_name">
        <el-input
          style="max-width: 700px"
          v-model="editList.eng_name"
        ></el-input>
      </el-form-item>
      <!-- <el-form-item label="订单数：" label-width="18%" prop="orders">
        <el-input style="max-width: 700px" v-model="editList.orders"></el-input>
      </el-form-item> -->
      <el-form-item label="品牌logo：" label-width="18%" prop="baseUrl">
        <el-upload
          class="avatar-uploader"
          :headers="headers"
          :action="baseUrl + '/api/common/upload'"
          :on-remove="onRemove"
          :on-success="OnSuccess"
          :on-error="UploadError"
          :on-change="UploadChange"
          :before-upload="BeforeUpload"
          :accept="file_type"
          list-type="picture-card"
          :file-list="filelist"
          :class="{ hide: hideUploadEdit }"
        >
          <img v-if="imageUrl" :src="baseUrl" class="avatar" />
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="介绍：" label-width="18%" prop="introduction">
        <orderlistwang-editor
                :editor="editList.introduction"
                @Change="editorChange"
                @Onfocus="Onfocus"
                @Onblur="Onblur"
              ></orderlistwang-editor>
      </el-form-item>
    </el-form>
    <template #footer class="el-dialog-footer">
      <el-button @click="editVisi = false">取消</el-button>
      <el-button
        type="primary"
        @click="
          btn_brand == '立即创建'
            ? brandAdd_table('editList')
            : brandUpdate_table('editList')
        "
        >{{ btn_brand }}</el-button
      >
    </template>
  </el-dialog>
</template>

<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import OrderlistwangEditor from "../Shopfly/Orderlist/OrderlistwangEditor.vue";
import {
  GetBrandlist,
  brandAdd,
  brandDelete,
  brandUpdate,
} from "../../api/brandManagement";
import { isNaLL, getLocalTime } from "../../utils/utils";
import { shoElmessage } from "@/utils/Elmessage";
import { getAccessToken } from "@/utils/AccessToken";
import { netConfig } from "@/config/net.config";
import { shoElMessageBox } from "../../utils/Elmessage";
export default {
  components: {
    Sidebar,
    OrderlistwangEditor
  },
  data() {
    return {
      //批量删除文件
      Delete_list: [],
      hideUploadEdit: false, // 是否隐藏上传按钮
      editVisi: false,
      data: {
        cur: "",
        size: "",
        total: "",
      },
      title: "",
      isFullscreen: false,
      // 规则
      rules: {
        name: [{ required: true, message: "必填项", trigger: "blur" }],
        eng_name: [
          {
            required: true,
            message: "必填项",
            trigger: "blur",
          },
          { pattern: /^[A-Za-z]+$/, message: "必须是英文", trigger: "blur" },
          {min:1, max: 4, message: "最多输入四个字符", trigger: "blur" },
        ],
      },
      //上传图片
      baseUrl: netConfig.baseURL,
      // 上传文件额外参数
      headers: {
        token: getAccessToken(),
      },
      flie_list: {},
      file_type: ".png,.jpg,.jpeg,.gif,.svg,.GIF,.JPEG,.PNG,.JPG,.SVG",
      filelist: [],
      btn_brand: "",
      editList: {},
    };
  },
  mounted() {
    this.Getlist();
  },
  methods: {
    Getlist() {
      GetBrandlist({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        page_num: this.data.cur,
        per_page_num: this.data.size,
      }).then((res) => {
        if (res.code == 1) {
          this.lis = res.data.data;
          this.data = res.data;
        }
      });
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
        if (this.Delete_list.length != 0) {
          let item = [];
          this.Delete_list.forEach((el) => {
            item.push(el.id);
          });
          this.deleteBrand("批量删除", item.join());
        } else {
          shoElmessage("el-icon-warning", "请选择删除列表", "error");
        }
      }
    },
    //删除图片响应
    onRemove(removeitem) {
      this.hideUploadEdit = false;
    },
    //图片上传成功
    OnSuccess(res) {
      if (res.code == 1) {
        this.flie_list = res.data;
        this.hideUploadEdit = true;
      }
    },
    //图片上传图片回调
    UploadChange(res) {
      if (res.response != undefined) {
        if (res.response.code == 0) {
          shoElmessage("el-icon-warning", res.response.msg, "error");
        } else {
          shoElmessage("success", "上传成功", "success");
        }
      }
    },
    //上传图片拦截
    BeforeUpload(file) {
      console.log(file);
      const fileSuffix = file.name.substring(file.name.lastIndexOf(".") + 1);
      const filelist = this.file_type.split(",");
      if (filelist.indexOf(`.${fileSuffix}`) == -1) {
        shoElmessage("el-icon-warning", "请选择正常文件格式", "error");
        return false;
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
    // 修改品牌信息弹框
    editVisible(item) {
      this.hideUploadEdit = false;
      this.flie_list = {};
      this.editList = {};
      this.title = "新增";
      this.btn_brand = "立即创建";
      if (isNaLL(item)) {
        if (item.logo != "") {
          this.hideUploadEdit = true;
        }
        this.editList = item;
        this.title = "修改品牌";
        this.btn_brand = "立即修改";
        this.filelist.push({
          url: this.editList.logo,
          fullurl: this.editList.logo,
        });
      }
      this.editVisi = true;
    },
    // 新增品牌
    brandAdd_table(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          brandAdd({
            company_id: this.$store.state.userinfo.userinfo.company_id,
            name: this.editList.name,
            logo: this.flie_list.url,
            introduction: this.editList.introduction,
            url: this.editList.url,
            eng_name: this.editList.eng_name,
          }).then((res) => {
            if (res.code == 1) {
              shoElmessage(true, "添加成功");
              this.Getlist();
              this.Close();
            } else {
              shoElmessage(true, `添加失败，原因：${res.msg}`, "error");
            }
          });
        } else {
          shoElmessage(true, `请输入完整信息`, "error");
        }
      });
    },
    // 修改品牌接口
    brandUpdate_table(formName) {
       this.$refs[formName].validate((valid) => {
        if (valid) {
          brandUpdate({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        brand_id: this.editList.id,
        name: this.editList.name,
        logo: this.flie_list.url,
        introduction: this.editList.introduction,
        url: this.editList.url,
        eng_name: this.editList.eng_name,
          }).then((res) => {
            if (res.code == 1) {
              shoElmessage(true, "修改成功");
              this.Getlist();
              this.Close();
            } else {
              shoElmessage(true, `修改失败，原因：${res.msg}`, "error");
            }
          });
        } else {
          shoElmessage(true, `请输入完整信息`, "error");
        }
      });
    },

    // 删除品牌
    deleteBrand(index, lis) {
      shoElMessageBox("确定当前这个品牌，或删除这几条品牌？", "删除提示").then(
        (res) => {
          brandDelete({
            brand_id: lis,
          }).then((res) => {
            if (res.code == 1) {
              shoElmessage(true, "删除成功");
              this.Getlist();
            } else {
              shoElmessage("el-icon-warning", "删除失败", "error");
            }
          });
        }
      );
    },
    Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    Close() {
      this.editVisi = !this.editVisi;
      this.isFullscreen = false;
      this.filelist = [];
      this.$refs["editList"].resetFields();
    },
  },
  setup() {
    return {
      getLocalTime,
    };
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
// 图片隐藏
.hide .el-upload--picture-card {
  display: none;
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
.brandMan--btn--list {
  margin: 15px 0px;
  :deep(.brandMan_dropdown) {
    margin-left: 10px;
  }
}
// 商品列表
.table_backCol {
  background-color: #fff;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.03);
  padding: 20px;
  .itemList {
    padding: 12px 0;
    .title {
      margin: 12px 0;
    }
    .demo-table-expand label {
      width: 90px;
      color: #99a9bf;
    }
    .demo-table-expand .el-form-item {
      // margin-left: 100px;
      margin-bottom: 0px;
      margin-right: 0px;
      padding: 0 80px;
      width: 50%;
    }
    .el-table {
      .el-button {
        // margin-top: 3px;
        padding: 8px;
        margin: 3px;
      }
    }
  }
}
// 编辑品牌弹框
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