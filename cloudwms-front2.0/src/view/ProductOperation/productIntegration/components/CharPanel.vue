<template>
  <vite-dialog
    v-model="chatpanelVisible" :title="title" @ViteClose="ViteClose" width="50%" CustomClass="charpanel"
  >
    <div class="content" v-if="developmentlist.length > 0">
        <chat v-for="(item,index) in developmentlist" :key="index" :chatlist="item" :activeindex="index" :showstatus="true" @change="handChange" :responsible_person_list="responsible_person_list" ></chat>
    </div>
    <div class="content" style="background-color:#fff;" v-else>
      <el-empty></el-empty>
    </div>
    <template #footer>
        <el-button type="primary" @click="AddAffair('Explanationdialog_status')" > 新增事务</el-button>
        <el-button  @click="ViteClose" > 关闭</el-button>
    </template>
  </vite-dialog>
  <add-affair 
    v-model="Explanationdialog_status"
    ref="addaffair"
    @CloseBusinesses="CommenClose('Explanationdialog_status')"
    :responsible_person_list="responsible_person_list"
  >
  </add-affair>
</template>
<script>
import ViteDialog from '../../../../components/ViteDialog/index.vue'
import { reactive, toRefs ,ref} from 'vue'
import {GetproductDetail} from '@/api/productDevelopmentList.js'
import chat from './chat.vue'
import AddAffair from '../../../affair/components/Addaffair.vue'
import Empty from '@/components/empty/index.vue'
import { purchaseDetail} from "@/api/purchasingMan";
export default {
  components:{
    ViteDialog,
    chat,
    AddAffair,
    Empty
  },
  props:{
    chatpanelVisible:{
      type:Boolean,
      default:true,
    },
    responsible_person_list:{
      type:Boolean,
      default:[],
    }
  },
  setup(props,content){
    const addaffair = ref(null)
    const data = reactive({
      title:"事务列表",
      developmentlist:[],
      Explanationdialog_status:false,
      detail_item:{},
    })
    function ViteClose(){
      content.emit('CharDialogClose','chatpanelVisible')
    }
    function Init(item){
      data.detail_item = item
      if(item.type == 1){
        GetproductDetail({
          product_development_id:item.id,
        }).then(res =>{
          if(res.code == 1){
            data.developmentlist = res.data.data.transactions || []
          }
        })
      }else{
        purchaseDetail({
          order_id:item.id,
        }).then(res =>{
          if(res.code == 1){
            console.log(res)
            data.developmentlist = res.data.data.transactions || []
          }
        })
      }
    }
    function AddAffair(Key){
      data[Key] = true
      //新增事务默认为产品研发
      addaffair.value.Init({
        id:data.detail_item.id,
        type:data.detail_item.type,
      })
    }
    function CommenClose(Key){
      data[Key] = false
      Init(data.detail_item)
    }
    function handChange(){
      Init(data.detail_item)
    }
    return{
      ...toRefs(data),
      ViteClose,
      Init,
      AddAffair,
      addaffair,
      handChange,
      CommenClose
    }
  }
}
</script>
<style lang="scss" scoped>
.content{
  height: 75vh;
  overflow: auto;
  background-color: #ebebeb;
  padding: 0px 20px;
}
</style>