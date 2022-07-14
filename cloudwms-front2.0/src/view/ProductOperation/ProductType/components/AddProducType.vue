<template>
   <!-- 新增商品分类 -->
    <el-dialog
    :title="title"
    v-model="addproducypeeditVisi"
    width="50%"
    top="20px"
    :show-close="false"
    :fullscreen="isFullscreen"
    custom-class="dialog_Protype"
  >
  <template #title>
      <div class="el-dialog_title">
        <div class="title">{{title}}</div>
        <div class="icon_list">
          <div class="screenfull" @click="Screen" >
                <svg  class="screen-out"   width="18" height="18" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M33 6H42V15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M42 33V42H33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M15 42H6V33" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M6 15V6H15" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
          </div>
          <i class="el-icon-close" @click="DialogClose"></i>
        </div>
      </div>
    </template>
    <el-form ref="form" :model="editinfo" :rules="rules">
      <el-form-item label="分类名称：" label-width="18%" prop="name">
        <el-input style="max-width: 700px" v-model="editinfo.name"></el-input>
      </el-form-item>
      <el-form-item label="英文名称：" label-width="18%" prop="eng_name">
        <el-input style="max-width: 700px" v-model="editinfo.eng_name"></el-input>
      </el-form-item>
      <el-form-item label="是否有父类：" label-width="18%" prop="parent_id" v-if="!select_status">
          <!-- <el-select v-model="editinfo.parent_id"  placeholder="请选择" size="large" clearable>
            <el-option
              v-for="item in datalist"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            />
          </el-select> -->
          <el-cascader
          :options="datalist"
          :collapse-tags="true"
          :show-all-levels="false"
          :props="{ multiple: false, checkStrictly: true,value:'id',label:'name',emitPath:false }"
          v-model="editinfo.parent_id"
          clearable>
             <template #default="{ node, data }">
              <span>{{ data.name }}</span>
              <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>
            </template>
          </el-cascader>
          <!-- <el-select v-model="secondary"  placeholder="请选择" size="large" clearable style="margin-left:10px">
            <el-option
              v-for="item in datalist"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            />
          </el-select> -->
      </el-form-item>
      <!-- <el-form-item label="品牌链接：" label-width="18%" prop="url">
        <el-input style="max-width: 700px" v-model="editinfo.url"></el-input>
      </el-form-item> -->
      <!-- <el-form-item label="创建时间" label-width="18%" prop="create_time">
        <el-date-picker
      v-model="editinfo.create_time"
      type="date"
      placeholder="选择日期">
    </el-date-picker> -->
      <!-- </el-form-item> -->
      <el-form-item label="状态：" label-width="18%" prop="is_effective">
        <el-radio-group v-model="editinfo.is_effective" size="small">
        <el-radio  label="0" border>否</el-radio>
        <el-radio  label="1" border>是</el-radio> 
        </el-radio-group>
      </el-form-item>
      <el-form-item label="分类图片：" label-width="18%" prop="logo" >
         <div class="upload_list flex flex-wrap">
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
              class="product_type--upload"
              drag
              :action="baseUrl + '/api/common/upload'"
              :headers="headers"
              :on-remove="onRemove"
              :on-success="OnSuccess"
              :on-error="UploadError"
              :on-change="UploadChange"
              :before-upload="BeforeUpload"
                multiple
              :show-file-list="false"
              :accept="file_type"
              :limit="1"
              :file-list="flie_list"
              v-if="flie_list.length == 0"
            >
            <i class="el-icon-upload"></i>
              <div class="el-upload__text">
                  上传文件
              </div>
          </el-upload>
         </div>
      </el-form-item>
      <el-form-item label="描述：" label-width="18%" prop="seo_description">
        <orderlistwang-editor
            :editor="editinfo.seo_description"
            @Change="editorChange"
            @Onfocus="Onfocus"
            @Onblur="Onblur"
          ></orderlistwang-editor>
      </el-form-item>
      
    </el-form>
     <template #footer class="el-dialog-footer">
      <el-button @click="editVisi = false">重置</el-button>
      <el-button type="primary" @click="resetForm(btn_title)">确定</el-button>
      
    </template>
  </el-dialog>
    <!-- 放大图片 -->
  <el-dialog v-model="Enlarge_Dialog" top="15px" height="80vh" fit="fill" custom-class="enlarge_img">
    <el-image :src="Enlarge_Dialog_IMG"></el-image>
  </el-dialog>
</template>
<script>
import { onMounted, reactive, toRefs,ref } from 'vue'
import { getLocalTime, isNaLL } from '../../../../utils/utils'
import {GetProductCategoryList} from '@/api/Addproduct'
import { netConfig } from '@/config/net.config'
import { getAccessToken } from '@/utils/AccessToken'
import { shoElmessage } from '../../../../utils/Elmessage'
import draggable from 'vuedraggable'
import { AddproductCategory,UpdatePorductType,GetproductCategoryDetail } from '@/api/productCategory'
import { useStore } from 'vuex'
import OrderlistwangEditor from '../../../Shopfly/Orderlist/OrderlistwangEditor.vue'

export default {
  components: {
    draggable,
    OrderlistwangEditor
  },
  props:{
    addproducypeeditVisi:{
      type:Boolean,
      default:false,
    },
    datalist:{
      type:Array,
      default:[]
    }
  },
  setup(props,content){
    const form = ref(null);
    const data = reactive({
        // 弹框显示
        editVisi: false,
        // 弹框列表
        editinfo: {
          name:'',//名称
          eng_name:"",
          is_effective:"",//是否有效
          parent_id:"",//父类id
          img_url:"",//分类图片地址
          seo_description:""//描述
        },
        // 弹框标题
        title: "",
        // 弹框放大
        isFullscreen:false,
        btn_title:'',
        rules:{
          name: [
            { required: true, message: "请输入商品名称", trigger: "blur" },
            { min: 1, max: 30, message: "长度在 2 到 5 个字符", trigger: "blur" },
          ],
          eng_name: [
            { required: true, message: "请输入英文名称", trigger: "blur" },
            { pattern: /^[A-Za-z]+$/, message: "必须是英文", trigger: "blur" },
            { min: 1, max: 4, message: "最长4个字符", trigger: "blur" },
          ],
        },
        querInfo:{
          total:10,
          per_page_num:10,
          page_num:1,
          total:10,
        },
        baseUrl:netConfig.baseURL,
        headers:{
            token:getAccessToken(),
        }, 
        flie_list:[],
        file_type:'.png,.jpg,.jpeg,.gif,.svg,.GIF,.JPEG,.PNG,.JPG,.SVG',//文件类型
        upload_satus:false,//上传状态
        //放大图片
        Enlarge_Dialog:false,
        Enlarge_Dialog_IMG:'',

        title:"",

        select_status:false,
        obj:{}
    })
    const store = useStore();
    // 新增修改
    function resetForm(item){
        //图片
        let imglist =[]
        if(data.flie_list.length > 0 && data.upload_satus){
            data.flie_list.forEach(el =>{
                imglist.push(el.url)
            })
        }

        data.editinfo.img_url = imglist.length != 0? imglist.join():data.editinfo.img_url

        form.value.validate((vaild) =>{
          if(vaild){
            if(data.title != '新增' && data.title != '修改'){
              data.editinfo.parent_id = data.obj.id
            }
            if(data.title =='新增' || data.title != '修改'){
              AddproductCategory({
                company_id:store.state.userinfo.userinfo.company_id, //必
                ...data.editinfo
              }).then(res =>{
                if(res.code == 1){
                  shoElmessage(true,'新增成功')
                  DialogClose();
                  InitData()
                }else{
                  shoElmessage(true,'新增失败','error')
                }
              })
            }else if(data.title =='修改'){
              UpdatePorductType({
                category_id:data.editinfo.id,
                name:data.editinfo.name,
                eng_name:data.editinfo.eng_name,
                is_effective:data.editinfo.is_effective,
                parent_id:data.editinfo.parent_id,
                img_url:data.editinfo.img_url,
                seo_description:data.editinfo.seo_description,
              }).then(res =>{
                if(res.code == 1){
                  shoElmessage(true,'修改成功')
                  DialogClose();
                }else{
                  shoElmessage(true,'修改失败','error')
                }
              })
            }
          }
        })
          
    }
    function InitData(){
      data.upload_satus = false;
      data.select_status = false;
      data.flie_list = [];
      data.editinfo = {
        name:'',//名称
        eng_name:"",
        is_effective:"",//是否有效
        parent_id:"",//父类id
        img_url:"",//分类图片地址
        seo_description:""//描述
      }
    }
    function Init(item){
      InitData(item)
      if(item.title == '修改'){
        data.title = '修改'
        GetproductCategoryDetail({
          category_id:item.id
        }).then(res =>{
            data.editinfo = res.data
            data.editinfo.parent_id = res.data.parent_id || ''
            data.flie_list.push({
              fullurl:res.data.img_url
            })
        })
      }else if(item.title == '新增' && isNaLL(item.id)){
        data.select_status = true;
        data.obj = item
        data.title = `新增  ${item.name} 子类`
      }else{
        data.title = '新增'
      }
    }
    //关闭弹出框
    function DialogClose(){
      content.emit('DialogClose')
    }
    //放大
    function Screen(){
      data.isFullscreen = !data.isFullscreen
    }
    //删除图片响应
    function onRemove(removeitem){
    }
    //图片上传成功
    function OnSuccess(res){
        if(res.code == 1){
          data.upload_satus = true
          data.flie_list.push(res.data)
        }else{
          shoElmessage(true,'上传失败，只能上传一张','error')
        }
    }
    function UploadChange(res){
      console.log(res)
    }
    function UploadError(){
      shoElmessage(true,'上传失败','error')
    }
    //删除图片
    function DELETE_IMG(item){
        let index = data.flie_list.indexOf(item)
        data.flie_list.splice(index,1);
    }
    //放大图片
    function Enlarge_IMG(item){
      data.Enlarge_Dialog = true
      data.Enlarge_Dialog_IMG = item.fullurl
    }
    onMounted(() =>{
      GetTableList();
    })
    //获取数据
    function GetTableList(){
        GetProductCategoryList({
            page_num:data.querInfo.currentpage,
            per_page_num:data.querInfo.pagesize,
        }).then(res => {
          if(res.code == 1){
              data.empty_status = true
              data.tableData = res.data.data
              data.querInfo = res.data
            }
        })
    }
    return{
      resetForm,
      ...toRefs(data),
      DialogClose,
      Screen,
      Init,
      GetTableList,
      OnSuccess,
      UploadError,
      onRemove,
      DELETE_IMG,
      Enlarge_IMG,
      form,
      InitData,
      UploadChange,
      getLocalTime
    }
  }
}
</script>
<style lang="scss" scoped>
// 编辑商品品类弹框
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
:deep(.el-upload-dragger){
  width: 150px;
  height: 150px;
}
.product_type--upload :deep(.el-upload){
  line-height: normal; 
}
</style>