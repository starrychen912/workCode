<template>
    <vite-dialog
      :title="title"
      v-model="dialogVisible"
      width="50%"
      :before-close="handleClose"
    >
        <el-form ref="form" :model="ruleForm" :rules="rules">
            <el-form-item label="部门名称：" label-width="18%" prop="Managementname">
              <el-input
                style="max-width: 700px"
                v-model="ruleForm.Managementname"
              ></el-input>
            </el-form-item>
            <el-form-item label="上级部门：" label-width="18%" prop="pid">
              <el-cascader
              :options="Departmentlist"
              :collapse-tags="true"
              :show-all-levels="false"
              :props="{ multiple: false, checkStrictly: true,value:'id',label:'name',emitPath:false }"
                v-model="ruleForm.pid"
                clearable>
                  <template #default="{ node, data }">
                    <span>{{ data.name }}</span>
                    <span v-if="!node.isLeaf"> ({{ data.children.length }}) </span>
                  </template>
            </el-cascader>
            </el-form-item>
            <el-form-item label="管理人：" label-width="18%" prop="managementuser">
              <el-select v-model="ruleForm.managementuser">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.label"
                ></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="联系方式：" label-width="18%" prop="mobile">
              <el-input style="max-width: 700px" v-model="ruleForm.mobile"></el-input>
            </el-form-item>
            <el-form-item label="权重：" label-width="18%" prop="sort">
              <el-input style="max-width: 700px" v-model="ruleForm.sort"></el-input>
            </el-form-item>
            <el-form-item label="人员列表：" label-width="18%" prop="userlist">
              <el-select
                v-model="ruleForm.userlist"
                multiple
                filterable
                allow-create
                default-first-option
                placeholder="请选择人员列表"
              >
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                >
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item prop="resource" label="部门状态：" label-width="18%">
              <el-radio-group v-model="ruleForm.resource" size="medium">
                <el-radio :border="true" label="0" value="0">启动</el-radio>
                <el-radio :border="true" label="1" value="1">停用</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="备注：" label-width="18%" prop="textarea">
             <orderlistwang-editor
                :editor="ruleForm.textarea"
                @Change="editorChange"
                @Onfocus="Onfocus"
                @Onblur="Onblur"
              ></orderlistwang-editor>
            </el-form-item>
      </el-form>
      <template #footer>
        <el-button @click="resetForm(form)">取 消</el-button>
        <el-button type="primary" @click="onSubmit(form)">确 定</el-button>
      </template>
    </vite-dialog>
</template>
<script>
import { reactive, toRefs,ref } from 'vue'
import ViteDialog from '@/components/ViteDialog/index.vue'
import { Adddepartment , GetdepartmentDetail,Updatdepartmente} from '@/api/department.js'
import { shoElmessage } from '../../../utils/Elmessage'
import { useStore } from 'vuex'
import OrderlistwangEditor from '../../Shopfly/Orderlist/OrderlistwangEditor.vue'
export default {
  components:{
    ViteDialog,
    OrderlistwangEditor
  },
  emits:['DialogClose'],
  props:{
    dialogVisible:{
      type:Boolean,
      default:false
    },
    Departmentlist:{
      type:[Array,Object],
      default:[]
    }
  },
  setup(props,content){
    const form = ref(null)
    const store = useStore();
    const datas = reactive({
        title:'新增',
        ruleForm: {
          Managementname: "",
          id: 12346578,
          mobile: "15766372450",
          market: "US-1",
          resource: "",
          userlist: "",
          textarea: "",
          managementuser: "",
          sort:"",
          pid:"",
        },
        rules: {
          Managementname: [
            { required: true, message: "请输入部门名称", trigger: "blur" },
          ],
          // mobile: [
          //   { required: true, message: "请输入手机号码", trigger: "blur" },
          // ],
          // resource: [
          //   { required: true, message: "请输入选择店铺状态", trigger: "blur" },
          // ],
          // userlist: [
          //   { required: true, message: "请输入选择人员列表", trigger: "blur" },
          // ],
          // managementuser: [
          //   { required: true, message: "请输入选择管理人员", trigger: "blur" },
          // ],
        },
        options: [{ value: 1, label: "高高" }],
    })
    function onSubmit(item){
     item.validate((vide) =>{
        if(vide){
          if(datas.title == '新增'){
            Adddepartment({
              department_id:store.state.userinfo.userinfo.company_id,
              pid:datas.ruleForm.pid,
              sort:datas.ruleForm.sort,
              name:datas.ruleForm.Managementname,
            }).then(res =>{
              if(res.code == 1){
                shoElmessage(true,'添加成功')
                Department_Close_Dialog()
              }else{
                shoElmessage(true,'添加失败','error')
              }
            })
          }else{
            Updatdepartmente({
              department_id:datas.ruleForm.department_id,
              pid:datas.ruleForm.pid,
              sort:datas.ruleForm.sort,
              name:datas.ruleForm.Managementname,
            }).then(res =>{
              if(res.code == 1){
                shoElmessage(true,'更新成功')
                Department_Close_Dialog()
              }else{
                shoElmessage(true,'更新失败','error')
              }
            })
          }
        }else{
          shoElmessage(true,'请输入完整信息','error')
        }
      })
    }
    //关闭弹出框
    function Department_Close_Dialog(){
      form.value.resetFields();
      content.emit('DialogClose')
    }
    function Init(item){
      datas.title = '编辑'
      GetdepartmentDetail({
        department_id:item.id
      }).then(res =>{
        if(res.code == 1){
          datas.ruleForm = {
            department_id:res.data.id,
            pid:res.data.pid,
            sort:res.data.sort,
            Managementname:res.data.name,
          }
        }
      })
    }
    return {
      form,
      ...toRefs(datas),
      onSubmit,
      Department_Close_Dialog,
      Init
    }
  }
}
</script>
<style lang="scss" scoped>

</style>