
<template>
  <!-- 弹框 -->
  <vite-dialog  v-model="dialog_visible" :title="title" @ViteClose="CloseDialog('dialog_visible')">
    <!-- 表格 -->
      <el-form  :model="ruleForm" ref="ruleForm" label-width="110px" label-position="left" class="demo-ruleForm" :rules="rules_basic">
       <el-form-item label="采购类型：" prop="purchase_type" class="colForm">
        <el-select v-model="ruleForm.purchase_type" clearable>
          <el-option label='商品采购' value='1'></el-option>
          <el-option label='样品采购' value='2'></el-option>
          <el-option label='物料采购' value='3'></el-option>
          <el-option label='定制采购' value='4'></el-option>
          <el-option label='特殊采购' value='5'></el-option>
        </el-select>
      </el-form-item>
      <el-form-item  label="标题：" prop="title"  class="colForm" v-if="parseInt(ruleForm.purchase_type) != '1'">
        <el-input v-model="ruleForm.title" ></el-input>
      </el-form-item>
      <el-form-item label="采购日期：" prop="purchase_date" class="colForm">
        <el-date-picker
          v-model="ruleForm.purchase_date"
         type="date"
         format="YYYY-MM-DD"
         value-format="x"
         placeholder="选择日期"
        style="width:100%"
        ></el-date-picker>
      </el-form-item>
       <el-form-item label="采购数量：" prop="purchase_quantity" class="colForm">
        <el-input v-model="ruleForm.purchase_quantity"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')"></el-input>
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
          <el-option v-for="item in user_list" :key="item.id" :label="item.username" :value="item.id" style="display: flex"></el-option>
        </el-select>
      </el-form-item>
       <el-form-item  label="采购总金额：" prop="current_total_price"  class="colForm">
        <el-input v-model="ruleForm.current_total_price"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')"></el-input>
      </el-form-item>
      <el-form-item label="产品研发：" prop="product_development_id" class="colForm" v-if="parseInt(ruleForm.purchase_type) != '1'">
        <el-select v-model="ruleForm.product_development_id" clearable>
          <el-option v-for="item in Development_list" :key="item.id" :label="item.title" :value="item.id" style="display: flex"></el-option>
        </el-select>
      </el-form-item>
       <el-form-item label="分类：" prop="category_id" class="colForm" v-if="parseInt(ruleForm.purchase_type) != '1'">
        <el-select v-model="ruleForm.category_id" clearable>
          <el-option v-for="item in Product_type_list" :key="item.id" :label="item.name" :value="item.id" style="display: flex"></el-option>
        </el-select>
      </el-form-item>
      
      <el-form-item label="品牌：" prop="brand_id" class="colForm" v-if="parseInt(ruleForm.purchase_type) != '1'">
        <el-select v-model="ruleForm.brand_id" clearable>
          <el-option v-for="item in brand_list" :key="item.id" :label="item.name" :value="item.id" style="display: flex"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="供应商：" prop="supplier_id" class="colForm" v-if="parseInt(ruleForm.purchase_type) != '1'">
        <el-select v-model="ruleForm.supplier_id" clearable>
          <el-option v-for="item in manufacturing_company_list" :key="item.id" :label="item.supplier_name" :value="item.id" style="display: flex"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="商品店铺：" prop="shop_id" class="colForm" >
        <el-select v-model="ruleForm.shop_id" clearable>
          <el-option v-for="item in shop_list" :key="item.id" :label="item.name" :value="item.id" style="display: flex"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="需要验收：" prop="is_check" class="colForm">
        <el-radio-group v-model="ruleForm.is_check">
          <el-radio :label="0">否</el-radio>
          <el-radio :label="1">是</el-radio>
        </el-radio-group>
      </el-form-item>
    </el-form>
    <!-- 详细表格 -->
    <div class="addOnline">
      <div class="textarea_title">采购信息：</div>
      <el-table :data="addOnlines" ref="table" :border="true" v-show="ruleForm.purchase_type != '1'">
            <!-- <el-table-column
              label="序号"
              type="index"
              width="60"
              :align="'center'"
            ></el-table-column>
            <el-table-column label="条码" :align="'center'">
              <template #default="scope">
                <el-input class="code" v-model="scope.row.code"></el-input>
              </template>
            </el-table-column> -->
            <el-table-column label="采购价（元）" :align="'center'" min-width="130">
              <template #header>
                <div class="purchasePrice_title">采购价（元）</div>
              </template>
              <template #default="scope">
                <div class="purchasePrice flex" :class="{'is_active':rules_purchasePrice && scope.$index == 0}">
                  <el-input
                    v-model="scope.row.purchasePrice"
                    @blur="BLUR('purchasePrice_status',scope.$index)"
                  ></el-input>
                </div>
              </template>
            </el-table-column>

            <!-- <el-table-column label="原价（元）" :align="'center'" min-width="130">
              <template #header>
                <div class="purchasePrice_title">原价（元）</div>
              </template>
              <template #default="scope">
                <div class="purchasePrice flex" :class="{'is_active':rules_compareatPrice && scope.$index == 0}">
                  <el-input
                    v-model="scope.row.compare_at_price"
                    @blur="BLUR('compareatPrice_status',scope.$index)"
                  ></el-input>
                </div>
              </template>
            </el-table-column>

            <el-table-column label="平台价（元）" :align="'center'" min-width="130">
              <template #header>
                <div class="purchasePrice_title">平台价（元）</div>
              </template>
              <template #default="scope">
                <div class="purchasePrice " :class="{'is_active':rules_platformPrice && scope.$index == 0}">
                  <el-input
                    v-model="scope.row.platformPrice"
                    @blur="BLUR('platformPrice_status',scope.$index)"
                  ></el-input>
                </div>
              </template>
            </el-table-column>

            <el-table-column label="零售价（元）" :align="'center'" min-width="130">
              <template #header>
                <div class="purchasePrice_title">零售价（元）</div>
              </template>
              <template #default="scope">
                <div class="purchasePrice flex" :class="{'is_active':rules_retailPrice && scope.$index == 0}">
                  <el-input
                    v-model="scope.row.retailPrice"
                    @blur="BLUR('retailPrice_status',scope.$index)"
                  ></el-input>
                </div>
              </template>
            </el-table-column> -->
            <el-table-column label="商品重量（G）" :align="'center'" min-width="150">
              <template #default="scope">
                <el-input
                  class="proWeigh"
                  v-model="scope.row.proWeigh"
                ></el-input>
              </template>
            </el-table-column>
            <el-table-column
              label="商品规格（cm）"
              :align="'center'"
              class-name="moreStyle"
              min-width="150"
            >
              <template #default="scope">
                <el-input
                  class="proSize size"
                  v-model="scope.row.proSize.length"
                ></el-input>
                <el-input
                  class="proSize size"
                  v-model="scope.row.proSize.width"
                ></el-input>
                <el-input
                  class="proSize size"
                  v-model="scope.row.proSize.height"
                ></el-input>
              </template>
            </el-table-column>
            <!-- <el-table-column label="包装重量（G）" :align="'center'" min-width="150">
              <template #default="scope">
                <el-input
                  class="proWeigh"
                  v-model="scope.row.package_weight"
                ></el-input>
              </template>
            </el-table-column>
            <el-table-column
              label="包装规格（cm）"
              :align="'center'"
              class-name="moreStyle"
              min-width="150"
            >
              <template #default="scope">
                <el-input
                  class="packSize size"
                  v-model="scope.row.packSize.package_length"
                ></el-input>
                <el-input
                  class="packSize size"
                  v-model="scope.row.packSize.package_width"
                ></el-input>
                <el-input
                  class="packSize size"
                  v-model="scope.row.packSize.package_height"
                ></el-input>
              </template>
            </el-table-column> -->
            
            <!-- <el-table-column
              label="操作"
              prop="operate"
              size="small"
              width="100px"
              :align="'left'"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-button
                    type="text"
                    size="small"
                    @click.prevent="addRow('基本信息')"
                    >添加</el-button
                  >
                  <el-button
                    type="text"
                    size="small"
                    @click="delData(scope.$index, addOnlines)"
                    v-if="addOnlines.length != 1"
                    >删除</el-button
                  >
                </div>
              </template>
        </el-table-column> -->
      </el-table>
      <el-table :data="addOnline" ref="table" :border="true" v-show="ruleForm.purchase_type == '1'">
        <el-table-column label="商品sku" prop="sku" >
          <template #default="scope">
            <div :class="{'active_error':sku_status && scope.$index==0} ">
            <el-select
              v-model="scope.row.sku"
              filterable
              remote
              reserve-keyword
              placeholder="请输入关键词"
              :remote-method="remoteMethod"
              :loading="loading"
              @change="change(scope.$index,scope.row.sku)"
               style="width:100%;"
               @focus="Focus(scope.$index,scope.row.sku)"
               @blur="Blur(scope.$index,scope.row.sku)"
               clearable
              >
              <el-option v-for="item in remote_list" :key="item.inventory_sku" :label="item.title" :value="item.inventory_sku">
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
        <el-table-column label="操作" prop="operate" size="small" width="200px" :align="'left'">
          <template v-slot="scope">
            <div class="tableBtn">
              <el-button type="primary" size="small" @click.prevent="addRow('采购信息')">添加</el-button>
              <el-button type="danger" size="small" @click="delData(scope.$index, addOnline)" v-if="addOnline.length != 1" >删除</el-button>
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!-- 描述 -->
    <div class="textarea">
      <div class="textarea_title">描述：</div>
      <EditWangeditor ref="editwangeditor" :editor="ruleForm.note" v-model="ruleForm.note"></EditWangeditor>
    </div>
    <template #footer class="el-dialog-footer">
      <el-button @click="CloseDialog('dialog_visible')">取消</el-button>
      <el-button @click="resetForm('ruleForm')">重置</el-button>
      <el-button type="primary" @click="PurchaseAdd('ruleForm')">立即创建</el-button>
    </template>
  </vite-dialog>
</template>
<script>
import { purchaseAdd } from "@/api/purchasingMan";
import { shoElmessage } from "@/utils/Elmessage";
import { GetProductList } from "@/api/Porductapi";
import { isNaLL } from "../../../utils/utils";
import EditWangeditor from "../../../components/EditWangeditor/EditWangeditor.vue";
export default {
    components:{
      EditWangeditor
    },
    props: {
        dialog_visible: {
            type: Boolean,
            default: false,
        },
        WarehouseList: {
            type: Array,
            default: [],
        },
        user_list: {
            type: Array,
            default: [],
        },
        Product_type_list: {
            type: Array,
            default: [],
        },
        brand_list: {
            type: Array,
            default: [],
        },
        manufacturing_company_list: {
            type: Array,
            default: [],
        },
        Development_list: {
            type: Array,
            default: [],
        },
        shop_list:{
          type: Array,
          default: [],
        }
    },
    data() {
        return {
            //每个输入框的验证
            purchasePrice_status: false,
            retailPrice_status: false,
            platformPrice_status: false,
            compareatPrice_status: false,
            //基本信息
            addOnlines: [
                {
                    // code: "",
                    // proWeigh: "",
                    proSize: { length: "", width: "", height: "" },
                    // package_weight: "",
                    // packSize: { package_length: "", package_width: "", package_height: "" },
                    purchasePrice: "",
                    // retailPrice: "",
                    // platformPrice: "",
                    // inStock: "",
                    // compare_at_price: ""
                },
            ],
            remote_list: [],
            title: "新增采购",
            //基本信息
            ruleForm: {
                purchase_type: "1",
                purchase_date: "",
                warehouse_id: "",
                company_user_id: "",
                is_check: 0,
                purchase_quantity: "",
                current_total_price: "",
                note: "",
                product_development_id: "",
                title: "",
                category_id: "",
                brand_id: "",
                supplier_id: "", //供应商
                shop_id:"",
            },
            rules_basic: {
                purchase_date: [
                    { required: true, message: "请选择采购需求时间", trigger: "change" },
                ],
                warehouse_id: [
                    { required: true, message: "请选择仓库", trigger: "change" },
                ],
                purchase_type: [
                    { required: true, message: "请选择采购类型", trigger: "change" },
                ],
                brand_id: [
                    { required: true, message: "请选择品牌", trigger: "change" }
                ],
                title: [
                    { required: true, message: "请输入标题", trigger: "blur" }
                ],
                product_development_id: [
                    { required: true, message: "请选择产品研发", trigger: "change" }
                ],
                shop_id:[
                  { required: true, message: "请选择商品店铺类型", trigger: "change" }
                ]
            },
            // 详细采购商品
            addOnline: [
                {
                    quantity: "",
                    price: "",
                    sku: "",
                },
            ],
            // sku校验
            sku_status: false,
        };
    },
    watch: {
        "ruleForm.purchase_type": function (newval, oldval) {
            if (parseInt(newval) != 1) {
                this.rules_basic["brand_id"][0].required = true;
                this.rules_basic["title"][0].required = true;
                this.rules_basic["product_development_id"][0].required = true;
                this.rules_basic['shop_id'].required = true
            }
            else {
                this.rules_basic["brand_id"][0].required = false;
                this.rules_basic["title"][0].required = false;
                this.rules_basic["product_development_id"][0].required = false;
                this.rules_basic['shop_id'].required = false
            }
        }
    },
    computed: {
        rules_purchasePrice: function () {
            return !isNaLL(this.addOnlines[0].purchasePrice) && this.purchasePrice_status;
        },
        rules_retailPrice: function () {
            return !isNaLL(this.addOnlines[0].retailPrice) && this.retailPrice_status;
        },
        rules_platformPrice: function () {
            return !isNaLL(this.addOnlines[0].platformPrice) && this.platformPrice_status;
        },
        rules_compareatPrice: function () {
            return !isNaLL(this.addOnlines[0].compare_at_price) && this.compareatPrice_status;
        }
    },
    methods: {
        Blur(index, sku) {
            if (sku != "" && index == 0) {
                this.sku_status = false;
            }
            else {
                this.sku_status = true;
            }
        },
        Focus(index) {
            if (index == 0) {
                this.sku_status = false;
            }
        },
        //sku的校验
        change(index, sku) {
            // console.log(index,sku)
            if (sku != "" && index == 0) {
                this.sku_status = false;
            }
            else {
                this.sku_status = true;
            }
        },
        // sku搜索
        remoteMethod(query) {
            //  商品sku接口
            GetProductList({
                title: query,
                company_id: this.$store.state.userinfo.userinfo.company_id,
            }).then((res) => {
                if (res.code == 1) {
                    this.remote_list = res.data.data;
                }
            });
        },
        Init() {
            // 初始化基本
            this.ruleForm = {
                purchase_type: "1",
                purchase_date: "",
                warehouse_id: "",
                company_user_id: "",
                is_check: 0,
                purchase_quantity: "",
                current_total_price: "",
                note: "",
                product_development_id: "",
                title: "",
                category_id: "",
                brand_id: "",
                supplier_id: "", //供应商
                shop_id:"",
                
            };
            // 初始化产品详细
            this.addOnline = [
                {
                    sku: "",
                    price: "",
                    quantity: "",
                },
            ];
            //基本信息
            this.addOnlines = [
                {
                    // code: "",
                    // proWeigh: "",
                    proSize: { length: "", width: "", height: "" },
                    // package_weight: "",
                    // packSize: { package_length: "", package_width: "", package_height: "" },
                    purchasePrice: "",
                    // retailPrice: "",
                    // platformPrice: "",
                    // inStock: "",
                    // compare_at_price: ""
                }
            ];
            //输入框初始化
            this.purchasePrice_status = false;
            this.retailPrice_status = false;
            this.platformPrice_status = false;
            this.compareatPrice_status = false;
        },
        // 子组件名称 传值 不能修改父组件的值
        CloseDialog(item) {
            this.$emit("CloseDialog", {
                item: item,
                dialog_visible: this.dialog_visible,
            });
            this.$refs["ruleForm"].resetFields();
            this.isFullscreen = false;
            this.sku_status = false;
        },
        //输入框获取焦距
        BLUR(item, index) {
            if (index != 0)
                return;
            this.$data[item] = true;
        },
        // 添加详细采购
        addRow(item) {
            if (item == "基本信息") {
                var list = {
                    rowNum: this.rowNum,
                    code: "",
                    proWeigh: "",
                    proSize: { length: "", width: "", height: "" },
                    package_weight: "",
                    packSize: { package_length: "", package_width: "", package_height: "" },
                    purchasePrice: "",
                    retailPrice: "",
                    platformPrice: "",
                    compare_at_price: "",
                    inStock: "",
                };
                this.addOnlines.push(list);
            }
            else {
                var list = {
                    rowNum: this.rowNum,
                    sku: "",
                    price: "",
                    quantity: "",
                };
                this.addOnline.push(list);
            }
            this.rowNum += 1;
        },
        // 删除采购详情行
        delData(index, item) {
            item.splice(index, 1);
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
          let item;
          if(parseInt(this.ruleForm.purchase_type) == 1){
              let rule = JSON.parse(JSON.stringify(this.ruleForm))

              rule.purchase_date = rule.purchase_date / 1000;
              if(!isNaLL(this.addOnline[0].sku)){
                this.sku_status = true
              }
              delete rule.brand_id
              delete rule.supplier_id
              delete rule.product_development_id
              delete rule.category_id
              delete rule.title
              item = {
                ...rule,
                skus: JSON.stringify(this.addOnline)
              }
           }else{
              
              this.purchasePrice_status = true;
              this.retailPrice_status = true;
              this.platformPrice_status = true;
              this.compareatPrice_status = true;
              item = {
                ...this.addOnlines[0].proSize,
                cost:this.addOnlines[0].purchasePrice,
                ...this.ruleForm
              }
           }
          this.$refs[formName].validate((valid) => {
                if (valid && !this.sku_status) {
                    purchaseAdd({
                        company_id: this.$store.state.userinfo.userinfo.company_id,
                        ...item,
                        
                    }).then((res) => {
                        if (res.code == 1) {
                            shoElmessage(true, "添加成功");
                            this.CloseDialog("dialog_visible");
                        }
                        else {
                            shoElmessage(true, `添加失败，原因：${res.msg}`, "error");
                        }
                    });
                }
                else {
                    shoElmessage(true, `请输入完整信息`, "error");
                }
            });
        },
    },
};
</script>
<style scoped lang="scss">
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
// 弹框表格
.el-dialog {
  .el-form.demo-ruleForm {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    .colForm {
      text-align: left !important;
      margin-right: 10px !important;
      width:320px;
    }
  }
  .el-textarea {
    height: 200px;
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
.moreStyle {
  .cell {
    display: flex;
    .size {
      width: 30%;
      input {
        width: 90%;
        padding: 10%;
      }
    }
  }
}
//采购所有
.purchasePrice.is_active{
  :deep(.el-input__inner){
    border-color: var(--el-color-danger);
  }
  .el-form-item__error{
    position: relative;
    height: 17px;
    transition: height .5s;
    width: 100%;
  }
}
</style>
<style lang="scss">
  .active_error .el-select  .el-input__inner:focus{
    border-color:#f56c6c !important;
  }
  .active_error .el-select  .el-input__inner{
      border-color:#f56c6c !important;
  }
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
</style>
