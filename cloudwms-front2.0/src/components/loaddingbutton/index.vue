<template>
  <div class="loaddingbutton" :class="{'ladding--type':loading}">
      <el-button :type="type" :size="btnsize" style="width:100%;" :loading="loading" @click.stop="BtnMethods">
          <i class="el-icon-plus" v-if="iconStatus && !loading"></i>
          <span>{{Btname}}</span>
      </el-button>                                   
  </div>
</template>

<script>
import { reactive,toRefs } from "vue"
export default {
  emits:['LoddingBtn'],
  props:{
    Btname:{
        type:String,
        default:'按钮'
    },
    iconStatus:{
        type:Boolean,
        default:true
    },
    btnsize:{
      type:String,
      default:"small"
    },
    type:{
       type:String,
       default:'info'
    },
    loading:{
      type:Boolean,
      default:false
    }
  },
  setup(props,{emit}){
     const data = reactive({
        loading:false,
     })
     function BtnMethods(){
        // data.loading = true;
        // setTimeout(()=>{
        //    data.loading = false
        //     emit('LoddingBtn')
        // },3000)
        emit('LoddingBtn',!props.loading)
     }
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
.el-col-list .product-card-actions{
    .loaddingbutton{
        opacity: 0;
        margin-top: 15px;
        transition: all 0.5s;
    }
}
.el-col-list:hover .product-card-actions{
  .loaddingbutton{
      transition: all 0.5s;
      margin-top: 30px;
      opacity: 1;
    }
}
.el-col-list .product-card-actions {
    .ladding--type{
        opacity: 1;
        margin-top: 30px;
    }
}

</style>