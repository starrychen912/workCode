<template>
  <div class="addfba_content">
    <div class="addfba_content--title">
      <i class="el-icon-back" @click="back"></i>
      <span>新增FBA</span>
    </div>
    <div class="from-list">
      <el-form :model="ruleForm" ref="rulefrom" :rules="ruleForm_rules" :inlist="true">
        <el-form-item label="标题：" label-width="18%" prop="title" >
          <div class="form_list--input">
            <el-input v-model="ruleForm.title" clearable placeholder="请输入"></el-input>
          </div>
        </el-form-item>
        <el-form-item label="店铺：" label-width="18%" prop="shop_id">
          <el-select v-model="ruleForm.shop_id" placeholder="请选择活动区域" clearable>
            <el-option :label="item.name" :value="item.id" v-for="item in shop_list"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="市场：" label-width="18%" prop="market_id">
          <el-select v-model="ruleForm.market_id" placeholder="请选择活动区域" clearable>
            <el-option :label="item.name" :value="item.id" v-for="item in marketlist"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="发货仓库：" label-width="18%" prop="warehouse_id">
          <el-select v-model="ruleForm.warehouse_id" placeholder="请选择活动区域" clearable>
            <el-option :label="item.name" :value="item.id" v-for="item in warehouse_list"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="包装类型：" label-width="18%" prop="packing_type">
          <el-select v-model="ruleForm.packing_type" placeholder="请选择活动区域" clearable>
            <el-option label="组合" value="1"></el-option>
            <el-option label="混装" value="2"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="创建类型：" label-width="18%" prop="create_type">
          <el-select v-model="ruleForm.create_type" placeholder="请选择活动区域" clearable>
            <el-option label="创建FBA" value="1"></el-option>
            <el-option label="补充FBA信息" value="2"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="选择商品：" label-width="18%" prop="product_id">
          <el-select v-model="ruleForm.product_id" placeholder="请选择商品" :multiple="true" filterable collapse-tags @change="Select_Change">
            <el-option :label="item.title" :value="item.id"  :key="index" v-for="(item,index) in product_list"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label-width="18%">
          <el-table :data="skus" ref="table" :border="true" empty-text="暂无商品" >
            <el-table-column label="商品" >
              <template #default="scope">
                <el-input disabled class="price" v-model="scope.row.title"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')"></el-input>
              </template>
            </el-table-column>
            <el-table-column label="商品库存" >
              <template #default="scope">
                <el-input class="price" v-model="scope.row.quantity"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')"></el-input>
              </template>
            </el-table-column>
            <el-table-column label="箱内数量">
              <template #default="scope">
                <el-input class="price" v-model="scope.row.quantity_incase"  oninput="value=value.replace(/^\.+|[^\d.]/g,'')"></el-input>
              </template>
            </el-table-column>
            <el-table-column label="操作" size="small"  :align="'left'" width="300px">
              <template v-slot="scope">
                <div class="tableBtn">
                  <el-button type="danger" size="small" @click="delData(scope.$index)" >删除</el-button>
                </div>
              </template>
            </el-table-column>
          </el-table>
        </el-form-item>
        <el-form-item label="备注："  label-width="18%">
          <EditWangeditor ref="editwangeditor" :editor="ruleForm.mark" v-model="ruleForm.mark"></EditWangeditor>
        </el-form-item>
      </el-form>
    </div>
    <div class="footer">
      <el-button type="primary" @click="onSubmit(rulefrom)">保存</el-button>
      <el-button type="primary" @click="NextStep(rulefrom)">下一步</el-button>
      <el-button @click="Cancal(rulefrom)">取消</el-button>
    </div>
  </div>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue";
import { onMounted, reactive, toRefs,ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import EditWangeditor from "../../../components/EditWangeditor/EditWangeditor.vue";
import {  ShopList } from "@/api/shoplist";
import { GetwarehouseList } from "@/api/warehouseList";
import { useStore } from "vuex";
import { fbaPlanAdd } from '@/api/FBA.js'
import { shoElmessage } from "../../../utils/Elmessage";
import { GetAmzonProductList } from '@/api/AmazonProduct';
import { GetmarketList } from '@/api/market'
export default {
  components: {
    Sidebar,
    EditWangeditor,
  },
  setup(props,content){
    const route = useRoute();
    const router = useRouter();
    const store = useStore();
    const rulefrom = ref();
    let firstload = ref(true);
    let _checkAppraicalCategorid = (rule,value,callback) =>{
      if(!firstload){
        if(Object.keys(value).length == 0 || value === ''){
          callback(new Error('请选择'))
        }else{
          callback()
        }
      }else{
        firstload = false
      }
    }
    const data = reactive({
      ruleForm: {
        market_id: "",
        title: "",
        shop_id: "",
        warehouse_id: "",
        packing_type: "",
        create_type: "",
        mark:"",
        product_id:"",
      },
      skus: [],
      product_list:[],
      warehouse_list:[],
      shop_list:[],
      
      ruleForm_rules:{
        title: [
            { required: true, message: "请输入商品名称", trigger: "blur" },
            { min: 1, max: 30, message: "长度在 1 到 30 个字符", trigger: "blur" },
        ],
        market_id:[
          { required: true, message: "请选择", trigger: "change" },
        ],
        shop_id:[
          { required: true, message: "请选择", trigger: "change" },
        ],
        warehouse_id:[
          { required: true, message: "请选择", trigger: "change" },
        ],
        packing_type:[
          { required: true, message: "请选择", trigger: "change" },
        ],
        create_type:[
          { required: true, message: "请选择", trigger: "change" },
        ],
        product_id:[
          { required: true, trigger: "change" ,validator:_checkAppraicalCategorid},
        ],
      },

      marketlist:[],
    });
    function back() {
      router.go(-1);
    }
    function addRow(item) {

    }
    function delData(index) {
        data.ruleForm.product.splice(index,1)
        data.skus.splice(index, 1);
    }
    onMounted(() =>{
      marketList()
      Get_ProductList()
    })
    function Get_ProductList(){
      GetAmzonProductList({
        company_id:store.state.userinfo.userinfo.company_id,
      }).then(res =>{
        if(res.code == 1){
          data.product_list = res.data.data
        }
      })
      ShopList({
        company_id:store.state.userinfo.userinfo.company_id,
      }).then(res =>{
        if(res.code == 1){
          data.shop_list = res.data.data
        }
      })
      GetwarehouseList({
        company_id:store.state.userinfo.userinfo.company_id,
      }).then(res =>{
        if(res.code == 1){
          data.warehouse_list = res.data.data
        }
      })
    }
    function Select_Change(e){
      let list = e;
      data.skus = [];
      list.forEach(element => {
        data.product_list.forEach(product_el =>{
          if(element == product_el.id){
            data.skus.push({
              product_id:product_el.id,
              quantity_incase:"",
              quantity:"",
              title:product_el.title,
            })
          }
        })
      });
    }
    function onSubmit(item){
      item.validate((valid, fields) => {
        if(valid){
          fbaPlanAdd({
            company_id:store.state.userinfo.userinfo.company_id,
            ...data.ruleForm,
            skus:JSON.stringify(data.skus)
          }).then(res =>{
            if(res.code == 1){
              shoElmessage(true,'保存成功','success')
              Cancal(rulefrom.value);
            }else{
              shoElmessage(true,'保存失败','error')
            }
          })
        }else{
          shoElmessage(true,'请输入完整信息','error')
        }
      })
    }
    function NextStep(item){
      item.validate((valid, fields) => {
        if(valid){
          fbaPlanAdd({
            company_id:store.state.userinfo.userinfo.company_id,
            ...data.ruleForm,
            skus:JSON.stringify(data.skus)
          }).then(res =>{
            if(res.code == 1){
              console.log(res)
              shoElmessage(true,'保存成功','success')
              store.dispatch('tagsView/delView',router.currentRoute.value).then(val =>{
                router.push({
                  path:'/Logisticsmanagement/perFBA',
                  query:{fba_id:res.data.fba_id,title:"新增FBA"}
                })
              })
            }else{
              shoElmessage(true,'保存失败','error')
            }
          })
        }else{
          shoElmessage(true,'请输入完整信息','error')
        }
      })
    }
    function Cancal(item){
      store.dispatch('tagsView/delView',router.currentRoute.value).then(res =>{
        item.resetFields();
        back();
      })
    }
    function marketList(){
      GetmarketList({
        company_id:store.state.userinfo.userinfo.company_id
      }).then(res =>{
        if(res.code == 1){
          data.marketlist = res.data.data
        }
      })
    }
    return {
      Cancal,
      NextStep,
      onSubmit,
      ...toRefs(data),
      back,
      addRow,
      delData,
      Select_Change,
      rulefrom,
      firstload
    };
  },
};
</script>
<style scoped lang="scss">
.el-header {
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 0 3px 0 rgba(0, 0, 0, 0.04);
  padding: 0px;
}
.addfba_content {
  background-color: $navBg;
  padding-bottom: 20px;
}
.addfba_content--title {
  font-size: 18px;
  padding: 15px;
  font-weight: bold;
  border-bottom: 1px solid #ebeef5;
  display: flex;
  align-items: center;
  cursor: pointer;
  i {
    font-size: 18px;
  }
  span {
    margin-left: 20px;
  }
}
.from-list {
  margin-top: 25px;
  padding: 10px;
  .form_list--input {
    max-width: 700px;
  }
}
.footer {
  padding: 11px 18%;
}
.textarea {
  display: flex;
  padding: 0 15%;
  margin-bottom: 22px;
}
.textarea_title {
   flex: 0 0 auto;
    text-align: right;
    font-size: 14px;
    color: #606266;
    line-height: 40px;
    padding: 0 12px 0 0;
    box-sizing: border-box;
}
</style>