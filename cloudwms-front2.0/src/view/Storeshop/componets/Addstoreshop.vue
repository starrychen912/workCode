<template>
  <!-- <el-container>
      <el-header :class="{'el_header--bg':mode === 'mobile' }">
          <sidebar :LogoName="title">
                <template #Seacrch></template>
          </sidebar>
      </el-header>
      <el-main class="flex"> -->
  <el-dialog
    v-model="dialog_visible"
    destroy-on-close
    width="80%"
    top="20px"
    :fullscreen="isFullscreen"
    :show-close="false"
    :lock-scroll="false"
    custom-class="dialog_productlist"
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
          <i class="el-icon-close" @click="CloseDialog('dialog_visible')"></i>
        </div>
      </div>
    </template>

    <div class="add_storeshop-list">
      <div class="el_from--card">
        <el-form ref="forma" :model="form" :rules="rules" label-width="100px">
          <el-form-item label="店铺名称" prop="name">
            <el-input v-model="form.name" @input="foreceUpdate"></el-input>
          </el-form-item>
          <el-form-item label="店铺域名" prop="domain">
            <el-input v-model="form.domain"></el-input>
          </el-form-item>
          <el-form-item label="联系方式">
            <el-input v-model="form.phone"></el-input>
          </el-form-item>
          <el-form-item label="店铺邮箱">
            <el-input v-model="form.email"></el-input>
          </el-form-item>
          <el-form-item label="店铺地址">
            <el-input v-model="form.address"></el-input>
          </el-form-item>
          <el-form-item label="店铺货币">
            <el-input v-model="form.currency"></el-input>
          </el-form-item>
          <!-- <el-form-item label="店铺所属人">
              <el-input v-model="form.shop_owner"></el-input>
            </el-form-item> -->
          <el-form-item label="店铺类型">
              <el-select v-model="form.type">
                <el-option label="Amazon" value="Amazon"></el-option>
                <el-option label="shopify" value="shopify"></el-option>
              </el-select>
            </el-form-item>
          <!-- <el-form-item label="店铺区域">
              <el-select v-model="form.region" placeholder="请选择店铺区域">
                <el-option label="区域一" value="shanghai"></el-option>
                <el-option label="区域二" value="beijing"></el-option>
              </el-select>
            </el-form-item> -->
          <!-- <el-form-item label="是否上线">
              <el-switch v-model="form.delivery"></el-switch>
            </el-form-item> -->
          <!-- <el-form-item label="店铺介绍">
              <el-input v-model="form.desc" type="textarea"></el-input>
            </el-form-item> -->
          <el-form-item>
            <div class="flex cancel-create-btn">
              <loding-btn @click="resetForm('form')" :btnsize="''"
                >重置</loding-btn
              >
              <loding-btn
                type="primary"
                :btnsize="''"
                @LoadBTN="Create('forma')"
                >确定</loding-btn
              >
            </div>
          </el-form-item>
        </el-form>
      </div>
    </div>

    <!-- </el-main>
      </el-container> -->
  </el-dialog>
</template>

<script>
import { reactive, toRefs, computed } from "vue";
import Sidebar from "../../../components/Loyout/Sidebar/Sidebar.vue";
import router from "../../../router";
import ButtonR from "../../../components/Bottom/buttonR.vue";
import LodingBtn from "../../../components/lodingBtn/index.vue";
import { AddShop, updateShop, getShopInfo } from "../../../api/shoplist";
import { shoElmessage } from "../../../utils/Elmessage";
// import { useRoute } from 'vue-router';
import { useStore } from "vuex";
import { isNaLL } from "../../../utils/utils";
export default {
  components: { Sidebar, ButtonR, LodingBtn },
  props: {
    dialog_visible: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      id: "",
      title: "新增店铺",
      form: {
        name: "",
        domain: "",
        phone: "",
        email: "",
        address: "",
        currency: "",
        type:'',
      },
      rules: {
        name: [{ required: true, message: "请输入店铺名称", trigger: "blur" }],
      },
      // 全屏
      isFullscreen: false,
    };
  },
  setup() {
    const store = useStore();
    const data = reactive({
      mode: computed(() => store.state.setting.device.mode),
    });
    return {
      ...toRefs(data),
    };
  },
  mounted() {
    // if (isNaLL(this.$route.query)) {
    //   if (Object.keys(this.$route.query).length) {
    //     this.title = "修改店铺";
    //     this.form = {
    //       shop_id: this.$route.query.id,
    //       name: this.$route.query.name,
    //       address1: this.$route.query.address1,
    //       myshopify_domain: this.$route.query.myshopify_domain,
    //       apiKey: this.$route.query.apiKey,
    //       apiSecretKey: this.$route.query.apiSecretKey,
    //       type: this.$route.query.type,
    //     };
    //     console.log(this.form, " this.form");
    //   } else {
    //     this.title = "新增店铺";
    //   }
    // }
  },
  methods: {
    Init(obj) {
      this.form = {
        name: "",
        domain: "",
        phone: "",
        email: "",
        address: "",
        currency: "",
        type:'',
      };
      console.log(obj);
      if (obj.title == "新增店铺") {
        console.log("新增店铺");
        this.title = "新增店铺";
      } else {
        this.title = "修改店铺";
        this.id = obj.id;
        getShopInfo({
          shop_id: obj.id,
        }).then((res) => {
          console.log(res,'res');
          if (res.code == 1) {
            this.form = res.data;
          }
        });
      }
    },
    Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    foreceUpdate() {
      
      this.$forceUpdate();
    },
    Create(formName) {

       this.$refs[formName].validate((valid) => {
      if (valid && this.title == "新增店铺") {
        AddShop({
          company_id: this.$store.state.userinfo.userinfo.company_id,
          ...this.form,
        })
          .then((result) => {
            if (result.code == 1) {
              shoElmessage(true, "新增店铺成功");
              this.CloseDialog("dialog_visible");
            } else {
              shoElmessage(true, "新增店铺失败", "error");
            }
          })
          .catch((err) => {});
      } else {
        updateShop({
          shop_id: this.id,
          ...this.form,
        }).then((res) => {
          if (res.code == 1) {
            shoElmessage(true, "修改店铺成功");
            this.CloseDialog("dialog_visible");
          } else {
            shoElmessage(true, `修改店铺失败,原因：${res.msg}`, "error");
          }
        });
      }
    })},
    CloseDialog(item) {
      this.$emit("CloseDialog", {
        item: item,
        dialog_visible: this.dialog_visible,
      });
      this.$refs["forma"].resetFields();
      this.isFullscreen = false;
      this.title = "";
    },
    resetForm() {
      this.$refs["forma"].resetFields();
    },
  },
};
</script>

<style scoped lang="scss">
.el-header {
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
  padding: 0px;
}
.container-fainal {
  margin: 0 auto;
  width: 100%;
}

.add_storeshop-list {
  margin-top: 10px;
}
.cancel-create-btn {
  justify-content: flex-end;
  .lodingBtn {
    margin-left: 10px;
  }
}
p {
  font-size: 12px;
  margin: 0px;
}
a {
  text-decoration: none;
  // font-size: 10px;
  color: #007185;
}
//弹出框标题
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
.dialog_productlist {
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
.el-textarea__inner {
  height: 100%;
}
</style>