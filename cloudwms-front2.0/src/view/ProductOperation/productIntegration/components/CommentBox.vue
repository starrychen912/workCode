<template>
  <vite-dialog v-model="dialogVisible" :title="title" @ViteClose="ViteClose" width="50%">
    <el-form :model="from" >
      <el-form-item label="上传附件" label-width="80px">
        <div class="pic_images--list flex align-center flex-wrap">
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
                    <i class="el-icon-plus"></i>
                </el-upload>
          </div>
      </el-form-item>
      <el-form-item label="状态" label-width="80px">
        <el-select v-model="ruleForm.status"  multiple-limit="0" clearable >
            <el-option label="待处理" value="0"></el-option>
            <el-option label="处理中" value="1"></el-option>
            <el-option label="已处理" value="2"></el-option>
            <el-option label="已关闭" value="3"></el-option>
          </el-select>
      </el-form-item>
      <el-form-item prop="to_company_user_id" label="接收人：" label-width="80px">
          <el-select v-model="ruleForm.to_company_user_id" placeholder="请选择类型">
              <el-option :label="item.username" :value="item.id" v-for="item in responsible_person_list"></el-option>
          </el-select>
      </el-form-item>
      <el-form-item label="内容" label-width="80px">
        <el-input
          type="textarea"
          placeholder="请输入内容"
          v-model="ruleForm.content"
          maxlength="1000000000"
          show-word-limit
          :autosize="{ minRows: 8, maxRows: 6 }"
        >
        </el-input>
      </el-form-item>
      
    </el-form>
    <template #footer>
        <el-button @click="resetForm(rulefrom)">取 消</el-button>
        <el-button type="primary" @click="submitForm(rulefrom)">确 定</el-button>
    </template>
  </vite-dialog>
</template>
<script>
import ViteDialog from '../../../../components/ViteDialog/index.vue'
import { reactive, toRefs, watch } from 'vue'
import draggable from 'vuedraggable'
import { netConfig } from '../../../../config/net.config'
import { getAccessToken } from '@/utils/AccessToken'
import { shoElmessage } from '../../../../utils/Elmessage'
import { Addtransaction } from '@/api/transaction.js'
import { useStore } from 'vuex'
export default {
  components:{
    ViteDialog,
    draggable
  },
  props:{
    dialogVisible:{
      type:Boolean,
      default:false,
    },
    responsible_person_list:{
      type:Array,
      default:[]
    }
  },
  setup(props,content){
    const store = useStore();
    const data = reactive({
      //上传图片url
      baseUrl:netConfig.baseURL,
      //上传文件额外参数
      headers:{
            token:getAccessToken(),
      }, 
      flie_list:[],
      file_type:'.png,.jpg,.jpeg,.gif,.svg,.GIF,.JPEG,.PNG,.JPG,.SVG',//文件类型

      title:"",
      
      ruleForm:{
        prove_img:"",
        content:"",
        parent_id:"",
        status:'0',
        to_company_user_id:'',
        company_user_id:3,
      }
    })
    //关闭弹出框
    function ViteClose(){
      content.emit('CommenClose')
    }
    //取消
    function resetForm(){
      content.emit('CommenClose')
    }
    //确定
    function submitForm(){
      let image_urls;//图片整合
      if(data.flie_list.length > 0){
        let imglist = [];
        data.flie_list.forEach(el =>{
            imglist.push(el.url)
        })
        image_urls = imglist.join(',');
      }
      data.ruleForm.prove_img = image_urls;
      Addtransaction({
        company_id:store.state.userinfo.userinfo.company_id,
        ...data.ruleForm
      }).then(res =>{
        if(res.code == 1){
           content.emit('CommenClose')
           shoElmessage(true,'评论成功')
        }else{
          shoElmessage(true,`回复失败，原因${res.msg}`,'error')
        }
      })
    }
    function Init(item){
      data.ruleForm = {
        prove_img:"",
        content:"",
        parent_id:"",
        status:'0',
        to_company_user_id:'',
        company_user_id:3,
      }
      data.title = `回复 ${item.userinfo.username}`
      data.ruleForm.parent_id = item.id
      data.ruleForm.status = item.status
      data.ruleForm.type = item.type
      // data.ruleForm.type_id = item.type_id

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
        let index = data.flie_list.indexOf(item)
        data.flie_list.splice(index,1);
    }
     //放大图片
    function Enlarge_IMG(item){
      data.Enlarge_Dialog = true
      data.Enlarge_Dialog_IMG = item.fullurl
    }
    return {
      ...toRefs(data),
      ViteClose,
      Init,
      resetForm,
      submitForm,
      DELETE_IMG,
      UploadChange,
      onRemove,
      OnSuccess,
      Enlarge_IMG,
      BeforeUpload
    }
  }
}
</script>
<style lang="scss" scoped>
.pic_images--list{
  .el-form-item__content{
    line-height: 0;
  }
  .el-upload-list--picture-card .el-upload-list__item{
    // margin-bottom: 0px;
  }
  .el-upload-list--picture-card{
    line-height: 0;
  }
  .pic_upload-demo{
    .el-upload--picture-card{
        margin-bottom: 10px;
    }
  }
}

</style>