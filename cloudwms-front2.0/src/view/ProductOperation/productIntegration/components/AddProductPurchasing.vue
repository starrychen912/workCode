
<template>
  <!-- 弹框 -->
  <el-dialog
    v-model="dialog_visible"
    destroy-on-close
    width="80%"
    top="20px"
    :title="title"
    :fullscreen="isFullscreen"
    :show-close="false"
    custom-class="dialog_productlist"
    :lock-scroll="false"
  >
    <template #title>
      <div class="el-dialog_title">
        <div class="title">{{purchasing_title}}</div>
        <div class="icon_list">
          <div class="screenfull" @click="Screen">
            <svg class="screen-out" width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path  d="M33 6H42V15"   stroke="#000000"  stroke-width="4"  stroke-linecap="round"  stroke-linejoin="miter"/><path  d="M42 33V42H33"  stroke="#000000"  stroke-width="4"  stroke-linecap="round"  stroke-linejoin="miter"/><path  d="M15 42H6V33"  stroke="#000000"  stroke-width="4"  stroke-linecap="round"  stroke-linejoin="miter"/><path  d="M6 15V6H15"  stroke="#000000"  stroke-width="4"  stroke-linecap="round"  stroke-linejoin="miter"/>
            </svg>
          </div>
          <i class="el-icon-close" @click="CloseDialog('dialog_visible')"></i>
        </div>
      </div>
    </template>
    <!-- 表格 -->
    <el-form
      :model="ruleForm"
      ref="ruleForm"
      label-width="100px"
      class="demo-ruleForm"
      :rules="rules_basic"
    >
      <el-form-item label="采购数量：" prop="purchase_quantity" class="colForm">
        <el-input v-model="ruleForm.purchase_quantity"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')" style="max-width:700px"></el-input>
      </el-form-item>
      <el-form-item label="采购日期：" prop="purchase_date" class="colForm">
        <el-date-picker
          v-model="ruleForm.purchase_date"
         type="date"
         format="YYYY-MM-DD"
         value-format="YYYY-MM-DD"
         placeholder="选择日期"
        ></el-date-picker>
      </el-form-item>
      <el-form-item label="仓库：" prop="warehouse_id" class="colForm">
        <el-select v-model="ruleForm.warehouse_id" clearable>
          <el-option
            v-for="item in WarehouseList"
            :key="item.id"
            :label="item.name"
            :value="item.id"
            style="display: flex"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="负责人：" prop="company_user_id" class="colForm">
        <el-select v-model="ruleForm.company_user_id" clearable>
          <el-option
            v-for="item in responsible_person_list"
            :key="item.id"
            :label="item.username"
            :value="item.id"
            style="display: flex"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item
        label="采购总金额："
        prop="current_total_price"
        class="colForm"
      >
        <el-input v-model="ruleForm.current_total_price"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')" style="max-width:700px"></el-input>
      </el-form-item>
      <el-form-item label="需要验收：" prop="is_check" class="colForm">
        <el-radio-group v-model="ruleForm.is_check">
          <el-radio label="0">否</el-radio>
          <el-radio label="1">是</el-radio>
        </el-radio-group>
      </el-form-item>
    </el-form>
    <!-- 详细表格 -->
    <div class="addOnline">
      <el-table :data="addOnline" ref="table" :border="true">
        <el-table-column label="商品sku" prop="sku" >
          <template #default="scope">
            <div :class="{'el-form-item is-error':this.sku_status && scope.$index==0} ">
            <el-select  v-model="scope.row.sku"  filterable  remote  reserve-keyword  placeholder="请输入关键词"  :remote-method="remoteMethod"  :loading="loading"   @change="change(scope.$index, $event)"   style="width:100%;"   @focus="Focus(scope.$index)"   @blur="Blur(scope.$index,scope.row.sku)"   clearable>
              <el-option
                v-for="item in options"
                :key="item.sku"
                :label="item.sku"
                :value="item.sku"
              >
              </el-option>
            </el-select>
            </div>
          </template>
        </el-table-column>
        <el-table-column label="采购价" prop="price">
          <template #default="scope">
            <el-input class="price" v-model="scope.row.price"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')"></el-input>
          </template>
        </el-table-column>
        <el-table-column label="采购数量" prop="quantity">
          <template #default="scope">
            <el-input class="quantity" v-model="scope.row.quantity"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')"></el-input>
          </template>
        </el-table-column>
        <el-table-column  label="操作"  prop="operate"  size="small"  width="200px"  :align="'left'">
          <template v-slot="scope">
            <div class="tableBtn">
              <el-button type="primary" size="small" @click.prevent="addRow('基本信息')"  >添加</el-button>
              <el-button type="danger" size="small" @click="delData(scope.$index, addOnline)"  v-if="addOnline.length != 1"  >删除</el-button>
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!-- 描述 -->
    <div class="textarea">
      <div class="textarea_title">描述：</div>
      <el-input
        type="textarea"
        placeholder="请输入内容"
        v-model="ruleForm.note"
        show-word-limit
        maxlength="100000"
        :autosize="{ minRows: 6, maxRows: 50 }"
      >
      </el-input>
    </div>
    <template #footer class="el-dialog-footer">
      <el-button @click="CloseDialog('dialog_visible')">取消</el-button>
      <el-button @click="resetForm('ruleForm')">重置</el-button>
      <el-button type="primary" @click="PurchaseAdd('ruleForm')"
        >立即创建</el-button
      >
    </template>
  </el-dialog>
</template>
<script>
import { purchaseAdd , purchaseDetail,purchaseUpdate} from "@/api/purchasingMan";
import { shoElmessage } from "@/utils/Elmessage";
import { GetAmzonProductList } from "@/api/AmazonProduct";
import { getLocalTime, isNaLL } from "@/utils/utils";
export default {
  props: {
    dialog_visible: {
      type: Boolean,
      default: false,
    },
    WarehouseList: {
      type: Array,
      default: [],
    },
    responsible_person_list:{
      type: Array,
      default: [],
    }
  },
  data() {
    return {
      options: [],// sku列表
      title: "新增",// 弹框标题
      isFullscreen: false,// 全屏
      // 采购基本信息
      //基本信息
      ruleForm: {
        purchase_date: "",// 采购需求时间
        warehouse_id: "",// 仓库id
        company_user_id: "",// 负责人id
        is_check: "",// 是否需要验收
        purchase_quantity: "",// 采购数量
        current_total_price: "",// 总金额
        note: "",// 说明
        purchasing_title:"新增",
      },
      rules_basic: {
        purchase_date: [
          { required: true, message: "请选择采购需求时间", trigger: "change" },
        ],
        warehouse_id: [
          { required: true, message: "请选择仓库", trigger: "change" },
        ],
      },
      // 详细采购商品
      addOnline: [
        {
          quantity: "",
          price: "",
          sku: "",
        },
      ],
       addsku:[ ],
      // sku校验
      sku_status:false,
      product_development_id:'',
      order_id:'',
      delete_item_ids:[],
    };
  },
  created() {},
  methods: {
    Blur(index,sku){
      console.log(index)
      if(index > 0){
        return
      }
      if(sku != '' ){
         this.sku_status = false
      }else{
        this.sku_status = true
      }
    },
    Focus(index){
      if(index != 0){
        return
      }
      this.sku_status = true
    },
    // sku搜索
    remoteMethod(query) {
      //  商品sku接口
      GetAmzonProductList({
        title: query,
        company_id: this.$store.state.userinfo.userinfo.company_id,
      }).then((res) => {
        if (res.code == 1) {
          this.options = res.data.data;
        }
      });
    },
    // 获取分类列表
    Init(item) {
      this.addsku = []
      if(isNaLL(item) && item.title == '新增'){
        this.purchasing_title = item.title
        this.product_development_id = item.id
      }
      if(isNaLL(item) && item.title == '修改'){
        this.order_id = item.id
        this.purchasing_title = item.title
        purchaseDetail({
          order_id:item.id
        }).then(res =>{
          if(res.code == 1){
              this.detail_data = res.data.data;
              let item = res.data.data;
              // 基本数据
              this.ruleForm = {
                purchase_date: getLocalTime(item.purchase_date),// 采购需求时间
                warehouse_id: item.warehouse_id,// 仓库id
                company_user_id: item.company_user_id,// 负责人id
                is_check: item.is_check,// 是否需要验收
                purchase_quantity: item.purchase_quantity,// 采购数量
                current_total_price: item.current_total_price,// 总金额
                note: item.note,// 说明
              };
              //  详细数据
              this.addOnline = item.order_item.map((el) => {
                return {
                  order_item_id: el.item_id,
                  quantity: el.quantity,
                  price: el.price,
                  sku: el.sku,
                };
              });
          }
        })
      }
      //初始化弹出框
      this.isFullscreen = false;
      // 初始化基本
      this.ruleForm = {
        purchase_date: "",// 采购需求时间
        warehouse_id: "", // 仓库id
        company_user_id: "",// 负责人id
        is_check: "",// 是否需要验收
        purchase_quantity: "",// 采购数量
        current_total_price: "",// 总金额
        note: "",// 说明
      }
      // 初始化产品详细
      this.addOnline = [
        {
          sku: "",
          price: "",
          quantity: "",
        },
      ]
    },
    Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    // 子组件名称 传值 不能修改父组件的值
    CloseDialog(item) {
      this.$emit("CloseDialog", {
        item: item,
        dialog_visible: this.dialog_visible,
      });
      this.$refs["ruleForm"].resetFields();
      this.isFullscreen = false;
      this.sku_status = false
    },
    // 添加详细采购
    addRow(item) {
      var list = {
        sku: "",
        price: "",
        quantity: "",
      };
      this.addOnline.push(list);
      this.addsku.push(list)
    },
    // 删除采购详情行
    delData(index, item) {
      this.delete_item_ids.push(item[index].order_item_id)
      this.addOnline.splice(index,1)
      if(this.addsku.indexOf(item) != -1){
        this.addsku.splice(this.addsku.indexOf(item),1)
      }
    },
    // sku的校验
    change(index, event) {
      if (event != "") {
        if(index == 0){
          this.sku_status = false;
        }
      }else{
        this.sku_status = true
      }
      this.options.forEach((el) => {
        if (event == el.sku) {
          this.addOnline[index].order_item_id = el.id;
          if(this.addsku.indexOf(event) != -1){
              this.addsku[this.addsku.indexOf(event)].order_item_id=el.id
          }
        }
      });
    },
    // 重置
    resetForm() {
      this.$refs["ruleForm"].resetFields();
      this.ruleForm.note = "";
      this.addOnline = [
        {
          sku: "",
          price: "",
          quantity: "",
        },
      ];
    },
    // 调用新增采购接口
    PurchaseAdd(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid && !this.sku_status) {
          this.ruleForm.purchase_date = (new Date(this.ruleForm.purchase_date).getTime()/1000)
          if(this.purchasing_title == '新增'){
            purchaseAdd({
              company_id: this.$store.state.userinfo.userinfo.company_id,
              skus: JSON.stringify(this.addOnline),
              ...this.ruleForm,
              product_development_id:this.product_development_id
            }).then((res) => {
              if (res.code == 1) {
                shoElmessage(true, "添加成功");
                this.CloseDialog("dialog_visible");
              } else {
                shoElmessage(true, `添加失败，原因：${res.msg}`, "error");
              }
            });
          }else{
            purchaseUpdate({
              skus: JSON.stringify(this.addOnline),
              order_id: this.order_id,
              ...this.ruleForm,
              delete_item_ids:this.delete_item_ids.join(),
              add_skus: JSON.stringify(this.addsku),
            }).then((res) => {
              if (res.code == 1) {
                shoElmessage(true, "修改成功");
                this.CloseDialog("revise_dialog_visible");
              } else {
                shoElmessage(true, `修改失败，原因：${res.msg}`, "error");
              }
            });
          }
        } else {
          shoElmessage(true, `请输入完整信息`, "error");
        }
      });
    },
  },
};
</script>
<style scoped lang="scss">
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
.bottomOperate {
  padding: 20px 0;
  text-align: right;
}
.textarea {
  margin-top: 20px;
}
.textarea_title {
  padding: 10px 0px;
}
.sku-input{
  border:1px solid red;
}
.el-table .cell{
  .el-form-item.is-error{
    margin-bottom: 0px;
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
