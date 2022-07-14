<template>
  <vite-dialog v-model="addvisitly" width="50%" title="新增" @ViteClose="ViteClose">
    <el-form :model="ruleForm" :rules="rules" ref="rulefrom" label-width="18%" >
      <el-form-item label="名称" prop="name">
        <el-input v-model="ruleForm.name"></el-input>
      </el-form-item>
      <el-form-item label="排序" prop="orders">
        <el-input v-model="ruleForm.orders"></el-input>
      </el-form-item>
      <el-form-item label="备注" prop="memo">
        <el-input  type="textarea" v-model="ruleForm.memo" :autosize="{ minRows: 4, maxRows: 6 }"></el-input>
      </el-form-item>
    </el-form>
    <template #footer>
        <el-button @click="ViteClose">取 消</el-button>
        <el-button type="primary" @click="submitForm(rulefrom)">确 定</el-button>
    </template>
  </vite-dialog>
</template>
<script>
import ViteDialog from '@/components/ViteDialog/index.vue'
import { reactive, toRefs, watch ,ref} from 'vue'
import { shoElmessage } from '@/utils/Elmessage'
import { AddproductTags } from '@/api/Tags.js'
import store from '../../../../store'
import { useStore } from 'vuex'
export default {
  components:{
    ViteDialog
  },
  props:{
    addvisitly:{
      type:Boolean,
      default:false,
    }
  },
  setup(props,content){
    const store = useStore();
    const rulefrom = ref(null)
    const datas = reactive({
      ruleForm:{
        name:"",
        orders:"",
        meno:""
      },
      rules:{
        name: [
            { required: true, message: '请输入名称', trigger: 'blur' },
            { min: 1, max: 100000, message: '长度在 3 到 5 个字符', trigger: 'blur' }
        ],
        region: [
          { required: true, message: '请选择orders', trigger: 'change' }
        ],
      }
    })
    function ViteClose(){
      content.emit('GroupingClose')
    }
    //添加
    function submitForm(rulefrom){
      rulefrom.validate((valid) =>{
        if (valid) {
          AddproductTags({
            company_id:store.state.userinfo.userinfo.company_id,
            ...datas.ruleForm
          }).then(res =>{
            if(res.code == 1){
              shoElmessage(true,'添加成功')
              ViteClose()
            }else{
              shoElmessage(true,`添加失败,原因${res.msg}`,'erro')
            }
          })
        } else {
          shoElmessage(true,'请输入完整的信息','error')
        }
      })
    }
    //初始化
    function Init(){
      datas.ruleForm = {
        name:"",
        orders:"",
        meno:""
      }
    }
    return{
      ...toRefs(datas),
      ViteClose,
      rulefrom,
      submitForm,
      Init
    }
  }
}
</script>
<style lang="scss" scoped>

</style>