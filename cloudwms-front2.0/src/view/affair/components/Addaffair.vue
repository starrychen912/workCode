<template>
  <vite-dialog v-model="visitly" title="新增" @ViteClose="ViteClose">
      <div class="dialogvisible_content">
        <el-form :model="ruleForm" :rules="ruleForm_rules" ref="rulefrom">
            <el-form-item label="名称：" prop="title" label-width="18%">
                <div class="dialogvisible_list--input">
                    <el-input v-model="ruleForm.title">请输入名称</el-input>
                </div>
            </el-form-item>
            <!-- <el-form-item label="事务类型：" label-width="18%" prop="type">
                <el-checkbox-group v-model="ruleForm.type">
                  <el-checkbox-button label="通告" name="通告"></el-checkbox-button>
                  <el-checkbox-button label="必读" name="必读"></el-checkbox-button>
                  <el-checkbox-button label="只读" name="只读"></el-checkbox-button>
                </el-checkbox-group>
            </el-form-item> -->
            <!-- <el-form-item prop="date" label="开始日期：" label-width="18%">
              <div>
                  <el-date-picker type="date" placeholder="选择日期" v-model="ruleForm.date" ></el-date-picker>
              </div>
            </el-form-item> -->
            <el-form-item label="类型：" prop="type" label-width="18%">
                  <el-select v-model="ruleForm.type" placeholder="请选择类型" @change="SelectType" clearable :disabled="other_item">
                      <el-option label="产品研发" :value="1"></el-option>
                      <el-option label="采购" :value="2"></el-option>
                  </el-select>
              </el-form-item>
              <el-form-item prop="type_id" label="对应类型关联：" label-width="18%">
                <el-select v-model="ruleForm.type_id" placeholder="请选择类型" :disabled="disabled">
                      <el-option :label="item.title" :value="item.id" v-for="(item,index) in type_id_list" :key="index"></el-option>
                </el-select>
              </el-form-item>
              <!-- <el-form-item prop="date" label="负责人：" label-width="18%">
                  <el-select v-model="ruleForm.company_user_id" placeholder="请选择类型" @change="SelectType" clearable :disabled="other_item">
                      <el-option   :value="item.id" :label="item.username" v-for="item in responsible_person_list"></el-option>
                  </el-select>
              </el-form-item> -->
              
              <el-form-item prop="content" label="内容：" label-width="18%">
                  <orderlistwang-editor
                    :editor="ruleForm.content"
                    @Change="editorChange"
                    @Onfocus="Onfocus"
                    @Onblur="Onblur"
                  ></orderlistwang-editor>
              </el-form-item>
              <div class="expand_more" @click="ToggleActive">展开更多 + </div>
              
              <div  class="toggle_content" :class="{'toggle_active':Togglestatus}">
                  <!-- <el-form-item label="权限：" label-width="18%">
                      <el-radio-group v-model="ruleForm.resource" size="medium">
                          <el-radio border label="公开"></el-radio>
                          <el-radio border label="个人"></el-radio>
                          <el-radio border label="权限"></el-radio>
                      </el-radio-group>
                  </el-form-item>
                  <el-form-item prop="date" label="优先级：" label-width="18%">
                      <el-radio-group v-model="ruleForm.resource" size="medium">
                          <el-radio border label="普通"></el-radio>
                          <el-radio border label="优先"></el-radio>
                          <el-radio border label="置顶"></el-radio>
                      </el-radio-group>
                  </el-form-item> -->
                  <el-form-item prop="company_user_id" label="发送人：" label-width="18%">
                      <el-select v-model="ruleForm.company_user_id" placeholder="请选择类型">
                          <el-option :label="item.username" :value="item.id" v-for="item in responsible_person_list"></el-option>
                      </el-select>
                  </el-form-item>
                  <el-form-item prop="to_company_user_id" label="接收人：" label-width="18%">
                      <el-select v-model="ruleForm.to_company_user_id" placeholder="请选择类型">
                          <el-option :label="item.username" :value="item.id" v-for="item in responsible_person_list"></el-option>
                      </el-select>
                  </el-form-item>
                  <el-form-item prop="status" label="状态：" label-width="18%">
                      <el-select v-model="ruleForm.status" placeholder="请选择类型">
                          <el-option label="待处理" value="0"></el-option>
                          <el-option label="处理中" value="1"></el-option>
                          <el-option label="已处理" value="2"></el-option>
                          <el-option label="已关闭" value="3"></el-option>
                      </el-select>
                  </el-form-item>
                  <!-- <el-form-item prop="date" label="相关订单：" label-width="18%">
                      <el-select
                          v-model="value"
                          multiple
                          filterable
                          allow-create
                          default-first-option
                          placeholder="请选择相关订单">
                          <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                          </el-option>
                      </el-select>
                  </el-form-item> -->
                  <el-form-item prop="date" label="附加文件：" label-width="18%">
                      <el-upload
                        :headers="headers"
                        :action="baseUrl + '/api/common/upload'"
                        list-type='picture-card'
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :file-list="flie_list"
                        :on-success="handSuccess"
                        :on-change="handChange"
                      >
                        <el-icon class="el-icon-plus"></el-icon>
                      </el-upload>
                  </el-form-item>
              </div>
        </el-form>
    </div>
    <template #footer>
        <el-button @click="resetForm(rulefrom)">取 消</el-button>
        <el-button type="primary" @click="submitForm(rulefrom)">确 定</el-button>
    </template>
  </vite-dialog>
</template>
<script>
import { defineComponent, reactive, toRefs,inject, computed, ref, watch } from 'vue'
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue"
import ViteDialog from '@/components/ViteDialog/index.vue'
import OrderlistwangEditor from "../../Shopfly/Orderlist/OrderlistwangEditor.vue";
import { useStore } from 'vuex';
import { isNaLL } from '../../../utils/utils';
import { GetproductDevelopmentList } from '@/api/productDevelopmentList.js'
import { Addtransaction } from '@/api/transaction.js'
import { shoElmessage } from '../../../utils/Elmessage';
import { getAccessToken } from '@/utils/AccessToken'
import { netConfig } from '../../../config/net.config';
export default defineComponent({
  name:'Addaffair',
  components:{
    Sidebar,
    OrderlistwangEditor,
    ViteDialog
  },
  emits:['update:modelValue'],
  props:{
    dialogVisible_Addaffair:{
      type:Boolean,
      default:false,
    },
    modelValue:{
      type:Boolean,
      default:false,
    },
    responsible_person_list:{
      type:Array,
      default:[],
    }
  },
  setup(props,content) {
    const store = useStore();
    const rulefrom = ref(null);
    const userinfo = computed(() => {return store.state.userinfo.userinfo})
    const data = reactive({
      baseUrl:netConfig.baseURL,
      headers:{
        token:getAccessToken()
      },
      flie_list:[],
      visitly:false,
      ruleForm:{
          title:'',
          type:"",
          type_id:'',
          company_user_id:"",//发送人id
          to_company_user_id:"",//接收人id
          status:'',
          prove_img:'',
          content:''
      },
      Togglestatus:false,
      //选择
      disabled:computed(() => {return !isNaLL(data.ruleForm.type) || data.other_item}),
      type_id_list:[],
      ruleForm_rules:{
        title: [
            { required: true, message: '请输入活动名称', trigger: 'blur' },
            { min: 1, max: 555555, message: '长度必须3 ', trigger: 'blur' }
        ],
        type: [
            { required: true, message: '请选择类型', trigger: 'change' }
        ],
        type_id: [
            { required: true, message: '请选择关联类型', trigger: 'change' }
        ],
        content:[
            { required: true, message: '请输入内容', trigger: 'blur' },
        ],
      },
       other_item:false,
    })
    watch(() => props.modelValue,(val)=>{
      data.visitly = val
    })
    watch(() => data.visitly,(val)=>{
      content.emit('update:modelValue',val)
    })
    function ToggleActive(){
      data.Togglestatus = !data.Togglestatus
    }
    function ViteClose(){
      content.emit('CloseBusinesses')
    }
    function SelectType(e){
      console.log(userinfo)
      if(!isNaLL(e)) data.ruleForm.type_id = '';data.type_id_list = [];
      if(e == '采购'){
        console.log(e)
      }else{
        GetproductDevelopmentList({
          company_id:userinfo.value.company_id
        }).then((res) => {
          if(res.code == 1){
            data.type_id_list = res.data.data
          }
        })
      }
    }
    //文本编辑
    function editorChange(e){
       data.ruleForm.content = e
    }
    //取消
    function resetForm(){
      ViteClose();
    }
    function Init(item){
      console.log(item)
      data.other_item = false
      data.ruleForm = {
          title:'',
          type:"",
          type_id:'',
          company_user_id:"",//发送人id
          to_company_user_id:"",//接收人id
          status:'',
          prove_img:'',
          content:''
      }
      data.flie_list = []
      if(isNaLL(item)){
        data.other_item = true
        data.ruleForm.type = item.type
        data.ruleForm.type_id = item.id
      }
    }
    //确定
    function submitForm(rulefrom){
      let image_urls;//图片整合
      if(data.flie_list.length > 0){
        let imglist = [];
        data.flie_list.forEach(el =>{
            imglist.push(el.src)
        })
        image_urls = imglist.join(',');
      }
      data.ruleForm.company_user_id = userinfo.value.user_id
      data.ruleForm.to_company_user_id = 0
      data.ruleForm.prove_img = image_urls
      rulefrom.validate((valid) =>{
        if(valid){
            Addtransaction({
              company_id:userinfo.value.company_id,
              ...data.ruleForm
            }).then(res =>{
              if(res.code == 1){
                ViteClose();
                shoElmessage(true,'添加成功')
              }else{
                shoElmessage(true,`添加失败，原因${res.msg}`,'error')
              }
            })
        }else{
          shoElmessage(true,'请输入完整信息','error')
        }
      })
    }
    //上传图片
    function handSuccess(res){
      if(res.code == 1){
        data.flie_list.push({
          url:res.data.fullurl,
          src:res.data.url,
          fullurl:res.data.fullurl,
        })

      }
    }
    function handleRemove(item){
      let index = data.flie_list.indexOf(item)
      data.flie_list.splice(index,1);
    }
    function handChange(e){
      console.log(e)
    }
    return{
      ...toRefs(data),
      ToggleActive,
      ViteClose,
      SelectType,
      submitForm,
      resetForm,
      rulefrom,
      userinfo,
      editorChange,
      Init,
      handSuccess,
      handChange,
      handleRemove
    }
  },
})
</script>
<style lang="scss" scoped>
.el-header{
  background-color: $navBg;
  height: auto;
  padding: 0px;
}
.expand_more{
    padding-left: 10%;
    padding-top: 20px;
    padding-bottom: 20px;
    color: #0d84ff;
    cursor: pointer;
}
.toggle_content{
    height: 0px;
    overflow: hidden;
    padding: 0px;
    transition: all .5s;
}
.toggle_active{
    padding: 15px 0px;
    min-height: 350px;
    height: auto;
    transition: all .5s;
}
:deep(.el-table .el-table__cell){
    vertical-align: baseline;
}
:deep(.el-form-item__content){
  max-width: 700px;
}
</style>
