<template>
  <vite-dialog v-model="Receipt_dialogVisible" title="新增入库" @ViteClose="CloseDialog('Receipt_dialogVisible')">
    <el-form  :model="ruleForm" ref="ruleForms" label-width="110px" label-position="left" class="demo-ruleForm" :rules="rules_basic">
      <el-form-item label="入库时间：" prop="inbound_date" class="colForm">
        <el-date-picker  v-model="ruleForm.inbound_date" type="date" format="YYYY-MM-DD"  placeholder="选择日期" style="width:100%">
        </el-date-picker>
      </el-form-item>
      <el-form-item label="入库仓库：" prop="warehouse_id" class="colForm">
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
    </el-form>
    <div class="receipt_infomation">
      <div class="title">入库信息：</div>
      <el-table :data="tableData" :border="true">
         <el-table-column  prop="商品SKU"  label="SKU"  >
            <template #default="scope">
            <div :class="{'active_error':sku_status && scope.$index==0} ">
            <el-select
              v-model="scope.row.sku"
              filterable
              remote
              reserve-keyword
              placeholder="请选择商品"
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
         <el-table-column  prop="cost"  label="原价" >
            <template #default="scope">
              <el-input
                  class="cost"
                  v-model="scope.row.cost"
              ></el-input>
            </template>
         </el-table-column>
         <el-table-column  prop="price"  label="采购价"  >
            <template #default="scope">
              <el-input
                  class="price"
                  v-model="scope.row.price"
              ></el-input>
            </template>
         </el-table-column>
         <el-table-column  prop="quantity"  label="库存"  >
           <template #default="scope">
              <el-input
                  class="quantity"
                  v-model="scope.row.quantity"
              ></el-input>
            </template>
         </el-table-column>
         <el-table-column label="操作" width="150px">
           <template #default="scope">
              <div class="tableBtn">
                <el-link  type="primary"  size="small"  @click="addition(scope.row)">添加</el-link>
                <el-divider direction="vertical" v-show="scope.$index > 0"></el-divider>
                <el-link  type="primary"  size="small"  @click="deletetion(scope.$index,scope.row)" v-show="scope.$index > 0">删除</el-link>
              </div>
           </template>
         </el-table-column>
    </el-table>
    </div>
    <!-- 描述 -->
    <div class="receipt_infomation">
      <div class="title">描述：</div>
      <EditWangeditor ref="editwangeditor" :editor="ruleForm.note" v-model="ruleForm.note"></EditWangeditor>
    </div>
    <template #footer class="el-dialog-footer">
      <el-button @click="CloseDialog('Receipt_dialogVisible')">取消</el-button>
      <el-button @click="resetForm(ruleForms)">重置</el-button>
      <el-button type="primary" @click="PurchaseAdd(ruleForms)">立即创建</el-button>
    </template>
  </vite-dialog>
</template>
<script >
import { onMounted, reactive, toRefs,ref } from "vue"
import { useStore } from "vuex";
import { GetProductList } from "@/api/Porductapi";
import { inboundAdd,inboundList,inboundCheck } from '@/api/receipt'
import { shoElmessage } from "@/utils/Elmessage";
export default{
  name:"AddReceipt",
  props:{
    Receipt_dialogVisible:{
      type:Boolean,
      default:false,
    },
    WarehouseList:{
      type:Array,
      default:[],
    },
    user_list:{
      type:Array,
      default:[],
    }
  },
  setup(props,content){
    const ruleForms = ref();
    const store = useStore();
    const data = reactive({
        ruleForm:{
          company_user_id:"",//负责人
          warehouse_id:"",
          inbound_date:"",
          note:"",
        },
        tableData:[
          {sku:"",cost:"",price:"",quantity:""}
        ],

        remote_list:[],
        sku_status:false,
        loading:false,

        rules_basic:{
          inbound_date:[
              { required: true, message: "请选择入库时间", trigger: "change" },
          ],
          warehouse_id:[
              { required: true, message: "请选择商品仓库", trigger: "change" },
          ],
          company_user_id:[
              { required: true, message: "请选择负责人", trigger: "change" },
          ],
        }
    })
    function Blur(index, sku) {
        if (sku != "" && index == 0) {
            data.sku_status = false;
        }
        else {
            data.sku_status = true;
        }
    }
    function Focus(index) {
        if (index == 0) {
            data.sku_status = false;
        }
    }
    //sku的校验
    function change(index, sku) {
        // console.log(index,sku)
        if (sku != "" && index == 0) {
            data.sku_status = false;
        }
        else {
            data.sku_status = true;
        }
    }
    // sku搜索
    function remoteMethod(query) {
        //  商品sku接口
        GetProductList({
            title: query,
            company_id: store.state.userinfo.userinfo.company_id,
        }).then((res) => {
            if (res.code == 1) {
                data.remote_list = res.data.data;
            }
        });
    }
    function addition(){
      data.tableData.push({sku:"",cost:"",price:"",quantity:""})
    }
    function deletetion(index,item){
      data.tableData.splice(index,1)
    }
    function CloseDialog(item){
      content.emit('CloseDialog',item)
    }
    function resetForm(item){
      item.value.resetFields();
    }
    function PurchaseAdd(item){
      data.ruleForm.inbound_date = data.ruleForm.inbound_date / 1000
      item.validate((vaild,fields) =>{
        if(vaild){
          console.log('进来了')
          inboundAdd({
            company_id:store.state.userinfo.userinfo.company_id,
            ...data.ruleForm,
            skus:JSON.stringify(data.tableData),
          }).then(res =>{
            console.log(res)
            if(res.code == 1){
              shoElmessage(true,'添加成功','success')
              CloseDialog('Receipt_dialogVisible')
            }else{
              shoElmessage(true,`添加失败，原因${res.msg}`,'error')
            }
          })
        }
      })
    }
    onMounted(() =>{
      remoteMethod()
    })
    return {
      PurchaseAdd,
      ruleForms,
      resetForm,
      CloseDialog,
      ...toRefs(data),
      remoteMethod,
      Blur,
      change,
      Focus,
      addition,
      deletetion
    }
  }
}
 
</script>
<style scoped lang="scss">
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
.receipt_infomation{
  .title{
    margin:10px 0px;
  }
}
.active_error{
  :deep(.el-select){
      .el-input__inner:focus{
        border-color:#f56c6c !important;
      }
      .el-input__inner{
        border-color:#f56c6c !important;
      }
  }
}
</style>
