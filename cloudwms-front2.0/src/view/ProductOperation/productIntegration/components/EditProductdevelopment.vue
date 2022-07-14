<template>
  <!-- 商品分类页面 -->
  <vite-dialog v-model="addProint_dialog" destroy-on-close   width="80%" top="20px"  title="新增产品研发"  :show-close="false" @ViteClose="Close('dialog_visible')"  :lock-scroll="false" >
  <!-- <el-dialog v-model="addProint_dialog" destroy-on-close   width="80%" top="20px"  :title="title" :fullscreen="isFullscreen" :show-close="false" custom-class="productdevelopment"  :lock-scroll="false" >
    <template #title>
      <div class="el-dialog_title">
        <div class="title">编辑产品</div>
        <div class="icon_list">
          <div class="screenfull" @click="Screen" >
                <svg  class="screen-out"   width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M33 6H42V15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M42 33V42H33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M15 42H6V33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M6 15V6H15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
          </div>
          <i class="el-icon-close" @click="Close('dialog_visible')"></i>
        </div>
      </div>
    </template> -->
        <!-- 表格 -->
      <el-tabs v-model="activeName" @tab-click="handleClick" >
        <el-tab-pane label="基本信息" name="first" class="baseInfo">
          <div class="table_backCol">
            <!-- 表格 -->
            <el-form ref="ruleFormRef" :model="ruleForm" label-width="150px" :rules="form_rules"> 
              <!-- <el-row> -->
              <div class="container">
              <el-form-item label="商品整合标题：" prop="title">
                <el-input v-model="ruleForm.title"> </el-input>
              </el-form-item>
                <el-form-item label="分组类型：" prop="tags_id">
                  <el-select v-model="ruleForm.tags_id" placeholder="请选择">
                    <el-option
                      v-for="item in Tag_list"
                      :key="item.id"
                      :label="item.name"
                      :value="item.id"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item prop="order_status">
                  <el-radio-group v-model="ruleForm.order_status">
                    <el-radio label="1">普通</el-radio>
                    <el-radio label="2">优先</el-radio>
                    <el-radio label="3">置顶</el-radio>
                  </el-radio-group>
                </el-form-item>
                <el-row>
                  <el-form-item label="发布时间：" prop="release_time">
                    <div class="block">
                      <el-date-picker
                        v-model="ruleForm.release_time"
                        type="date"
                        placeholder="选择日期"
                        format="YYYY/MM/DD"
                        value-format="x"
                      >
                      </el-date-picker>
                    </div>
                  </el-form-item>

                  <el-form-item label="提醒时间：" prop="notice_time">
                    <div class="block">
                      <el-date-picker
                        v-model="ruleForm.notice_time"
                        type="date"
                        placeholder="选择日期"
                        format="YYYY/MM/DD"
                        value-format="x"
                      >
                      </el-date-picker>
                    </div>
                  </el-form-item>
                </el-row>
                <!-- <el-row>
                  <el-form-item label="市场：" prop="market_ids">
                    <el-checkbox-group v-model="ruleForm.market_ids">
                        <el-checkbox label="US-1" name="type"></el-checkbox>
                        <el-checkbox label="US-2" name="type"></el-checkbox>
                    </el-checkbox-group>
                  </el-form-item>
                </el-row> -->
                <el-row>
                  <el-form-item label="负责人：" prop="company_user_ids">
                    <div class="block">
                      <el-select v-model="ruleForm.company_user_ids" placeholder="请选择">
                        <el-option
                          v-for="item in responsible_person_list"
                          :key="item.id"
                          :label="item.username"
                          :value="item.id"
                        >
                        </el-option>
                      </el-select>
                    </div>
                  </el-form-item>
                  <el-form-item label="供应商：" prop="supplier_id">
                    <div class="block">
                      <el-select v-model="ruleForm.supplier_id" placeholder="请选择">
                        <el-option
                          v-for="item in supplierlist"
                          :key="item.id"
                          :label="item.supplier_name"
                          :value="item.id"
                        >
                        </el-option>
                      </el-select>
                    </div>
                  </el-form-item>
                </el-row>
                <el-form-item label="品牌：" prop="brand_ids">
                    <div class="block">
                      <el-select v-model="ruleForm.brand_ids" placeholder="请选择">
                        <el-option
                          v-for="item in brand_list"
                          :key="item.id"
                          :label="item.name"
                          :value="item.id"
                        >
                        </el-option>
                      </el-select>
                    </div>
                </el-form-item>
                <!-- <el-row>
                  <el-form-item label="供应商：">
                    <div class="block">
                      <el-select v-model="form.supplier_id" placeholder="请选择">
                        <el-option
                          v-for="item in Product_type_list"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value"
                        >
                        </el-option>
                      </el-select>
                    </div>
                  </el-form-item>
                </el-row> -->
                
                <el-form-item label="商品整合描述：" prop="description">
                  <!-- <el-input  :autosize="{ minRows: 4}" type="textarea" v-model="ruleForm.description"></el-input> -->
                   <orderlistwang-editor
            :editor="ruleForm.description"
            @Change="editorChange"
            @Onfocus="Onfocus"
            @Onblur="Onblur"
          ></orderlistwang-editor>
                </el-form-item>
                <el-row>
                  <el-form-item label="状态：" prop="status">
                    <el-select v-model="ruleForm.status" placeholder="请选择">
                      <el-option
                        v-for="item in status_list"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"
                      >
                      </el-option>
                    </el-select> 
                  </el-form-item>
                </el-row>
                 <el-form-item>
                  <el-checkbox label="需要定制：" v-model="checked"></el-checkbox>
                </el-form-item>
              <!-- <el-form-item label="事务：">
                    <div class="block">
                      <el-select v-model="ruleForm.supplier_id" placeholder="请选择">
                        <el-option
                          v-for="item in Product_type_list"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value"
                        >
                        </el-option>
                      </el-select>
                    </div>
              </el-form-item> -->
              <!-- <el-form-item label="性质：">
                <span>选品计划</span>
                
              </el-form-item> -->
              
              <el-collapse-transition>
                <el-form-item label="采购需求：" v-show="checked" prop="purchase_notice">
                  <el-input type="textarea" v-model="ruleForm.purchase_notice"  :autosize="{ minRows: 5, maxRows: 6}"></el-input>
                </el-form-item>
              </el-collapse-transition>
              <!-- <el-form-item label="备注：">
                <el-input :autosize="{ minRows: 4}" type="textarea" v-model="ruleForm.mark"></el-input>
              </el-form-item> -->
              </div>
            </el-form>
          </div>
        </el-tab-pane>
        <!-- 选品计划 -->
         <el-tab-pane label="选品计划" name="selection" >
          <div class="competitives" v-if="competitives.length > 0">
                  <el-table :data="competitives" ref="table" :border="true">
                    <el-table-column
                      label="序号"
                      type="index"
                      width="60"
                      :align="'center'"
                    ></el-table-column>
                    <!-- <el-table-column label="竞争产品名称" :align="'center'">
                      <template #default="scope">
                        <el-input
                          class="product"
                          v-model="scope.row.name"
                        ></el-input>
                      </template>
                    </el-table-column> -->
                    <el-table-column label="竞争产品" :align="'center'">
                      <template #default="scope">
                        <el-input
                          class="product"
                          v-model="scope.row.url"
                        ></el-input>
                      </template>
                    </el-table-column>
                    <el-table-column label="价格" :align="'center'">
                      <template #default="scope">
                        <el-input
                          class="shopname"
                          v-model="scope.row.price"
                        ></el-input>
                      </template>
                    </el-table-column>
                    <el-table-column label="预览数" :align="'center'" width="150px">
                      <template #default="scope">
                        <el-input
                          class="shopname"
                          v-model="scope.row.reviews"
                        ></el-input>
                      </template>
                    </el-table-column>
                    <el-table-column
                      label="操作"
                      prop="operate"
                      size="small"
                      width="200px"
                      :align="'center'"
                      fixed="right"
                    >
                      <template v-slot="scope">
                        <div class="tableBtn">
                          <el-button type="primary" size="small" @click.prevent="addRow()" v-if="competitives.length < 5" >添加</el-button >
                          <el-button type="danger" size="small" @click="delData(scope.row,scope.$index)" :disabled="scope.$index === 0">删除</el-button>
                        </div>
                      </template>
                    </el-table-column>
                  </el-table>
                </div>
            <div v-else>
                <el-empty><el-button type="primary" size="small" @click.prevent="addRow()">添加竞品</el-button></el-empty>
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
                          <el-image style="width: 100%; height: 100%"  :src="element.fullurl" :preview-src-list="flie_list"></el-image>
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
      <template #footer class="el-dialog-footer">
        <el-button @click="Close('dialog_visible')">取消</el-button>
        <el-button @click="resetForm(ruleFormRef)">重置</el-button>
        <el-button type="primary" @click="submitForm(ruleFormRef)">确定</el-button>
      </template>
     </vite-dialog>
      <!-- 放大图片 -->
    <el-dialog v-model="Enlarge_Dialog" top="15px" height="80vh" fit="fill" custom-class="enlarge_img">
      <el-image :src="Enlarge_Dialog_IMG"></el-image>
    </el-dialog>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { reactive, toRefs ,ref} from 'vue';
import draggable from 'vuedraggable'
import {GetproductDetail,UpdateProductDevelopment} from '@/api/productDevelopmentList.js'
import { shoElmessage, shoElMessageBox } from '../../../../utils/Elmessage';
import { useStore } from 'vuex';
import { netConfig } from '../../../../config/net.config';
import { getAccessToken } from '@/utils/AccessToken'
import { isNaLL } from "../../../../utils/utils";
import OrderlistwangEditor from "../../../Shopfly/Orderlist/OrderlistwangEditor.vue";
export default {
  components: {
    Sidebar,
    draggable,
    OrderlistwangEditor
  },
  props:{
    addProint_dialog:{
      type:Boolean,
      default:false,
    },
    Product_type_list:{
      type:Array,
      default:[]
    },
    //市场列表
    market_list:{
      type:Array,
      default:[],
    },
    //负责人列表
    responsible_person_list:{
      type:Array,
      default:[],
    },
    //厂家
    factory_list:{
      type:Array,
      default:[]
    },
    //分组
    Tag_list:{
      type:Array,
      default:[]
    },
    supplierlist:{
      type:Array,
      default:[]
    },
    brand_list:{
      type:Array,
      default:[]
    }
  },
  setup(prop,content){
    const store = useStore();
    //表单校验
    const ruleFormRef = ref();
    const data  = reactive({
      //需定制
      checked:false,

      activeName:'first',
      ruleForm:{
        company_user_ids:"", //负责人id串
        tags_id:"",      //分类id
        market_ids:[],       //市场id串
        title:"",           //标题
        description:"",     //产品介绍
        order_status:"1",    //优先级:1=普通,2=优先,3=置顶
        status:"",          //状态:0=进行中,1=已完成

        transaction_id:"",  //事务id
        purchase_notice:"", //采购需求
        mark:"",            //备注
        notice_time:"",     //提醒时间
        release_time:"",    //发布时间
        supplier_id:"",     //供应商id
        image_urls:"",      //图片地址串
        brand_ids:"",//品牌id
      },
      competitives: [
        //  { url: "", price: "" ,reviews:"",name:""}
      ],
      status_list:[
        {value:0, label:"进行中"},
        {value:1, label:"已完成"},
      ],
      form_rules:{
        //标题
        title: [
          { required: true, message: '请输入标题', trigger: 'blur' },
          { min: 3, max: 10000, message: '最低长度3', trigger: 'blur' },
        ],
        //	分类id
        tags_id: [
          {
            required: false,
            message: '请选择分类',
            trigger: 'change',
          },
        ],
        // 市场id串
        // market_ids: [
        //   {
        //     type: 'array',
        //     required: true,
        //     message: '请选择市场',
        //     trigger: 'change',
        //   },
        // ],
        // 负责人id串
        // company_user_ids: [
        //   {
        //     required: true,
        //     message: '请选择负责人',
        //     trigger: 'change',
        //   },
        // ],
      },
      //上传参数
      flie_list:[],
      file_type:'.png,.jpg,.jpeg,.gif,.svg,.GIF,.JPEG,.PNG,.JPG,.SVG',//文件类型
      //上传图片url
      baseUrl:netConfig.baseURL,
      //上传文件额外参数
      headers:{
            token:getAccessToken(),
      }, 
      upload_satus:false,
      //放大
      isFullscreen:false,
      //放大图片弹框
      Enlarge_Dialog:false,
      //放大图片
      Enlarge_Dialog_IMG:"",
      //删除图片
      delete_image_ids:[],
      //删除竞品
      delete_competes_ids:[],
    })
    //初始化
    function Init(id){
      data.delete_image_ids = [];
      data.delete_competes_ids = [];
      data.ruleForm = {
        id:"",
        company_user_ids:"", //负责人id串
        tags_id:"",      //分类id
        market_ids:[],       //市场id串
        title:"",           //标题
        description:"",     //产品介绍
        order_status:"1",    //优先级:1=普通,2=优先,3=置顶
        status:"",          //状态:0=进行中,1=已完成

        transaction_id:"",  //事务id
        purchase_notice:"", //采购需求
        mark:"",            //备注
        notice_time:"",     //提醒时间
        release_time:"",    //发布时间
        supplier_id:"",     //供应商id
        image_urls:"",      //图片地址串
        brand_ids:"",//品牌id
      }
      if(isNaLL(id)){
        GetproductDetail({
          product_development_id:id
        }).then(res => {
          if(res.code == 1){
            let item = res.data.data
              data.ruleForm.id = item.id,
              data.ruleForm.company_user_ids= parseInt(item.company_user_ids), //负责人id串
              data.ruleForm.tags_id = parseInt(item.tags_id),     //分类id
              data.ruleForm.title = item.title,         //标题
              data.ruleForm.description = item.description,        //产品介绍
              data.ruleForm.order_status = item.order_status,       //优先级:1=普通,2=优先,3=置顶
              data.ruleForm.status = parseInt(item.status),             //状态:0=进行中,1=已完成

              data.ruleForm.transaction_id = parseInt(item.transaction_id),     //事务id
              data.ruleForm.purchase_notice = item.purchase_notice,    //采购需求
              data.ruleForm.mark = item.mark,              //备注
              data.ruleForm.notice_time = (Number(item.notice_time)*1000),        //提醒时间
              data.ruleForm.release_time = (Number(item.notice_time)*1000),       //发布时间
              data.ruleForm.supplier_id = parseInt(item.supplier_id),        //供应商id
              data.ruleForm.brand_ids = parseInt(item.brand_ids)
              data.flie_list = res.data.data.images.map(el =>{
                let item = {
                  src:el.src,
                  fullurl:el.src,
                  url:el.src,
                  ...el
                }
                return item
              })
              data.competitives = item.competitives
              //需要定制
              if(isNaLL(item.purchase_notice)){
                data.checked = true
              }
          }
        })
      }
      
    }
    //关闭dialog
    function Close(item){
      data.isFullscreen = false;
      content.emit('DialogClose',{item:item,addProint_dialog:prop.addProint_dialog});
    }
    //放大弹出框
    function Screen(){
      data.isFullscreen = !data.isFullscreen
    }
    function addRow() {
      let item  =  { url: "", price: "" ,reviews:"",name:""};
      data.competitives.push(item);
    }
    //提交表单
    function submitForm(formEl){
      //整合所有图片
      let imagelist = [];
        let doname = /^(http[s]?:\/\/)?([^\/]+)(.*)/;
        if(data.flie_list.length > 0){
            for(let i=0; i<data.flie_list.length;i++){
              if(!doname.test(data.flie_list[i].url)){
                imagelist.push(data.flie_list[i].url)
              }
            }
      }
      data.ruleForm.image_urls = imagelist.join(',');
      let competes = [];
      let add_competes = [];
      if(data.competitives.length > 0){
        data.competitives.some((el) =>{
          if(!isNaLL(el.id)){
            add_competes.push(el)
          }else{
            competes.push({
              url:el.url,
              price:el.price,
              reviews:el.reviews,
              competes_id:el.id
            })
          }
        })
      }
      formEl.validate((valid, fields) => {
          if (valid) {
            UpdateProductDevelopment({
              product_development_id:data.ruleForm.id,
              ...data.ruleForm,
              competes:JSON.stringify(competes),
              add_competes:JSON.stringify(add_competes),
              delete_image_ids:data.delete_image_ids.join(),
              delete_competes_ids:data.delete_competes_ids.join(),
            }).then(res =>{
              if(res.code  == 1){
                  shoElmessage(true,'修改成功')
                  Close()
              } 
            })
          } else {
            shoElmessage(true,'请输入完整信息','error')
          }
      })
    }
    //重置表单
    function resetForm(formEl){
      data.competitives = [];
      data.flie_list = []
      formEl.resetFields()
    }
    //上传图片拦截
    function BeforeUpload(file){
      const fileSuffix = file.name.substring(file.name.lastIndexOf(".") + 1);
      const filelist = data.file_type.split(',');
      if(filelist.indexOf(`.${fileSuffix}`) == -1){
          shoElmessage('el-icon-warning','请选择正常文件格式','error') 
          return false
      }
    }
    //删除图片响应
    function onRemove(removeitem){
      console.log(removeitem)
    }
    //图片上传成功
    function OnSuccess(res){
      data.upload_satus = true
      if(res.code == 1){
        data.flie_list.push(res.data)
      }
    }
    //图片上传图片回调
    function UploadChange(res){
      if(res.response != undefined){
        if(res.response.code == 0){
            shoElmessage('el-icon-warning',res.response.msg,'error')
        }else{
            shoElmessage('success','上传成功','success')
        }
      }
    }
    //删除图片
    function DELETE_IMG(item){
        if(isNaLL(item.id)){
          data.delete_image_ids.push(item.id)
        }
        let index = data.flie_list.indexOf(item)
        data.flie_list.splice(index,1);
        
    }
    //放大图片
    function Enlarge_IMG(item){
      data.Enlarge_Dialog = true
      data.Enlarge_Dialog_IMG = item.fullurl
    }
    //删除
    function delData(item,index){
      if(isNaLL(item.id)){
          data.delete_competes_ids.push(item.id)
        }
      data.competitives.splice(index,1)
    }
    return {
      Close,
      Screen,
      ...toRefs(data),
      Init,
      addRow,
      submitForm,
      resetForm,
      ruleFormRef,
      BeforeUpload,
      onRemove,
      OnSuccess,
      UploadChange,
      DELETE_IMG,
      Enlarge_IMG,
      delData
    }
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

//顶部banner
// 文字链接
.el-header {
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
  padding: 0px;
  color: #000;
}
.table_backCol {
  background-color: #fff;
  border-radius: 2px;
  // padding: 12px;
  .el-form {
    .el-input,
    .el-textarea {
      max-width: 700px;
    }
    .container {
      margin: 0px 11%;
    }
  }
}

//弹出框标题
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
</style>
<style lang="scss">
.productdevelopment{
  .el-dialog__header{

    border-bottom: 1px solid #eee;
  }
  .el-dialog__body{
    padding: 20px;
  }
  .el-dialog__footer{
    border-top: 1px solid #eee;
  }
}
</style>