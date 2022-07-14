<template>
  <!-- 商品分类页面 -->
  <!-- <el-container>
    <el-header>
      <sidebar></sidebar>
    </el-header>
    <el-main> -->

  <div class="container">
    <p class="title">我的资料</p>
    <div class="flex">
      <!-- 左侧头像 -->
      <div class="demo-type">
        <el-avatar :size="80" src="https://empty" @error="errorHandler">
          <img src="https://cube.elemecdn.com/e/fd/0fc7d20532fdaf769a25683617711png.png"/>
        </el-avatar>
      </div>
      <div class="info-header">
        <div class="info-list flex align-center">
          <div class="label">用户名</div>
          <div>
            <el-input
            ref="useName"
            v-model="personalForm.username"
            v-show="useNamestauts"
            @blur="loseFcous('useNamestauts')"
            style="flex: 1"
          ></el-input>
          </div>
          <span style="margin-left: 10px" v-show="!useNamestauts">{{
            personalForm.username
          }}</span
          ><i
            class="el-icon-edit"
            style="color: #409eff; margin-left: 10px"
            @click="edit('useNamestauts','useName')"
            v-show="!useNamestauts"
          ></i>
        </div>
        <div class="info-list flex align-center">
          <div class="label">手机号码</div>
          <div>
            <el-input
            ref="phone"
            v-model="personalForm.phone"
            v-show="phoneStatus"
            @blur="loseFcous('phoneStatus')"
            style="flex: 1"
          ></el-input>
          </div>
          <span style="margin-left: 10px" v-show="!phoneStatus">{{
            personalForm.phone
          }}</span
          ><i
            class="el-icon-edit"
            style="color: #409eff; margin-left: 10px"
            @click="edit('phoneStatus','phone')"
            v-show="!phoneStatus"
          ></i>
        </div>
    
        <div class="info-list flex align-center">
          <div class="label">邮箱账号</div>
           <div>
            <el-input
            ref="emaileNum"
            v-model="personalForm.email"
            v-show="emaileStatus"
            @blur="loseFcous('emaileStatus')"
            style="flex: 1"
          ></el-input>
          </div>
          <span style="margin-left: 10px" v-show="!emaileStatus">{{
            personalForm.email
          }}</span
          ><i
            class="el-icon-edit"
            style="color: #409eff; margin-left: 10px"
            @click="edit('emaileStatus','emaileNum')"
            v-show="!emaileStatus"
          ></i>
        </div>
       
        <div class="info-list flex align-center">
          <div class="label">职位</div>
          <div>
            <el-input
            ref="position"
            v-model="personalForm.salt"
            v-show="positionStatus"
            @blur="loseFcous('positionStatus')"
            style="flex: 1"
          ></el-input>
          </div>
          <span style="margin-left: 10px" v-show="!positionStatus">{{
            personalForm.salt
          }}</span
          ><i
            class="el-icon-edit"
            style="color: #409eff; margin-left: 10px"
            @click="edit('positionStatus','position')"
            v-show="!positionStatus"
          ></i>
        </div>
        </div>
      </div>
      </div>
  <div class="container" style="margin-top: 20px">
    <el-collapse accordion class="collapse_content">
      <div  style="font-weight:bold ; border-bottom: 1px solid rgb(235, 231, 231);padding-bottom: 10px;">安全设置</div>
       <!-- <el-collapse-item >
         <template #title>
          <div style="font-weight:bold ;">安全设置</div>
          </template>
       </el-collapse-item> -->
        <el-collapse-item>
          <template #title>
            手机号码
            <span style="margin-left:10px;font-size: 12px;">修改手机号系统会发送验证码和新的手机号码上</span>
          </template>
            <div>
              <el-form ref="form" :model="personalForm" label-width="120px">
                  <el-form-item label="登录密码：">
                    <el-input v-model="personalForm.password"  style="max-width:500px" placeholder="请输入"></el-input>
                  </el-form-item>
                  <el-form-item label="验证码：">
                    <el-input v-model="personalForm.password"  style="max-width:370px" placeholder="请输入6位验证码"></el-input>
                    <el-button @click.prevent="removeDomain(domain)" style="margin-left: 20px;">获取验证码</el-button>
                  </el-form-item>
                  <el-form-item label="新手机号码：">
                    <el-input v-model="personalForm.password"  style="max-width:500px" placeholder="请输入"></el-input>
                  </el-form-item>
                  <el-form-item label="验证码：">
                    <el-input v-model="personalForm.password"  style="max-width:370px" placeholder="请输入6位验证码"></el-input>
                    <el-button @click.prevent="removeDomain(domain)" style="margin-left: 20px;">获取验证码</el-button>
                  </el-form-item>
                  <el-form-item>
                    <el-button type="primary" @click="submitForm('dynamicValidateForm')">保存</el-button>
                  </el-form-item>
                </el-form>
            </div>
        </el-collapse-item>
      <el-collapse-item>
        <template #title>
          登录密码
          <span style="margin-left:10px;font-size: 12px;">安全性高的密码可以使账号更安全，建议您定期更换，设置一个包含字母，符号或数字中至少两项，且长度在8-20位的密码</span>
        </template>
        <div>
          <el-form ref="form" :model="personalForm" label-width="120px">
              <el-form-item label="旧密码：">
                <el-input v-model="personalForm.password"  style="max-width:500px" placeholder="请输入"></el-input>
              </el-form-item>
              <el-form-item label="新密码：">
                <el-input v-model="personalForm.password"  style="max-width:370px" placeholder="请输入"></el-input>
                <el-button @click.prevent="removeDomain(domain)" style="margin-left: 20px;">获取验证码</el-button>
              </el-form-item>
              <el-form-item label="确认新密码：">
                <el-input v-model="personalForm.password"  style="max-width:500px" placeholder="请重复密码"></el-input>
              </el-form-item>
              <el-form-item label="验证码：">
                <el-input v-model="personalForm.password"  style="max-width:370px" placeholder="请输入6位验证码"></el-input>
                <el-button @click.prevent="removeDomain(domain)" style="margin-left: 20px;">获取验证码</el-button>
              </el-form-item>
              <el-form-item>
                <el-button type="primary" @click="submitForm('dynamicValidateForm')">保存</el-button>
              </el-form-item>
              </el-form>
          </div>
      </el-collapse-item>
      <el-collapse-item>
        <template #title>
          邮箱账号
          <span style="margin-left:10px;font-size: 12px;">修改邮箱号系统会发送验证链接到新的邮箱账号上</span>
        </template>
        <div>
          <el-form ref="form" :model="personalForm" label-width="120px">
            <el-form-item label="密码：">
              <el-input v-model="personalForm.password"  style="max-width:500px" placeholder="请输入"></el-input>
            </el-form-item>
            <el-form-item label="新邮箱地址：">
              <el-input v-model="personalForm.password"  style="max-width:500px" placeholder="请输入"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="submitForm('dynamicValidateForm')">保存</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-collapse-item>
    </el-collapse>
  </div>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { computed ,toRefs} from "vue";
import { useStore } from "vuex";
export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      useNamestauts: false,
      phoneStatus: false,
      emaileStatus: false,
      positionStatus: false,
      input: "123",
      imageUrl: "",
      url: "https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
      isCollapse: false,
      passwordShow: true,
      buttonName: "发送短信",
      isDisabled: false,
      time: 60,
      personalForm: {
        gender: "",
        name: "",
        shortNa: "",
        idCard: "",
        account: "",
        emailAccount: "",
        phone_num: "",
        depart: "",
        position: "",
        bankName: "",
        branchAccount: "",
        password1: "",
        password2: "",
        phone: "0003330",
        salt: "总裁",
        email: "33@",
        username: "333333",
        password:'',
      },
    };
  },
  methods: {
    errorHandler() {
      return true;
    },
    handleAvatarSuccess(res, file) {
      this.imageUrl = URL.createObjectURL(file.raw);
    },
    beforeAvatarUpload(file) {
      const isJPG = file.type === "image/jpeg";
      const isLt2M = file.size / 1024 / 1024 < 2;

      if (!isJPG) {
        this.$message.error("上传头像图片只能是 JPG 格式!");
      }
      if (!isLt2M) {
        this.$message.error("上传头像图片大小不能超过 2MB!");
      }
      return isJPG && isLt2M;
    },
    handleOpen(key, keyPath) {
      console.log(key, keyPath);
      console.log(key);
      console.log(keyPath);
    },
    handleClose(key, keyPath) {
      // console.log(key, keyPath);
    },
    loseFcous(item) {
       this.$data[item] = !this.$data[item];
    },
    edit(item, useName) {
      this.$data[item] = !this.$data[item];
      this.$refs[useName].focus();
    },
    sendMsg() {
      //时间按钮
      let me = this;
      me.isDisabled = true;
      let interval = window.setInterval(function () {
        me.buttonName = "(" + me.time + ")秒";
        --me.time;
        if (me.time < 0) {
          me.buttonName = "重新发送";
          me.time = 60;
          me.isDisabled = false;
          window.clearInterval(interval);
        }
      }, 1000);
    },
    submit() {
      //提交
      if (this.personalForm.account === "") {
        this.$message.warning("账号不能为空");
      } else if (this.personalForm.phone_num === "") {
        this.$message.warning("手机号不能为空");
      } else if (this.personalForm.password1 === "") {
        this.$message.warning("密码不能为空");
      } else if (this.personalForm.password2 === "") {
        this.$message.warning("密码不能为空");
      } else {
        this.$message.success("修改成功");
      }
    },
  },
};
</script>
<style lang="scss">
.collapse_content{
  min-height: 500px;
}
.el-descriptions {
  padding: 20px;
  flex: 1;
}
.el-collapse {
  padding: 20px;
}
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.el-form-item {
  margin: 10px;
}
</style>
<style scoped lang="scss">
.info-header {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  width: 100%;
  background-color: #fff;
  font-size: 14px;
  padding: 20px 10px;
  .info-list {
    margin: 5px 10px;
    width: 30%; 
    height: 44px;
    cursor: pointer;
    .label {
      width: 70px;
      text-align: right;
      margin-right: 30px;
    }
  }
}
.container .title {
  padding: 20px;
  color: rgb(0, 0, 0);
  font-weight: bold;
  border-bottom: 1px solid rgb(235, 231, 231);
}
.demo-type {
  width: 120px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}
p {
  font-size: 14px;
  margin: 0px;
}
a {
  text-decoration: none;
  // font-size: 10px;
  color: #007185;
}

//顶部banner
// 文字链接
.el-header {
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
  padding: 0px;
  color: #000;
}

.container {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
  background-color: white;
  .title {
    // margin:10px;
    padding: 20px;
  }
  .inner {
    display: flex;
    justify-content: start;
    padding: 20px;
    .el-form {
      width: 70%;
      .el-row {
        // align-content: center;
        align-items: center;
        // justify-items: center;
      }
    }
  }
}
.avatar-uploader {
  width: 20%;
  display: flex;
  justify-content: flex-end;
  height: 178px;
  // align-items: center;

  //     .el-upload {
  //   border: 1px dashed #a3a1a1;
  //   border-radius: 6px;
  //   cursor: pointer;
  // //   position: relative;
  //   overflow: hidden;
  //   border-radius: 50%;
  //   margin:0 auto;

  //   .el-icon-plus{  
  //   }
  // }
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}
.avatar {
  width: 100%;
  height: 178px;
  display: block;
}
// 分页
</style>