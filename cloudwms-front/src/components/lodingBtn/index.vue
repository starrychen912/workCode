<template>
  <div class="lodingBtn" >
      <el-button :type="type" :size="btnsize" style="width:100%;" :loading="loading" @click.stop="BtnMethods" :disabled="disabled">
          <i class="el-icon-plus" v-if="iconStatus && !loading"></i>
          <span>{{Btname}}</span>
          <slot></slot>
      </el-button>                                   
  </div>
</template>

<script>import { reactive, toRefs } from "vue-demi"

export default {
  emits:['LoadBTN'],
  props:{
     iconStatus:{
       type:Boolean,
       default:false,
     },
     Btname:{
       type:String,
       default:''
     },
     btnsize:{
      type:String,
      default:"small"
    },
    type:{
       type:String,
       default:''
    },
    disabled:{
       type:Boolean,
       default:false
    }
  },
  setup(props,content){
      function BtnMethods(){
        data.loading = true;
        setTimeout(()=>{
          data.loading = false;
        },1000)
        content.emit('LoadBTN')
      }
      const data = reactive({
        loading:false,
      })
      return{
        ...toRefs(data),
        BtnMethods
      }
  }

}
</script>

<style scoped lang="scss">
.loaddingbutton{
  span{
    margin-left: 10px;
    font-weight: bold;
    font-size: 14px;
  }
}
.el-icon-plus{
    font-weight: bold;
    font-size: 14px;
}




</style>