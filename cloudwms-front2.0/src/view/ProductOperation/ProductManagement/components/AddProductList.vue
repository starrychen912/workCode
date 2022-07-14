<template>
  <!-- 弹出新增商品框 -->
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
        <div class="title">新增</div>
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
          <i class="el-icon-close" @click="Close('dialog_visible')"></i>
        </div>
      </div>
    </template>
    <el-tabs v-model="activeName" @tab-click="handleClick">
      <el-tab-pane label="基本信息" name="first" class="baseInfo">
        <template #label>
          <span>
            <el-tooltip content="有必填项" placement="top" v-if="basic_status">
              <i class="el-icon-warning" style="color: red"></i>
            </el-tooltip>
            基本信息
          </span>
        </template>
        <el-form
          :model="ruleForm"
          ref="ruleForm"
          label-width="100px"
          class="demo-ruleForm"
          :rules="rules_basic"
        >
          <el-form-item label="商品名称：" prop="name" class="colForm">
            <el-input v-model="ruleForm.name"></el-input>
          </el-form-item>
          <el-form-item label="商品类别：" prop="category" class="colForm">
            <!-- <el-select v-model="ruleForm.category" clearable >
              <el-option
                v-for="item in ProductTypeList"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              >
              </el-option>
            </el-select> -->
            <el-cascader
              :options="ProductTypeList"
              :collapse-tags="true"
              :show-all-levels="false"
              :props="{
                multiple: false,
                checkStrictly: true,
                value: 'id',
                label: 'name',
                emitPath: false,
              }"
              v-model="ruleForm.category"
              clearable
            >
              <template #default="{ data }">
                <span>{{ data.name }}</span>
                <!-- <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span> -->
              </template>
            </el-cascader>
          </el-form-item>
          <el-form-item label="商品品牌：" prop="brand" class="colForm">
            <el-select v-model="ruleForm.brand" clearable>
              <el-option
                v-for="item in BrandList"
                :key="item.id"
                :label="item.name"
                :value="item.id"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="供应商：" prop="supplier" class="colForm">
            <el-select v-model="ruleForm.supplier" clearable>
              <el-option
                v-for="item in ManufacturingCompanyList"
                :key="item.id"
                :label="item.supplier_name"
                :value="item.id"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item
            label="商品店铺："
            prop="shop_id"
            class="colForm"
          >
            <el-select v-model="ruleForm.shop_id" clearable >
              <el-option
                v-for="item in shop_list"
                :key="item.id"
                :label="item.name"
                :value="item.id"
                style="display: flex"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <!-- <el-form-item
            label="库存sku："
            prop="stockSku"
            class="colForm"
          >
            <el-input v-model="ruleForm.stockSku" placeholder="库存SKU"></el-input>
          </el-form-item> -->
          <el-form-item label="序列号：" prop="barcode" class="colForm">
            <el-input v-model="ruleForm.barcode"></el-input>
          </el-form-item>
          <el-form-item label="商品状态：" prop="status" class="colForm">
            <el-select v-model="ruleForm.status" multiple-limit="0" clearable>
              <el-option label="销售中" :value="0"></el-option>
              <el-option label="已下架" :value="1"></el-option>
              <el-option label="未上架" :value="2"></el-option>
              <el-option label="采购中" :value="3"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <div class="addOnline">
          <el-table :data="addOnline" ref="table">
            <el-table-column
              label="序号"
              type="index"
              width="60"
              align="center"
            ></el-table-column>
            <el-table-column label="条码" align="center">
              <template #default="scope">
                <el-input class="code" v-model="scope.row.code"></el-input>
              </template>
            </el-table-column>
            <el-table-column
              label="采购价（元）"
              align="center"
              min-width="130"
            >
              <template #header>
                <div class="purchasePrice_title">采购价（元）</div>
              </template>
              <template #default="scope">
                <div
                  class="purchasePrice flex"
                  :class="{
                    is_active: rules_purchasePrice && scope.$index == 0,
                  }"
                >
                  <el-input
                    v-model="scope.row.purchasePrice"
                    @blur="BLUR('purchasePrice_status', scope.$index)"
                  ></el-input>
                </div>
              </template>
            </el-table-column>

            <el-table-column label="原价（元）" align="center" min-width="130">
              <template #header>
                <div class="purchasePrice_title">原价（元）</div>
              </template>
              <template #default="scope">
                <div
                  class="purchasePrice flex"
                  :class="{
                    is_active: rules_compareatPrice && scope.$index == 0,
                  }"
                >
                  <el-input
                    v-model="scope.row.compare_at_price"
                    @blur="BLUR('compareatPrice_status', scope.$index)"
                  ></el-input>
                </div>
              </template>
            </el-table-column>

            <el-table-column
              label="平台价（元）"
              align="center"
              min-width="130"
            >
              <template #header>
                <div class="purchasePrice_title">平台价（元）</div>
              </template>
              <template #default="scope">
                <div
                  class="purchasePrice"
                  :class="{
                    is_active: rules_platformPrice && scope.$index == 0,
                  }"
                >
                  <el-input
                    v-model="scope.row.platformPrice"
                    @blur="BLUR('platformPrice_status', scope.$index)"
                  ></el-input>
                </div>
              </template>
            </el-table-column>

            <el-table-column
              label="零售价（元）"
              align="center"
              min-width="130"
            >
              <template #header>
                <div class="purchasePrice_title">零售价（元）</div>
              </template>
              <template #default="scope">
                <div
                  class="purchasePrice flex"
                  :class="{ is_active: rules_retailPrice && scope.$index == 0 }"
                >
                  <el-input
                    v-model="scope.row.retailPrice"
                    @blur="BLUR('retailPrice_status', scope.$index)"
                  ></el-input>
                </div>
              </template>
            </el-table-column>
            <el-table-column
              label="商品重量（G）"
              align="center"
              min-width="150"
            >
              <template #default="scope">
                <el-input
                  class="proWeigh"
                  v-model="scope.row.proWeigh"
                ></el-input>
              </template>
            </el-table-column>
            <el-table-column
              label="商品规格（cm）"
              align="center"
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
            <el-table-column
              label="包装重量（G）"
              align="center"
              min-width="150"
            >
              <template #default="scope">
                <el-input
                  class="proWeigh"
                  v-model="scope.row.package_weight"
                ></el-input>
              </template>
            </el-table-column>
            <el-table-column
              label="包装规格（cm）"
              align="center"
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
            </el-table-column>

            <el-table-column
              label="操作"
              prop="operate"
              size="small"
              width="200px"
              align="left"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-button
                    type="primary"
                    size="small"
                    @click.prevent="addRow('基本信息')"
                    >添加</el-button
                  >
                  <el-button
                    type="danger"
                    size="small"
                    @click="delData(scope.$index, addOnline)"
                    v-if="addOnline.length != 1"
                    >删除</el-button
                  >
                </div>
              </template>
            </el-table-column>
          </el-table>
        </div>
        <div class="textarea">
          <orderlistwang-editor
            :editor="ruleForm.description"
            @Change="editorChange"
            @Onfocus="Onfocus"
            @Onblur="Onblur"
          ></orderlistwang-editor>
        </div>
      </el-tab-pane>

      <!-- 扩展信息 -->

      <el-tab-pane label="扩展信息" name="second" class="extendedInfo">
        <el-form
          :model="ruleForm_extend"
          ref="ruleForm_extend"
          :rules="rules_extend"
          label-width="15%"
          class="demo-ruleForm"
        >
          <el-form-item label="材质：" prop="material">
            <el-input
              v-model="ruleForm.material"
              style="max-width: 700px"
            ></el-input>
          </el-form-item>

          <el-form-item label="用途：" prop="use">
            <el-input
              v-model="ruleForm.use"
              style="max-width: 700px"
            ></el-input>
          </el-form-item>
          <el-form-item label="属性：">
            <el-checkbox label="带电"></el-checkbox>
            <el-checkbox label="带磁"></el-checkbox>
            <el-checkbox label="危险"></el-checkbox>
          </el-form-item>
          <el-form-item label="海关报关名：" prop="customsDeclaration">
            <el-input
              v-model="ruleForm.customsDeclaration"
              style="max-width: 700px"
            ></el-input>
          </el-form-item>
          <el-form-item label="海关编码：" prop="customsCode">
            <el-input
              v-model="ruleForm.customsCode"
              style="max-width: 700px"
            ></el-input>
          </el-form-item>
          <el-form-item>
            <div class="Addmore" @click="ToggleExtra">
              <i class="el-icon-plus"></i>
              展开更多
            </div>
          </el-form-item>
          <div class="exrea" v-show="extra_status">
            <el-form-item v-for="(item, index) in extra" :key="index">
              <template #label>
                <div class="additional">
                  <el-input
                    v-model="item.name"
                    style="width: 50%"
                    placeholder="名称"
                  ></el-input>
                </div>
              </template>
              <div class="flex">
                <el-input
                  v-model="item.value"
                  style="max-width: 700px"
                  placeholder="vlaue"
                ></el-input>
                <div class="extra_button">
                  <el-button
                    type="primary"
                    v-if="index == extra.length - 1"
                    @click="Addextra"
                    >添加</el-button
                  >
                  <el-button
                    type="danger"
                    v-if="extra.length != 1"
                    @click="Dleteextra(index)"
                    >删除</el-button
                  >
                </div>
              </div>
            </el-form-item>
          </div>
        </el-form>
      </el-tab-pane>

      <!-- 库存信息 -->
      <el-tab-pane label="库存信息" name="third">
        <template #label>
          <span>
            <el-tooltip content="有必填项" placement="top" v-if="stock_status">
              <i class="el-icon-warning" style="color: red"></i>
            </el-tooltip>
            库存信息
          </span>
        </template>
        <div class="addOnline">
          <div class="addOnline_title">
            <i class="el-icon-warning"></i
            >默认仓库是自动选择第一个仓库，在没有输入自定义库存数系统会默认为10。
          </div>
          <el-table :data="Stockinfo" ref="table">
            <el-table-column
              label="序号"
              type="index"
              width="60"
              align="center"
            ></el-table-column>
            <el-table-column label="仓库" align="center">
              <template #default="scope">
                <el-select
                  v-model="scope.row.inStock"
                  @change="Option_Change(scope.$index, $event)"
                >
                  <el-option
                    v-for="item in WarehouseList"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  ></el-option>
                </el-select>
              </template>
            </el-table-column>

            <el-table-column label="初期库存数" align="center">
              <template #default="scope">
                <el-input v-model="scope.row.purchasePrice"></el-input>
              </template>
            </el-table-column>
            <el-table-column label="最低安全库存数" align="center">
              <template #default="scope">
                <el-input
                  class="retailPrice"
                  v-model="scope.row.retailPrice"
                ></el-input>
              </template>
            </el-table-column>
            <el-table-column label="最高安全库存数" align="center">
              <template #default="scope">
                <el-input
                  class="platformPrice"
                  v-model="scope.row.platformPrice"
                ></el-input>
              </template>
            </el-table-column>
            <el-table-column
              label="操作"
              prop="operate"
              size="small"
              width="200px"
              align="center"
              fixed="right"
            >
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-button
                    type="primary"
                    size="small"
                    @click.prevent="addRow('库存信息')"
                    >添加</el-button
                  >
                  <el-button
                    type="danger"
                    size="small"
                    @click="delData(scope.$index, Stockinfo)"
                    v-if="Stockinfo.length != 1"
                    >删除</el-button
                  >
                </div>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </el-tab-pane>

      <!-- 图片信息 -->
      <el-tab-pane label="图片信息" name="fourth">
        <div class="pic">
          <div class="pic_images--list">
            <draggable
              class="draggable_list flex flex-wrap"
              v-model="flie_list"
              @start="drag = true"
              @end="drag = false"
              item-key="id"
              :animation="1000"
              @change="onMoveCallback"
              :forceFallback="true"
            >
              <template #item="{ element }">
                <div class="pic_upload-demo">
                  <ul class="el-upload-list el-upload-list--picture-card">
                    <li class="el-upload-list__item is-success">
                      <el-image
                        style="width: 100%; height: 100%"
                        :src="element.fullurl"
                        :preview-src-list="flie_list"
                      ></el-image>
                      <!-- <img class="el-upload-list__item-thumbnail" :src="element.fullurl"> -->
                      <label class="el-upload-list__item-status-label"
                        ><i class="el-icon-upload-success el-icon-check"></i
                      ></label>
                      <i class="el-icon-close"></i>
                      <i class="el-icon-close-tip">{{ element.id }}</i>
                      <span class="el-upload-list__item-actions">
                        <span
                          class="el-upload-list__item-preview"
                          @click="Enlarge_IMG(element)"
                        >
                          <i class="el-icon-zoom-in"></i>
                        </span>
                        <span
                          class="el-upload-list__item-delete"
                          @click="DELETE_IMG(element)"
                        >
                          <i class="el-icon-delete"></i>
                        </span>
                      </span>
                    </li>
                  </ul>
                </div>
              </template>
            </draggable>
            <el-upload
              class="pic_upload-demo"
              drag
              :headers="headers"
              :action="baseUrl + '/api/common/upload'"
              list-type="picture-card"
              :on-remove="onRemove"
              :on-success="OnSuccess"
              :on-error="UploadError"
              :on-change="UploadChange"
              :before-upload="BeforeUpload"
              multiple
              :show-file-list="false"
              :accept="file_type"
            >
              <i class="el-icon-upload"></i>
              <div class="el-upload__text">
                Drop file here or <em>click to upload</em>
              </div>
            </el-upload>
          </div>
        </div>
      </el-tab-pane>
    </el-tabs>
    <template #footer class="el-dialog-footer">
      <el-button @click="Close('dialog_visible')">取消</el-button>
      <el-button @click="resetForm('ruleForm', 'ruleForm_extend')"
        >重置</el-button
      >
      <el-button
        type="primary"
        @click="submitForm('ruleForm', 'ruleForm_extend')"
        >立即创建</el-button
      >
    </template>
  </el-dialog>

  <!-- 放大图片 -->
  <el-dialog
    v-model="Enlarge_Dialog"
    top="15px"
    height="80vh"
    fit="fill"
    custom-class="enlarge_img"
  >
    <el-image :src="Enlarge_Dialog_IMG"></el-image>
  </el-dialog>
</template>
<script>
import { netConfig } from "@/config/net.config";
import { getAccessToken } from "@/utils/AccessToken";
import { AddingProduct, GetProductDetail } from "@/api/Addproduct";
import draggable from "vuedraggable";
import { isNaLL } from "@/utils/utils";
import { shoElmessage } from "@/utils/Elmessage";
import { operateInventoryLog } from "@/api/Stocklog";
// import OrderlistwangEditor from "../../../Shopfly/Orderlist/OrderlistwangEditor.vue";
import OrderlistwangEditor from "../../../Shopfly/Orderlist/OrderlistwangEditor.vue";
import { watch } from "vue";
export default {
  components: {
    draggable,
    OrderlistwangEditor,
  },
  props: {
    dialog_visible: {
      type: Boolean,
      default: false,
    },
    ProductTypeList: {
      type: Array,
      default: [],
    },
    WarehouseList: {
      type: Array,
      default: [],
    },
    ManufacturingCompanyList: {
      type: Array,
      default: [],
    },
    BrandList: {
      type: Array,
      default: [],
    },
    shop_list:{
      type:Array,
      default:[]
    }
  },
  data() {
    return {
      flie_list: [],
      file_type: ".png,.jpg,.jpeg,.gif,.svg,.GIF,.JPEG,.PNG,.JPG,.SVG", //文件类型

      dialogImageUrl: "",
      dialogVisible: false,
      activeName: "first",
      //基本信息
      ruleForm: {
        name: "",
        category: "",
        brand: "",
        supplier: "",
        // proSku:'',
        // stockSku:'',
        barcode: "",
        status: "",
        description: "",
        shop_id:"",
      },
      //扩展信息
      ruleForm_extend: {
        material: "",
        use: "",
        customsDeclaration: "",
        customsCode: "",
      },

      title: "新增",
      isFullscreen: false,
      //上传图片url
      baseUrl: netConfig.baseURL,
      //上传文件额外参数
      headers: {
        token: getAccessToken(),
      },

      //基本信息校验参
      rules_basic: {
        name: [
          { required: true, message: "请输入商品名称", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ],
        category: [
          { required: true, message: "请选择商品类别", trigger: "change" },
        ],
        brand: [
          { required: true, message: "请选择商品品牌", trigger: "change" },
        ],
        supplier: [
          { required: true, message: "请选择供应商", trigger: "change" },
        ],
        shop_id:[
          { required: true, message: "请选择店铺", trigger: "change" },
        ]
        // proSku: [
        //   { required: true, message: "请输入商品sku", trigger: "blur" },
        //   { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        // ],
        // stockSku: [
        //   { required: true, message: "请输入库存sku", trigger: "blur" },
        //   { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        // ],
        // barcode: [
        //   { required: true, message: "请输入序列号", trigger: "blur" },
        //   { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        // ],
        // status:[
        //   { required: true, message: "请选择商品状态", trigger: "change" },
        // ]
      },
      //扩展信息校验
      rules_extend: {
        // material: [
        //   { required: true, message: "请输入材质", trigger: "blur" },
        //   { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        // ],
        // use: [
        //   { required: true, message: "请输入用途", trigger: "blur" },
        //   { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        // ],
        // customsDeclaration: [
        //   { required: true, message: "请输入海关报关名", trigger: "blur" },
        //   { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        // ],
        // customsCode: [
        //   { required: true, message: "请输入海关编码", trigger: "blur" },
        //   { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        // ],
      },
      rules: {
        date1: [
          {
            type: "date",
            required: true,
            message: "请选择日期",
            trigger: "change",
          },
        ],
        date2: [
          {
            type: "date",
            required: true,
            message: "请选择时间",
            trigger: "change",
          },
        ],
        type: [
          {
            type: "array",
            required: true,
            message: "请至少选择一个活动性质",
            trigger: "change",
          },
        ],
        resource: [
          { required: true, message: "请选择活动资源", trigger: "change" },
        ],
        desc: [{ required: true, message: "请填写活动形式", trigger: "blur" }],
      },

      //基本信息
      addOnline: [
        {
          code: "",
          proWeigh: "",
          proSize: { length: "", width: "", height: "" },
          package_weight: "",
          packSize: {
            package_length: "",
            package_width: "",
            package_height: "",
          },
          purchasePrice: "",
          retailPrice: "",
          platformPrice: "",
          inStock: "",
          compare_at_price: "",
        },
      ],

      //库存信息
      Stockinfo: [
        {
          inStock: "默认",
          purchasePrice: 10,
          platformPrice: 10,
          retailPrice: 10,
        },
      ],
      //扩展信息额外参数
      extra: [
        {
          name: "",
          value: "",
        },
        {
          name: "",
          value: "",
        },
      ],
      extra_status: true,

      //每个输入框的验证
      purchasePrice_status: false,
      retailPrice_status: false,
      platformPrice_status: false,
      compareatPrice_status: false,

      Delete_list: [],

      //放大图片
      Enlarge_Dialog: false,
      Enlarge_Dialog_IMG: "",

      //基本信息校验
      basic_status: false,
      //库存信息校验
      stock_status: false,
      //新增库存信息
      upload_satus: false,
    };
  },
  computed: {
    rules_purchasePrice: function () {
      return (
        !isNaLL(this.addOnline[0].purchasePrice) && this.purchasePrice_status
      );
    },
    rules_retailPrice: function () {
      return !isNaLL(this.addOnline[0].retailPrice) && this.retailPrice_status;
    },
    rules_platformPrice: function () {
      return (
        !isNaLL(this.addOnline[0].platformPrice) && this.platformPrice_status
      );
    },
    rules_compareatPrice: function () {
      return (
        !isNaLL(this.addOnline[0].compare_at_price) &&
        this.compareatPrice_status
      );
    },
  },
  methods: {
    //库存选择
    Option_Change(item, index) {
      // this.addOnline[item].
      this.stock_status = false;
    },
    handleClick() {},
    // 输入框
    editorChange(e) {
      this.ruleForm.description = e;
    },
    //输入框获取焦距
    BLUR(item, index) {
      if (index != 0) return;
      this.$data[item] = true;
    },
    //放大图片
    Enlarge_IMG(item) {
      this.Enlarge_Dialog = true;
      this.Enlarge_Dialog_IMG = item.fullurl;
    },
    //上传图片error
    UploadError() {},
    SelectPorductList() {
      this.Getlist();
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
    //删除图片响应
    onRemove(removeitem) {
      console.log(removeitem);
    },
    //图片上传成功
    OnSuccess(res) {
      this.upload_satus = true;
      if (res.code == 1) {
        this.flie_list.push(res.data);
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
    //删除图片
    DELETE_IMG(item) {
      let index = this.flie_list.indexOf(item);
      this.flie_list.splice(index, 1);
    },
    onMoveCallback(item) {
      console.log(item);
    },
    //入库
    async OperateInventoryLog(inventory_sku){
        for(let i=0; i<this.Stockinfo.length;i++){
            operateInventoryLog({
                warehouse_id:this.Stockinfo[i].inStock,
                inventory_sku:inventory_sku,
                in_quantity:this.Stockinfo[i].purchasePrice,
                out_quantity:'',
                min_quantity:this.Stockinfo[i].platformPrice,
                max_quantity:this.Stockinfo[i].retailPrice,
                memo:'',
                company_id:this.$store.state.userinfo.userinfo.company_id,
                
            }).then(res =>{
                if(res.code == 1){
                    return true;
                }
          })
        }
    },
    //提交表单
    async submitForm(formName, fromExtend) {
      let image_urls; //图片整合
      if (this.flie_list.length > 0) {
        let imglist = [];
        this.flie_list.forEach((el) => {
          imglist.push(el.url);
        });
        image_urls = imglist.join(",");
      }
      //库存信息
      if (this.Stockinfo[0].inStock == "默认") {
        this.stock_status = true;
      }

      let formNamecode = false;
      this.purchasePrice_status = true;
      this.retailPrice_status = true;
      this.platformPrice_status = true;
      this.compareatPrice_status = true;

      //基本信息验证
      await this.$refs[formName].validate((valid) => {
        if (valid) {
          if (this.rules_purchasePrice) {
            this.basic_status = true;
            return shoElmessage("el-icon-warning", "请输入采购价", "error");
          }
          if (this.rules_retailPrice) {
            this.basic_status = true;
            return shoElmessage("el-icon-warning", "请输入零售价", "error");
          }
          if (this.rules_platformPrice) {
            this.basic_status = true;
            return shoElmessage("el-icon-warning", "请输入平台价", "error");
          }
          if (this.rules_compareatPrice) {
            this.basic_status = true;
            return shoElmessage("el-icon-warning", "请输入原价", "error");
          }
          this.basic_status = false;
          formNamecode = true;
        } else {
          this.basic_status = true;
          return false;
        }
      });

      if (!formNamecode) return false;
      //扩展信息验证
      await this.$refs[fromExtend].validate((valid) => {
        if (valid) {
          console.log(2);
        } else {
          return false;
        }
      });
      //所有商品的参数
      let onlinelist = {};
      if (this.addOnline.length != 0 && this.addOnline.length == 1) {
        onlinelist = Object.assign(
          this.addOnline[0].proSize,
          this.addOnline[0].packSize
        );
        onlinelist.weight = this.addOnline[0].proWeigh;
        onlinelist.package_weight = this.addOnline[0].package_weight;
        onlinelist.cost = this.addOnline[0].purchasePrice; //采购价
        onlinelist.compare_at_price = this.addOnline[0].compare_at_price; //零售价
        onlinelist.market_price = this.addOnline[0].platformPrice; //平台价
        onlinelist.retail_price = this.addOnline[0].retailPrice;
        onlinelist.encoding = this.addOnline[0].code; //条码
      }
      if (formNamecode && !this.stock_status) {
        AddingProduct({
          company_id: this.$store.state.userinfo.userinfo.company_id, //必
          brand_id: this.ruleForm.brand, //必
          title: this.ruleForm.name, //必
          description: "",
          // sku:this.ruleForm.proSku, //sku
          // inventory_sku:this.ruleForm.stockSku, //库存sku
          barcode:this.ruleForm.barcode, //序列号
          status:this.ruleForm.status, //状态:0=active销售中,1=archived已下架,2=draft未上架,3=采购中
          category_id:this.ruleForm.category, //分类id
          supplier_id:this.ruleForm.supplier, //供应商id
          description:this.ruleForm.description,//备注
          shop_id:this.ruleForm.shop_id,
          // cost:this.addOnline[0].purchasePrice, //采购价
          // compare_at_price:this.addOnline[0].retailPrice, //零售价
          // market_price:this.addOnline[0].platformPrice, //平台价
          // encoding:this.addOnline[0].code, //条码
          
          image_urls:image_urls, //图片地址，多个以,隔开
          // delete_image_ids:"",

          // tag_ids:'', //标签ids，多个以,隔开
          
          // weight:'', //重量
          // height:'', //高
          // width:'', //宽
          // length:'', //长

          // package_weight:'', //包装重量
          // package_height:'', //包装高
          // package_width:'', //包装宽
          // package_length:'', //包装长

          ...onlinelist,
          hs_name: "", //海关名称
          hs_code: "", //海关代码
        }).then((res) => {
          if (res.code == 1) {
            GetProductDetail({ product_id: res.data.product_id }).then(
              (res) => {
                if (res.code == 1) {
                  this.OperateInventoryLog(res.data.data.inventory_sku).then(
                    (res) => {
                      shoElmessage(true, "添加成功");
                      this.Close("dialog_visible");
                    }
                  );
                }
              }
            );
          } else {
            shoElmessage("el-icon-warning", res.msg, "error");
          }
        });
      }
    },
    resetForm(formName) {
      // console.log(this.$refs[formName])
      this.$refs[formName].resetFields();
    },
    addRow(item) {
      //基本信息规格
      if (item == "基本信息") {
        var list = {
          rowNum: this.rowNum,
          code: "",
          proWeigh: "",
          proSize: { length: "", width: "", height: "" },
          package_weight: "",
          packSize: {
            package_length: "",
            package_width: "",
            package_height: "",
          },
          purchasePrice: "",
          retailPrice: "",
          platformPrice: "",
          compare_at_price: "",
          inStock: "",
        };
        this.addOnline.push(list);
      } else {
        let stocklist = {
          inStock: "",
          purchasePrice: "",
          platformPrice: "",
          retailPrice: "",
        };
        this.Stockinfo.push(stocklist);
      }

      this.rowNum += 1;
    },
    Init() {
      this.activeName = "first";
      //基本信息
      this.addOnline = [
        {
          code: "",
          proWeigh: "",
          proSize: { length: "", width: "", height: "" },
          package_weight: "",
          packSize: {
            package_length: "",
            package_width: "",
            package_height: "",
          },
          purchasePrice: "",
          retailPrice: "",
          platformPrice: "",
          inStock: "",
        },
      ];
      //库存信息
      this.Stockinfo = [
        {
          inStock: "默认",
          purchasePrice: 10,
          platformPrice: 10,
          retailPrice: 10,
        },
      ];
      //扩展信息额外参数
      this.extra = [
        {
          name: "",
          value: "",
        },
        {
          name: "",
          value: "",
        },
      ];
      //基本信息
      this.ruleForm = {
        name: "",
        category: "",
        brand: "",
        supplier: "",
        proSku: "",
        stockSku: "",
        barcode: "",
        status: "",
        description: "",
      };
      //扩展信息
      this.ruleForm_extend = {
        material: "",
        use: "",
        customsDeclaration: "",
        customsCode: "",
      };
      //上传文件列表
      this.flie_list = [];

      //基本信息校验
      this.basic_status = false;
      //库存信息校验
      this.stock_status = false;

      //输入框初始化
      this.purchasePrice_status = false;
      this.retailPrice_status = false;
      this.platformPrice_status = false;
      this.compareatPrice_status = false;
      //初始化弹出框
      this.isFullscreen = false;
    },
    //删除标签
    delData(index, item) {
      item.splice(index, 1);
    },
    //关闭dialog
    Close(item) {
      this.isFullscreen = false;
      this.$emit("Close", { item: item, dialog_visible: this.dialog_visible });
    },
    //放大弹出框
    Screen() {
      this.isFullscreen = !this.isFullscreen;
    },
    Addextra() {
      this.extra.push({
        name: "",
        value: "",
      });
    },
    Dleteextra(index) {
      this.extra.splice(index, 1);
    },
    ToggleExtra() {
      this.extra_status = !this.extra_status;
    },
  },
};
</script>
<style lang="scss" scoped>
// 弹窗样式
.el-dialog {
  .baseInfo {
    .el-form {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      .colForm {
        width: 300px;
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

.textarea {
  margin-top: 20px;
}
.pic_upload-demo {
  :deep(.el-upload) {
    width: 100%;
    height: 170px;
    .el-upload-dragger {
      width: 100%;
      height: 100%;
      line-height: normal;
    }
  }
}
:deep(.el-tabs__content) {
  max-height: 70vh;
  overflow: auto;
}
.Addmore {
  color: #409eff;
  cursor: pointer;
}
.additional {
  display: flex;
  justify-content: flex-end;
}
.extra_button {
  padding: 0px 10px;
}

//滑动模块
.draggable_list {
  .el-upload-list--picture-card .el-upload-list__item-actions {
    cursor: pointer;
  }
  .el-upload-list__item-thumbnail {
    animation: Upload 0.5s;
  }
}
//采购所有
.purchasePrice.is_active {
  :deep(.el-input__inner) {
    border-color: var(--el-color-danger);
  }
  .el-form-item__error {
    position: relative;
    height: 17px;
    transition: height 0.5s;
    width: 100%;
  }
}
.purchasePrice_title {
  display: flex;
  text-align: center;
  &::before {
    content: "*";
    color: var(--el-color-danger);
  }
}
//备注标题
.textarea_title {
  padding: 10px 0px;
}
@keyframes Upload {
  0% {
    height: 0px;
    opacity: 0;
  }
  100% {
    height: 148px;
    opacity: 1;
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
.enlarge_img {
  .el-dialog__body {
    max-height: 90vh;
    overflow: auto;
  }
}
.popover_img--list {
  width: auto !important;
}
.popover_img--list img {
  padding: 10px;
  width: 200px;
  height: 200px;
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
.el-textarea__inner {
  height: 100%;
}

.addOnline_title {
  color: #e6a23c;
  margin-bottom: 20px;
  i {
    margin-right: 10px;
  }
}
</style>
