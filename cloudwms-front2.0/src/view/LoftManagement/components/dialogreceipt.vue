<template>
  <div class="basic_infomation">基本信息</div>
        <el-form ref="form" :model="ruleForm" :rules="rules" class="basic_infomaion--form">
            <el-form-item label="名称：" label-width="18%" prop="Managementname">
                <el-input style="max-width:700px" v-model="ruleForm.Managementname"></el-input>
            </el-form-item>
            <el-form-item label="编号：" label-width="18%" prop="mobile">
                <el-input style="max-width:700px" v-model="ruleForm.mobile"></el-input>
            </el-form-item>
            <el-form-item label="联系人：" label-width="18%" prop="managementuser">
                <el-select v-model="ruleForm.managementuser">
                    <el-option  v-for="item in options" :key="item.value" :label="item.label" :value="item.label"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="联系方式：" label-width="18%" prop="mobile">
                <el-input style="max-width:700px" v-model="ruleForm.mobile"></el-input>
            </el-form-item>
            <el-form-item label="申请时间：" label-width="18%" prop="mobile">
                <el-date-picker
                  v-model="value1"
                  type="date"
                  placeholder="选择日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="收货类型：" label-width="18%" prop="mobile">
                <el-input style="max-width:700px" v-model="ruleForm.mobile"></el-input>
            </el-form-item>
            <el-form-item label="收货创库：" label-width="18%" prop="mobile">
                <el-input style="max-width:700px" v-model="ruleForm.mobile"></el-input>
            </el-form-item>
            <el-form-item prop="resource" label="店铺状态：" label-width="18%" >
                <el-select v-model="ruleForm.managementuser">
                    <el-option  v-for="item in options" :key="item.value" :label="item.label" :value="item.label"></el-option>
                </el-select>
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
        <div class="expand_more" @click="ToggleActive">展开更多 + </div>
        <div class="show_expand--information" :class="{'toggle_active':Togglestatus}">
          <div class="basic_infomation">入库货品信息</div>
          <div class="basic_infomation--warring">
            <div class="warring_title">
              注意事项
              <i class="el-icon-warning"></i>
            </div>
            <div class="warring_1">1.必须先选择入库的创库，才能选择商品，吗，每个商品都要入库</div>
            <div class="warring_2">2.可前往"<a>创库管理/货品管理</a>"，对创库进行注册</div>
          </div>
          <el-form v-model="ruleForm" rules="rules" class="form_dislog">
            <el-form-item label="货物：" label-width="18%" >
                <el-input placeholder="请输入内容" v-model="input2">
                    <template #append>条码添加</template>
                </el-input>
            </el-form-item>
            <el-form-item label="选择货物添加：" label-width="18%" >
                <el-select v-model="ruleForm.managementuser">
                    <el-option  v-for="item in options" :key="item.value" :label="item.label" :value="item.label"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item >
                <el-table >
                  <el-table-column
                      prop="resource"
                      label="货品/编码"
                      min-width="200"
                  ></el-table-column>
                  <el-table-column
                      prop="resource"
                      label="规格/编码"
                      min-width="200"
                  ></el-table-column>
                  <el-table-column
                      prop="resource"
                      label="条形码"
                      min-width="200"
                  ></el-table-column>
                  <el-table-column
                      prop="resource"
                      label="批次编码"
                      min-width="200"
                  ></el-table-column>
                  <el-table-column
                      prop="resource"
                      label="数量"
                      min-width="200"
                  >
                    <template #default>
                      <el-input placeholder="货品数量"></el-input>
                    </template>
                  </el-table-column>
                </el-table>
            </el-form-item>
          </el-form>
        </div>
</template>
<script>
import { reactive, toRefs } from 'vue'
import OrderlistwangEditor from '../../Shopfly/Orderlist/OrderlistwangEditor.vue'
export default {
  components:{
    OrderlistwangEditor
  },
  setup(){
    const data = reactive({
       ruleForm:{
            Managementname:"安全部",
            id:12346578,
            mobile:'15766372450',
            market:'US-1',
            resource:'',
            userlist:'',
            textarea:'',
            managementuser:'',
        },
        Togglestatus:false,
    })
    function ToggleActive(){
      console.log(11)
      data.Togglestatus = !data.Togglestatus
    }
    return {
      ...toRefs(data),
      ToggleActive
    }
  }
}
</script>
<style lang="scss" scoped>
.basic_infomation{
  padding: 15px;
  background-color: #fafafa;
}
.basic_infomation--warring{
  padding: 20px;
  margin-top: 20px;
  background-color: #fafafa;
  font-size: 14px;
  .warring_title{
    i{
      color: #ffae00;
      font-size: 20px;
    }
  }
  .warring_1{
    padding: 4px 0px;
  }
  .warring_2{
    padding: 4px 0px;
    a{
      color: #0d84ff;
    }
  }
}
.basic_infomaion--form{
  margin-top: 20px;
}
.form_dislog{
  padding: 20px;
}
.expand_more{
    padding-left: 10%;
    padding-top: 20px;
    padding-bottom: 20px;
    color: #0d84ff;
    cursor: pointer;
}
.show_expand--information{
  height: 0px;
  overflow: hidden;
  padding: 0px;
  transition: all .5s;
}
.toggle_active{
    padding: 15px 0px;
    height: auto;
    transition: all .5s;
}

</style>