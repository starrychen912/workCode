<template>
  <el-container>
      <el-header :class="{'el_header--bg':mode === 'mobile' }">
          <sidebar :LogoName="title">
                <template #Seacrch></template>
          </sidebar>
      </el-header>
      <el-main class="flex">
        <el-col  :xs="20" :sm="20" :md="16" :lg="14" :xl="14" class="container-fainal">
          <div class="header---title-s">
              <button-r></button-r>
          </div>
          <div class="add_storeshop-list">
              <div class="el_from--card">
               <el-form ref="form" :model="form"  :rules="rules" label-width="100px">
                  <el-form-item label="店铺名称" prop="name">
                    <el-input v-model="form.name" @input="foreceUpdate"></el-input>
                  </el-form-item>
                  <el-form-item label="店铺域名" prop="myshopify_domain">
                    <el-input v-model="form.myshopify_domain"></el-input>
                  </el-form-item>
                  <el-form-item label="店铺地址">
                    <el-input v-model="form.address1"></el-input>
                  </el-form-item>
                  <!-- <el-form-item label="apiKey">
                    <el-input v-model="form.apiKey"></el-input>
                  </el-form-item>
                  <el-form-item label="apiSecretKey">
                    <el-input v-model="form.apiSecretKey"></el-input>
                  </el-form-item> -->
                  <el-form-item label="店铺类型">
                    <el-select v-model="form.type" placeholder="请选择店铺类型">
                      <el-option label="shopify" value="shopify"></el-option>
                      <el-option label="amazon" value="amazon"></el-option>
                    </el-select>
                  </el-form-item>
                  <!-- <el-form-item label="">
                    <el-input v-model="form.sku"></el-input>
                  </el-form-item> -->
                   <el-form-item label="店铺区域">
                    <el-select v-model="form.region" placeholder="请选择店铺区域">
                      <el-option label="区域一" value="shanghai"></el-option>
                      <el-option label="区域二" value="beijing"></el-option>
                    </el-select>
                  </el-form-item>
                  
                  <el-form-item label="是否上线">
                      <el-switch v-model="form.delivery"></el-switch>
                    </el-form-item>
                  <el-form-item label="店铺介绍">
                    <el-input v-model="form.desc" type="textarea"></el-input>
                  </el-form-item>
                  <el-form-item>
                    <!-- <el-button type="primary" >Create</el-button> -->
                    <div class="flex cancel-create-btn">
                      <loding-btn @click="Create"  :btnsize="''" @LoadBTN="goBack">取消</loding-btn>
                      <loding-btn @click="Create" type="primary" :btnsize="''" @LoadBTN="Create">确定</loding-btn>
                    </div>
                  </el-form-item>
                </el-form>
            </div>
          </div>
        </el-col>
      </el-main>
      </el-container>
</template>

<script>
import { reactive, toRefs ,computed} from 'vue'
import { Plus } from '@element-plus/icons'
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue';
import router from '../../router';
import ButtonR from '../../components/Bottom/buttonR.vue';
import LodingBtn from '../../components/lodingBtn/index.vue';
import { AddShop ,updateShop} from '../../api/shoplist';
import { shoElmessage } from '../../utils/Elmessage';
// import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import { isNaLL } from '../../utils/utils';
export default {
  components:{ Sidebar, Plus, ButtonR, LodingBtn },
  data(){
    return{
      title:"新增店铺",
      form:{
              shop_id:"",
              name: '',
              address1:"",
              myshopify_domain:'',
              apiKey:"",
              apiSecretKey:"",
              region: '',
              date1: '',
              date2: '',
              delivery: false,
              type: "",
              resource: '',
              desc: '',
            },
            rules:{
              name:[
                { required: true, message: '请输入店铺名称', trigger: 'blur' },
              ]
            },
            
    }
  },
  setup(){
    const store = useStore();
    const data = reactive({
      mode:computed(() => store.state.setting.device.mode)
    })
    return {
      ...toRefs(data)
    }
  },
  mounted(){
      if(isNaLL(this.$route.query)){
        if(Object.keys(this.$route.query).length){
            this.title = "修改店铺"
            this.form = {
              shop_id:this.$route.query.id,
              name: this.$route.query.name,
              address1:this.$route.query.address1,
              myshopify_domain:this.$route.query.myshopify_domain,
              apiKey:this.$route.query.apiKey,
              apiSecretKey:this.$route.query.apiSecretKey,
              type:this.$route.query.type,
            }
        }else{
            this.title = '新增店铺'
        }
      }
      
  },
  methods:{
    foreceUpdate(){
      this.$forceUpdate()
    },
    Create(){
        if(this.title == '新增店铺'){
            AddShop({
              name:this.form.name,
              address1:this.form.address1,
              myshopify_domain:this.form.myshopify_domain,
              apiKey:this.form.apiKey,
              apiSecretKey:this.form.apiSecretKey,
              type:this.form.type,
            }).then((result) => {
                if(result.code == 1){
                    shoElmessage(true,'新增店铺成功')
                    this.goBack();
                }else{
                    shoElmessage(true,'新增店铺失败','error')
                }
            }).catch((err) => {
              
            });
        }else{
            updateShop({
              ...this.form
            }).then(res =>{
                if(res.code == 1){
                    shoElmessage(true,'修改店铺成功')
                    this.goBack();
                }else{
                    shoElmessage(true,`修改店铺失败,原因：${res.msg}`,'error')
                }
            })
        }
    },
    goBack(){
        router.go(-1)
    }
  }
  
}
</script>

<style scoped lang="scss">
.el-header{
  background-color: #fff;
}
.container-fainal{
    margin:0 auto;
    width: 100%;
}
.el_from--card{
    padding: 2rem;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 
            //  0.2em 0.2em -0.2em rgba(180, 180, 180, 0.3),
            0 0 4px 0 rgba(0, 0, 0, 0.2);
}
.add_storeshop-list{
  margin-top: 10px;
}
.cancel-create-btn{
  justify-content: flex-end;
  .lodingBtn{
    margin-left: 10px;
  }
}
</style>