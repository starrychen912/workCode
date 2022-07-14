<template>
  <div class="brandMan_header">
    <div class="brandMan_list flex align-center">
      <div class="label">城市：</div>
      <el-select v-model="value1" placeholder="请选择">
        <el-option
          v-for="item in options1"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        >
        </el-option>
      </el-select>
    </div>
    <div class="brandMan_list flex align-center">
      <div class="label">部门：</div>
     <el-select v-model="department_id" placeholder="请选择">
        <el-option
          v-for="item in partList"
          :key="item.id"
          :label="item.name"
          :value="item.id"
        >
        </el-option>
      </el-select>
    </div>

    <div class="brandMan_list flex align-center">
      <div class="label">关键字：</div>
      <el-input placeholder="" style="flex: 1" v-model="username"></el-input>
    </div>
    <!-- 中间商品搜索栏 -->
    <div class="brandMan_list">
      <el-button type="primary" @click="Getlist">查询</el-button>
      <el-button>重置</el-button>
    </div>
  </div>
  <div class="product_integration--btn--list flex">
    <div class="logistics_header flex">
      <el-button
        type="primary"
        @click="editVisible()"
        >新增同事</el-button
      >
    </div>

    <el-dropdown trigger="click" class="product_integration_dropdown" @command="Command">
      <el-button>
        更多操作<i class="el-icon-arrow-down el-icon--right"></i>
      </el-button>
      <template #dropdown>
        <el-dropdown-menu >
          <el-dropdown-item command="a"> 批量删除 </el-dropdown-item>
        </el-dropdown-menu>
      </template>
    </el-dropdown>
  </div>
  <div class="content flex flex-wrap">
    <el-table
       :data="lis"
        style="width: 100%"
        :border="true"
        @select-all="SelectAll"
        @select="Select"
    >
      <el-table-column
        type="selection"
        width="55"
        align="center"
      ></el-table-column>

      <el-table-column prop="avatar" label="头像"  align="center">
        <template #default="scope"
          >
           <el-image
              style="width: 80px; height: 80px"
              :src="scope.row.avatar"
            >
            </el-image>
          <!-- <div class="imgInfo"><img :src="scope.row.avatar" /></div -->
        </template>
      </el-table-column>
      <el-table-column prop="username" label="姓名" width="100" align="center" />
    

      <!-- <el-table-column prop="shortName"  label="简称">
        <template #default="scope">{{ scope.row.shortName }}</template>
      </el-table-column> -->

      <el-table-column prop="sex"  label="邮箱">
        <template #default="scope">{{ scope.row.email }}</template>
      </el-table-column>

      <el-table-column prop="department_name"  label="职位">
        <template #default="scope">{{ scope.row.pos }}</template>
      </el-table-column>

      <el-table-column prop="status"  label="状态">
        <template #default="scope">{{ scope.row.status }}</template>
      </el-table-column>

      <el-table-column prop="tel" label="电话号码">
        <template #default="scope">{{ scope.row.phone }}</template>
      </el-table-column>

      <!-- <el-table-column prop="qq" label="QQ">
              <template #default="scope">{{ scope.row.qq }}</template>
            </el-table-column>
               -->

      <!-- <el-table-column prop="birthday" width="120" label="生日">
              <template #default="scope">{{ scope.row.birthday }}</template>
            </el-table-column> -->

      <!-- <el-table-column label="联系地址">
              <template #default="scope">{{ scope.row.address }}</template>
            </el-table-column> -->

      <!-- <el-table-column label="备注">
              <template #default="scope">{{ scope.row.tips }}</template>
            </el-table-column> -->

      <el-table-column label="操作" width="180" align="center">
        <template #default="scope">
          <el-button type="text" @click="editVisible(scope.row)"
            >编辑</el-button
          >
          <el-button
            type="text"
            class="red"
            @click="deleteMerber(scope.$index, scope.row.id)"
            >删除</el-button
          >
        </template>
      </el-table-column>
    </el-table>
    <div class="pagination-list">
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

  <!-- 新增用户 -->
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
    <el-form ref="editList" :model="editList" :rules="rules">
      <el-form-item label="用户名：" label-width="18%" prop="username">
        <el-input style="max-width: 700px" v-model="editList.username"></el-input>
      </el-form-item>
      <el-form-item label="密码：" label-width="18%" prop="Lpassword" >
        <el-input style="max-width: 700px" v-model="editList.Lpassword" :placeholder="btn_brand == '新增' ?'请输入密码':'不修改请留空'"></el-input>
      </el-form-item>
      <!-- <el-form-item label="创建时间" label-width="18%" prop="create_time">
        <el-date-picker
          v-model="editList.create_time"
          type="date"
          placeholder="选择日期"
        >
        </el-date-picker>
      </el-form-item> -->
      <el-form-item label="邮箱：" label-width="18%" prop="email">
        <el-input style="max-width: 700px" v-model="editList.email"></el-input>
      </el-form-item>
      <el-form-item label="电话号码：" label-width="18%" prop="phone">
        <el-input style="max-width: 700px" v-model="editList.phone"></el-input>
      </el-form-item>
      
      <el-form-item label="头像：" label-width="18%" prop="baseUrl">
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
      <el-form-item label="部门：" label-width="18%" prop="department_id">
         <el-select v-model="editList.department_id" placeholder="请选择">
        <el-option
      v-for="item in partList"
      :key="item.id"
      :label="item.name"
      :value="item.id">
    </el-option></el-select>
      </el-form-item>
      <el-form-item label="职位：" label-width="18%" prop="department_id">
         <el-select v-model="editList.role_id" placeholder="请选择">
        <el-option
      v-for="item in partList"
      :key="item.id"
      :label="item.name"
      :value="item.id">
    </el-option></el-select>
      </el-form-item>
    </el-form>
    <template #footer class="el-dialog-footer">
      <el-button @click="editVisi = false">取消</el-button>
      <el-button
        type="primary"
        @click="
          btn_brand == '新增'
            ? memberAdd_table('editList')
            : memberUpdate_table('editList')
        "
        >{{ btn_brand }}</el-button
      >
    </template>
  </el-dialog>
</template>

<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { getAccessToken } from "@/utils/AccessToken";
import { netConfig } from "@/config/net.config";
import { isNaLL } from "../../utils/utils";
import {GetdepartmentList} from '@/api/department.js'
import { shoElmessage } from "@/utils/Elmessage";


import {
  companyUserDelete,
  companyUserUpdate,
  companyUserAdd,
  companyUserDetail,
  companyUserList,
} from "../../api/memberCom";
export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      department_id:'',
      username:'',
      Delete_list:[],
      hideUploadEdit: false, // 是否隐藏上传按钮
      editVisi: false,
      title: "",
      isFullscreen: false,
      // 规则
      rules: {
        username: [{ required: true, message: "必填项", trigger: "blur" }],
        password: [{ required: true, message: "必填项", trigger: "blur" }],
        email: [{ required: true, message: "必填项", trigger: "blur" }],
        phone: [{ required: true, message: "必填项", trigger: "blur" }],
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
      
      input: "",
      value1: [],
      lis: [],
      options1: [
        {
          value: "选项1",
          label: "深圳",
        },
        {
          value: "选项2",
          label: "中山",
        },
        {
          value: "选项3",
          label: "北京",
        },
        {
          value: "选项4",
          label: "MV",
        },
      ],
      options2: [
        {
          value: "guanli",
          label: "管理",
        },
        {
          value: "jisu",
          label: "技术",
        },
        {
          value: "yanfa",
          label: "研发",
        },
        {
          value: "yunying",
          label: "运营",
          children: [
            {
              value: "one",
              label: "1部",
            },
            {
              value: "two",
              label: "2部",
            },
            {
              value: "three",
              label: "3部",
            },
          ],
        },
        {
          value: "chanpin",
          label: "产品",
          children: [
            {
              value: "one",
              label: "1部",
            },
            {
              value: "two",
              label: "2部",
            },
            {
              value: "three",
              label: "3部",
            },
          ],
        },
        {
          value: "yunying",
          label: "运营",
          children: [
            {
              value: "one",
              label: "1部",
            },
            {
              value: "two",
              label: "2部",
            },
            {
              value: "three",
              label: "3部",
            },
          ],
        },
        {
          value: "meiti",
          label: "媒体",
          children: [
            {
              value: "one",
              label: "1部",
            },
            {
              value: "two",
              label: "2部",
            },
          ],
        },
      ],
      tableChecked: [],
      querInfo: {
        type: 2,
        pagenum: 1,
        pagesize: 3,
      },
      partList:[]
    };
  },
  mounted() {
    this.Getlist();
    this.getDepartmentList()

  },
  methods: {

    Getlist() {
      companyUserList({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        department_id:this.department_id,
        username:this.username
      }).then((res) => {
        if (res.code == 1) {
          console.log(res.data);
          this.lis = res.data.data;
          this.querInfo.total = res.data.total;
          this.querInfo.pagenum = res.data.cur;
          this.querInfo.pagesize = res.data.size;
          
        }
      });
    },
    // 获取部门列表
    getDepartmentList(){
      GetdepartmentList({
          company_id: this.$store.state.userinfo.userinfo.company_id,
      }).then((res)=>{
        if(res.code == 1){
          this.partList = res.data.data
        }
      })
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
        this.deleteMerber('批量删除',item.join());
      }else{
        shoElmessage('el-icon-warning','请选择删除列表','error')
      }
      }
    },
    
    // 删除品牌
    deleteMerber(index, lis) {
      companyUserDelete({
        company_id: this.$store.state.userinfo.userinfo.company_id,
        company_user_id:lis
      }).then((res) => {
        if (res.code == 1) {
          shoElmessage(true, "删除成功");
          this.Getlist();
        } else {
          shoElmessage("el-icon-warning", "删除失败", "error");
        }
      });
    },

    // 监听pagesize改变
    handleSizeChange(newSize) {
      this.querInfo.pagesize = newSize;
      this.Getlist();
    },
    // 监听pagenum的改变
    handleCurrentChange(newPage) {
      this.querInfo.pagenum = newPage;
      this.Getlist();
    },
    editVisible(item) {
      this.getDepartmentList()
      this.hideUploadEdit = false
      this.flie_list = {}
      this.editList = {};
      this.title = "新增成员";
      this.btn_brand = "新增";
      if (isNaLL(item)) {
        if (item.logo != "") {
          this.hideUploadEdit = true;
        }
        this.editList = item;
        this.title = "编辑成员";
        this.btn_brand = "编辑";
        console.log(this.editList)
        this.filelist.push({
          url:this.editList.avatar,
          src:this.editList.avatar,
          fullurl:this.editList.avatar,
        });
        // console.log(this.filelist)
      }
      this.editVisi = true;
    },
    deleteItem(index, lis) {
      lis.splice(index, 1);
    },
     Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    Close() {
      this.editVisi = !this.editVisi;
      this.isFullscreen = false;
      this.filelist = [];
      this.$refs['editList'].resetFields()
    },
     onRemove(removeitem) {
      this.hideUploadEdit = false;
    },
    //图片上传成功
    OnSuccess(res) {
      console.log(res)
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
      const fileSuffix = file.name.substring(file.name.lastIndexOf(".") + 1);
      const filelist = this.file_type.split(",");
      if (filelist.indexOf(`.${fileSuffix}`) == -1) {
        shoElmessage("el-icon-warning", "请选择正常文件格式", "error");
        return false;
      }
    },
    // 新增用户
    memberAdd_table(formName) {
      companyUserAdd({
        company_id: this.$store.state.userinfo.userinfo.company_id,
          ...this.editList,
          avatar: this.flie_list.url,
          password:this.editList.Lpassword,
          role_id:'1'
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
        }else{
           shoElmessage(true, `添加失败，原因：${res.msg}`, "error");
        }
      });
    },
    // 编辑用户
     memberUpdate_table() {
      companyUserUpdate({
        // company_id: this.$store.state.userinfo.userinfo.company_id,
        company_user_id:this.editList.id,
        // ...this.editList,
        username:this.editList.username,
        password:this.editList.Lpassword,
        email:this.editList.email,
        phone:this.editList.phone,
        department_id:this.editList.department_id,
        // username:this.editList.username,
          avatar: this.flie_list.url,
          // role_id:'1'
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


  },
  created() {
    this.value1 = this.options1[0].value;
  },
  
};
</script>
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
// 图片隐藏
.hide .el-upload--picture-card {
  display: none;
}
</style>
 
<style scoped lang="scss">
.content {
  background-color: $navBg;
  background-color: #fff;
  border-radius: 2px;
  padding: 20px;
  margin-top: 20px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 0 3px 0 rgba(0, 0, 0, 0.02);
}
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
.el-header {
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
  padding: 0px;
  color: #000;
}
.banner {
  display: flex;
  justify-content: space-between;
  padding: 20px 0px;
  .left {
    width: 650px;
    display: flex;
    justify-content: space-between;
  }
}
.el-table {
  padding: 20px 0px;
  .imgInfo img {
    width: 80px;
  }
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