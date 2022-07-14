<template>
  <vite-dialog v-model="dialog_visible"  top="20px" title="新增" @ViteClose="Close('新增')">
        <el-tabs v-model="diasActiveName" @tab-click="handleClick" >
          <el-tab-pane label="基本信息" name="first" class="baseInfo">
            <div class="search_list">
              <div class="label">产品：</div>
              <div class="search_list--input" style="max-width:700px;min-width:500px;">
                <el-input placeholder="输入商品名称" v-model="item.title">
                  <template #append>
                    <el-button type="primary" icon="el-icon-search" @click="SearchProductlistBtn"></el-button>
                  </template>
                </el-input>
              </div>
            </div>
            <div class="search_list">
              <div class="label">Title：</div>
              <div style="max-width:700px;min-width:500px;">
                <el-input placeholder="请选择"  v-model="titleBase"></el-input>
              </div>
            </div>
            
            <div class="table_list">
              <div class="table_list--title">商品信息：</div>
              <el-table
                ref="multipleTable"
                :data="selectTable"
                tooltip-effect="dark"
                style="width: 100%"
                @select="handSelect"
                @select-all="handleSelectionAll"
                :expand-row-keys="expands" 
                :row-key="getRowKeys"
                :border="true"
                >
                  <el-table-column
                    prop="inventory_sku"
                    label="SKU"
                    show-overflow-tooltip
                    >
                  </el-table-column>
                  <el-table-column
                    prop="barcode"
                    label="条码"
                    >
                  </el-table-column>
                  <el-table-column
                    prop="title"
                    label="名称"
                    show-overflow-tooltip
                    >
                  </el-table-column>
                  <el-table-column
                    prop="category_name"
                    label="类别"
                    show-overflow-tooltip>
                  </el-table-column>
                  <el-table-column
                    label="规格"
                    show-overflow-tooltip>
                      <template #default="scope">
                        <span  class="proSize size" >{{scope.row.width}}</span>
                        <span class="proSize size">*{{scope.row.height}}*</span> 
                        <span class="proSize size">{{scope.row.length}}</span>
                      </template>      
                  </el-table-column>
                  <el-table-column
                      label="详情"
                      type="expand"
                    >
                    <template #default="scope">
            
                  <div class="expand_props_list">
                  <div class="expand_stock_list">
                    <div class="expand_stock_list--title">商品图片：</div>
                    <draggable 
                        class="draggable_list flex flex-wrap"
                        v-model="expand_list.images"
                        @start="drag = true"
                        @end="drag = false"
                        item-key="id"
                        :animation="1000"
                        @change="onMoveCallback"
                        :forceFallback="true"
                      >
                      <template #item="{ element }">
                          <div class="pic_upload-demo">
                            <ul class="el-upload-list expand-upload-list--picture-card">
                                <li class="expand-upload-list__item is-success">
                                  <el-image style="width: 100%; height: 100%"  :src="element.src" :preview-src-list="scope.row.srcList"></el-image>
                                </li>
                            </ul>
                          </div>
                      </template>
                      </draggable>
                    </div>
                    <div class="expand_stock_list">
                      <div class="expand_stock_list--title">基本信息：</div>
                      <el-descriptions 
                        class="margin-top"
                        :column="3"
                        :size="size"
                        border
                        >
                        <el-descriptions-item  label="商品名称">{{expand_list.title}}</el-descriptions-item>
                        <el-descriptions-item label="商品SKU">{{expand_list.sku}}</el-descriptions-item>
                        <el-descriptions-item label="库存SKU">{{expand_list.inventory_sku}}</el-descriptions-item>
                        <el-descriptions-item label="原价">{{expand_list.compare_at_price}}</el-descriptions-item>
                        <el-descriptions-item label="成本价">{{expand_list.cost}}</el-descriptions-item>
                        <el-descriptions-item label="市场价">{{expand_list.market_price}}</el-descriptions-item>
                        <el-descriptions-item label="零售价">{{expand_list.retail_price}}</el-descriptions-item>
                        <el-descriptions-item label="品牌名称">{{expand_list.brand_name}}</el-descriptions-item>
                        <el-descriptions-item label="序列号">{{expand_list.encoding}}</el-descriptions-item>
                        <el-descriptions-item label="商品类型">{{expand_list.category_name}}</el-descriptions-item>
                        <el-descriptions-item label="供应商">{{expand_list.supplier_id}}</el-descriptions-item>
                        <el-descriptions-item label="创建时间">{{expand_list.create_time}}</el-descriptions-item>
                        <el-descriptions-item label="商品状态">
                          <el-tag :type="expand_list.status == 0?'success':expand_list.status == 1?'info':expand_list.status == 2?'warning':''">
                              {{expand_list.status == 0?'销售中':expand_list.status == 1?'已下架':expand_list.status == 2?'未上架':'采购中'}}
                          </el-tag>
                        </el-descriptions-item>
                        <!-- <el-descriptions-item span="3" label="描述">{{expand_list.description}}</el-descriptions-item> -->
                      </el-descriptions>
                    </div>  
                    <div class="expand_stock_list">
                      <div class="expand_stock_list--title">创库列表：</div>
                      <el-table border :data="expand_list.inventory">
                        <el-table-column label="Id" prop="id"></el-table-column>
                        <el-table-column label="创库名称" prop="name"></el-table-column>
                        <el-table-column label="初期库存数" prop="stock"></el-table-column>
                        <el-table-column label="最低安全库存数" prop="stock_minimum"></el-table-column>
                        <el-table-column label="最高安全库存数" prop="stock_highest"></el-table-column>
                      </el-table>
                    </div>
                    <div class="expand_stock_list">
                      <div class="expand_stock_list--title">商品规格列表：</div>
                      <el-table border>
                        <el-table-column label="Id"></el-table-column>
                        <el-table-column label="条码"></el-table-column>
                        <el-table-column label="采购价"></el-table-column>
                        <el-table-column label="零售价"></el-table-column>
                        <el-table-column label="平台价"></el-table-column>
                        <el-table-column label="商品重量"></el-table-column>
                        <el-table-column label="商品规格"></el-table-column>
                        <el-table-column label="包装重量"></el-table-column>
                        <el-table-column label="包装规格"></el-table-column>
                      </el-table>
                    </div>
                    <div class="expand_stock_list">
                      <div class="expand_stock_list_description">
                      <div class="expand_stock_list_description--title">描述：</div>
                      <div class="expand_stock_list_description--content">
                        {{expand_list.description}}
                      </div>
                    </div>
                    </div>
                    </div>
                    </template>
                  </el-table-column>
                </el-table>
            </div>
          </el-tab-pane>
          <el-tab-pane label="商品资料" name="second">
            <div class="productInfo ">
              <el-form :label-position="labelPosition" v-model="bullet" ref="bullet" :rules="rules_basic" label-width="120px" :model="bullet">
              <el-form-item label="Title：" prop="title">
                <el-input v-model="bullet.title" ></el-input>
              </el-form-item>
                <el-form-item label="Bullet_Point1：">
                  <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="请输入内容"
                    v-model="bullet.bullet_point1">
                </el-input>
                </el-form-item>
                <el-form-item label="Bullet_Point2：">
                  <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="请输入内容"
                    v-model="bullet.bullet_point2"></el-input>
                </el-form-item>
                <el-form-item label="Bullet_Point3：">
                  <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="请输入内容"
                    v-model="bullet.bullet_point3"></el-input>
                </el-form-item>
                <el-form-item label="Bullet_Point4：">
                  <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="请输入内容"
                    v-model="bullet.bullet_point4"></el-input>
                </el-form-item>
                <el-form-item label="Bullet_Point5：">
                  <el-input
                    type="textarea"
                    :rows="2"
                    placeholder="请输入内容"
                    v-model="bullet.bullet_point5"></el-input>
                </el-form-item>
                <el-form-item label="Description：">
                  <!-- <el-input
                    type="textarea"
                    :rows="5"
                    placeholder="请输入内容"
                    v-model="bullet.description"></el-input> -->
                    <orderlistwang-editor
                :editor="bullet.description"
                @Change="editorChange"
                @Onfocus="Onfocus"
                @Onblur="Onblur"
              ></orderlistwang-editor>
                </el-form-item>
                <el-form-item>
                  <div class="Addmore" @click="ToggleExtra">
                    <i class="el-icon-plus"></i>
                    展开更多
                  </div>
                </el-form-item>
                <div class="exrea" v-show="extra_status">
                  <el-form-item v-for="(item,index) in extra" :key="index">
                    <template #label>
                      <div class="additional">
                        <el-input
                          v-model="item.name"
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
                        <el-button type="primary"  size="mini" @click="Addextra()">添加</el-button>
                        <el-button type="danger"  size="mini" @click="Dleteextra(index)">删除</el-button>
                      </div>
                    </div>
                  </el-form-item>
                </div>
              </el-form>
            </div>
          </el-tab-pane>
          <el-tab-pane label="图片信息" name="third">
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
                          <el-image style="width: 100%; height: 100%"  :src="element.src" :preview-src-list="flie_list"></el-image>
                          <!-- <img class="el-upload-list__item-thumbnail" :src="element.fullurl"> -->
                          <label class="el-upload-list__item-status-label"><i class="el-icon-upload-success el-icon-check"></i></label>
                          <i class="el-icon-close"></i>
                          <i class="el-icon-close-tip">{{element.id}}</i>
                          <span class="el-upload-list__item-actions">
                            <span class="el-upload-list__item-preview" @click="Enlarge_IMG(element)">
                              <i class="el-icon-zoom-in"></i>
                            </span>
                            <span class="el-upload-list__item-delete" @click="DELETE_IMG(element)">
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
                    list-type='picture-card'
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
        <template #footer class="dialog-footer">
          <el-button @click="editVisi = false">重置</el-button>
          <el-button type="primary" @click="resetForm('bullet')">确定</el-button>
        </template>
      </vite-dialog>
      <!-- 搜索商品 -->
      <el-dialog v-model="product_dialog_visible" width="70%" top="15px" :title="title" custom-class="ecominfomanag_dialog"  :fullscreen="isFullscreen" :show-close="false">
          <template #title>
            <div class="el-dialog_title">
              <div class="title">商品列表</div>
              <div class="icon_list">
                <div class="screenfull" @click="Screen" >
                      <svg  class="screen-out"   width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M33 6H42V15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M42 33V42H33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M15 42H6V33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M6 15V6H15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                </div>
                <i class="el-icon-close" @click="ProductlistClose"></i>
              </div>
            </div>
            </template>
          <div class="tab">
            <div class="search_list">
              <div class="label">商品：</div>
              <el-input placeholder="请选择" v-model="item.title" @blur="SelctChange"></el-input>
            </div>
            <div class="search_list">
              <div class="label">商品类型：</div>
              <el-select v-model="item.category_id" clearable placeholder="请选择" @change="SelctChange">
                <el-option
                  v-for="item in Product_type_list"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </div>
          <div class="search_list">
            <div class="label">仓库：</div>
            <el-select v-model="item.warehouse_id" clearable placeholder="请选择" @change="SelctChange">
              <el-option
                v-for="item in warehouse_list"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              >
              </el-option>
            </el-select>
          </div>
        </div>
        <!-- 表格 -->
        <div>商品列表：</div>
        <el-table
          ref="multipleTable"
          :data="SearchTable"
          tooltip-effect="dark"
          style="width: 100%"
          @select="handSelect"
          :default-expand-all="true"
          @select-all="handleSelectionAll">
            <el-table-column
              type="selection"
              width="55">
            </el-table-column>
            <el-table-column
              prop="inventory_sku"
              label="SKU"
              show-overflow-tooltip
              >
            </el-table-column>
            <!-- <el-table-column
              prop="sku"
              label="仓库SKU"
              show-overflow-tooltip
              >
            </el-table-column> -->
            <el-table-column
              prop="barcode"
              label="条码"
              >
            </el-table-column>
            <el-table-column
              prop="title"
              label="名称"
              show-overflow-tooltip
              >
            </el-table-column>
            <el-table-column
              prop="category_name"
              label="类别"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              label="规格"
              show-overflow-tooltip>
                <template #default="scope">
                  <span  class="proSize size" >{{scope.row.width}}</span>
                  <span class="proSize size">*{{scope.row.height}}*</span> 
                  <span class="proSize size">{{scope.row.length}}</span>
                </template>      
            </el-table-column>
          </el-table>
          <div class="pagination-list">
            <el-pagination
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
              :current-page="querInfo.pagenum"
              :page-sizes="[3, 5, 8, 10]"
              :page-size="querInfo.pagesize"
              layout="total, sizes, prev, pager, next, jumper"
              :total="this.tableData.length"
            >
            </el-pagination>
          </div>
          <template v-slot:footer>
            <span s class="dialog-footer">
              <el-button @click="product_dialog_visible = false">取 消</el-button>
              <el-button type="primary" @click="SubMethod()">确 定</el-button>
            </span>
          </template>
      </el-dialog>
      <!-- 放大图片 -->
      <el-dialog v-model="Enlarge_Dialog" top="15px" height="80vh" fit="fill" custom-class="enlarge_img">
        <el-image :src="baseUrl + Enlarge_Dialog_IMG"></el-image>
      </el-dialog>
</template>
<script>
import { GetProductList } from "@/api/Porductapi";
import { GetwarehouseList } from "@/api/warehouseList";
import {GetProductCategoryList,GetProductDetail} from '@/api/Addproduct'
import { netConfig } from '../../../../config/net.config';
import draggable from 'vuedraggable'
import { isNaLL } from "../../../../utils/utils";
import { shoElmessage } from '../../../../utils/Elmessage';
import { AddAmzonProduct } from '@/api/AmazonProduct';
import { getAccessToken } from '@/utils/AccessToken';
import OrderlistwangEditor from "../../../Shopfly/Orderlist/OrderlistwangEditor.vue";
export default {
  components:{
    draggable,
    OrderlistwangEditor
  },
  name:'AddEcominfoManag',
  props: {
    editList:{
      type:Object,
      default:{}
    },
    //弹出框状态
    dialog_visible:{
      type:Boolean,
      default:false,
    }
  },
  data() {
    return {
      //上传图片url
      baseUrl:netConfig.baseURL,
      //上传文件额外参数
      headers:{
            token:getAccessToken(),
      }, 
      upload_satus:true,//图片状态
      //查找商品列表
      item:{
        category_id:'',//分类id
        title:'', //搜索商品
        warehouse_id:'',//仓库id
      },
      product_dialog_visible:false,

      isFullscreen:false, //放大弹出框

      selectTable:[],//选中的商品
      SearchTable:[],//搜索商品
      expandTable:[],//暂缓商品

      Product_type_list:[],//商品分类
      warehouse_list:[],//库存列表

      expand_list:[],//商品详情
      flie_list:[],//图片修改
      //放大图片
      Enlarge_Dialog:false,
      Enlarge_Dialog_IMG:"",



      labelPosition: 'right',
      diasActiveName:'first',
      tableData: [],

      //基本信息校验参
      rules_basic:{
        title: [
          { required: true, message: "请输入商品名称", trigger: "blur" },
          { min: 3, max: 30, message: "长度在 3 到 5 个字符", trigger: "blur" },
        ]
      },
      
      titleBase:'',

      querInfo: {
          type: 2,
          pagenum: 1,
          pagesize: 3,
      },

      extra_status:false,
      //附加参数
      extra:[
              {
                name:"",
                value:""
              },{
                name:"",
                value:""
              }
      ],
      bullet:{
        product_id:"",
        title:'',
        description:"",
        bullet_point1:"",
        bullet_point2:"",
        bullet_point3:"",
        bullet_point4:"",
        bullet_point5:"",
        image_urls:""
      },

      //折叠展开
      getRowKeys(row){
        return row.id
      },
      //选中展开
      expands:[],
    };
  },
  mounted(){
    this.GetProducttypelist();
    this.Getwarehouse_List();
  },
  methods: {
      //查看详情
      expandChange(row,expandedRows){
        this.expands = []
        if (expandedRows.length > 0) {
            row ? this.expands.push(row.id) : ''
        }
      },
      //放大图片
      Enlarge_IMG(item){
        this.Enlarge_Dialog = true
        this.Enlarge_Dialog_IMG = item.src
      },
      //删除图片
      DELETE_IMG(item){
          let index = this.flie_list.indexOf(item)
          this.flie_list.splice(index,1);
      },
      //删除图片响应
      onRemove(removeitem){
        console.log(removeitem)
      },
      //图片上传成功
      OnSuccess(res){
        this.upload_satus = true
        let item = {
          src:res.data.fullurl,
          ...res.data
        }
        if(res.code == 1){
          this.flie_list.push(item)
        }
      },
      //图片上传图片回调
      UploadChange(res){
        if(res.response != undefined){
          if(res.response.code == 0){
              shoElmessage('el-icon-warning',res.response.msg,'error')
          }else{
              shoElmessage('success','上传成功','success')
          }
        }
      },
      onMoveCallback(item){
        console.log(item)
      },
      //商品
      SubMethod(){
        this.selectTable = [];
        this.selectTable.push(this.expandTable[0])
        this.product_dialog_visible = false
        GetProductDetail({
            product_id:this.expandTable[0].id
        }).then(res =>{
          if(res.code == 1){
              this.expand_list = res.data.data
              this.titleBase = this.expand_list.title
              this.flie_list = this.expand_list.images
              this.bullet.product_id = this.expand_list.id
              this.$nextTick(() =>{
                this.expands.push(this.selectTable[0].id)
              })
          }
        })
      },
      //全选择商品
      handleSelectionAll(item){
        this.expandTable = item
      },
      //选择商品
      handSelect(item){
        this.expandTable.push(item[0])
      },
      //输入框搜索
      SelctChange(){
        this.Getlist();
      },
      //获取商品类型
      GetProducttypelist(){
        GetProductCategoryList({
          company_id:this.$store.state.userinfo.userinfo.company_id,
        }).then(res =>{
            if(res.code == 1){
              this.Product_type_list = res.data.data
            }
        })
      },
      //获取库存sku列表
      Getwarehouse_List(){
        GetwarehouseList({
          company_id:this.$store.state.userinfo.userinfo.company_id,
        }).then(res =>{
          console.log(res)
          if(res.code == 1){
              this.warehouse_list = res.data.data
          }
        })
      },
      //放大弹出框
      Screen(){
        this.isFullscreen = !this.isFullscreen
      },
      SearchProductlistBtn(){
        this.expandTable = [];
        this.product_dialog_visible = !this.product_dialog_visible
        
        // if(!isNaLL(this.title)){
        //   return shoElmessage(true,'请输入商品名称','error')
        // }
        this.Getlist();
      },
      //获取商品列表
      Getlist() {
        GetProductList({
          company_id:this.$store.state.userinfo.userinfo.company_id, //必
          ...this.item
        }).then(res =>{
            if(res.code == 1){
                this.SearchTable = res.data.data
            }
        })
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
      //添加商品
      resetForm(fromExtend){
        //图片处理
        let imagelist = [];
        let doname = /^(http[s]?:\/\/)?([^\/]+)(.*)/;
        if(this.flie_list.length > 0){
            for(let i=0; i<this.flie_list.length;i++){
              if(!doname.test(this.flie_list[i].url)){
                imagelist.push(this.flie_list[i].url)
              }
              // url = url.replace(/^http:\/\/[^/]+/, "");
            }
        }
        this.bullet.image_urls = imagelist.join(',');
        if(!isNaLL(this.bullet.product_id)){
          return shoElmessage(true,'请你选择商品','warning')
        }
        this.$refs[fromExtend].validate((valid) => {
          if (valid) {
              AddAmzonProduct({
                ...this.bullet
              }).then(res =>{
                  if(res.code == 1){
                    shoElmessage(true,'添加成功')
                    this.Close('新增')
                  }else{
                    shoElmessage(true,'添加失败','error')
                  }
              })
          } else {
            return shoElmessage(true,'请输入标题','warning')
          }
        });
      },
      Addextra(){
        this.extra.push({
          name:"",value:""
        })
      },
      Dleteextra(index){
        this.extra.splice(index,1);
      },
      ToggleExtra(){
        this.extra_status = !this.extra_status
      },
      Close(item){
        this.$emit('Close',{title:item})
      },
      ProductlistClose(){
        this.product_dialog_visible = !this.product_dialog_visible
      }
    }
};
</script>
<style lang="scss" scoped>
.table_list--title{
  margin-bottom: 10px;
}
.search_list{
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 10px;
  .label{
    width: 100%;
    flex: 0 0 auto;
    padding: 0 12px 0 0;
    box-sizing: border-box;
    padding-bottom: 10px;
    font-weight: bold;
  }
}

.pagination-list {
  padding: 20px;
  text-align: right;
}
.el-dialog_title{
  width: 100%;
  display: flex;
  justify-content: space-between;
  font-size: 18px;
  cursor: pointer;
  .icon_list{
    display: flex;
    align-items: center;
    .screenfull{
      padding: 0px 10px;
      display: flex;
      align-items: center;
    }
    i{
      font-size: 20px;
      color: #000;
      font-weight: bold;
    }
  }
}
//商品资料tab
.extra_button{
  padding: 0px 10px;
}
//图片信息
.pic_upload-demo{
  :deep(.el-upload){
    width: 100%;
    height: 170px;
    .el-upload-dragger{
        width: 100%;
        height: 100%;
        line-height:normal;
    }
  }
}
//详情
.expand_props_list{
  .expand_stock_list{
    background-color: #f0f2f5;
    padding: 10px;
    .expand_stock_list--title{
      padding: 10px 0px;
      font-weight: bold;
    }
  }
}
.expand_stock_list_description{
    background-color: #fff;
    padding: 20px;
    margin-top: 20px;
    .expand_stock_list_description--title{
      padding-bottom: 20px;
      font-weight: bold;
      word-spacing:5px;
    }
}
//图片
.pic_upload-demo{
  cursor: pointer;
}
.expand-upload-list__item{
  transition: all .5s cubic-bezier(.55,0,.1,1);
  font-size: 14px;
  color: var(--el-text-color-regular);
  line-height: 1.8;
  margin-top: 5px;
  position: relative;
  box-sizing: border-box;
  border-radius: 4px;
  width: 100%;
}
.expand-upload-list--picture-card .expand-upload-list__item{
    overflow: hidden;
    background-color: #fff;
    border: 1px solid #c0ccda;
    border-radius: 6px;
    box-sizing: border-box;
    width: 148px;
    height: 148px;
    margin: 0 8px 8px 0;
    display: inline-block;
}
//展开更多
.Addmore{
  cursor: pointer;
  color: #108cff;
}
</style>
<style lang="scss">
.ecominfomanag_dialog{
  .el-dialog__header{

    border-bottom: 1px solid #eee;
  }
  .el-dialog__body{
    padding: 20px;
    max-height: 80vh;
    overflow: auto;
    &::-webkit-scrollbar{
      width: 6px;
      height: 10px;
      }
        /*定义滚动条轨道 内阴影+圆角*/
      &::-webkit-scrollbar-track {
          box-shadow: inset 0 0 0px #f1f1f1;
          border-radius: 2px;
          background-color: #f1f1f1;
      }

      /*定义滑块 内阴影+圆角*/
      &::-webkit-scrollbar-thumb {
          border-radius: 2px;
          box-shadow: inset 0 0 0px #f1f1f1;
          background-color: #c1c1c1;
      }
  }
  .el-dialog__footer{
    border-top: 1px solid #eee;
  }
}
</style>