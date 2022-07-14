<template>
    <div class="navtions-icon" @click="goBack">
          <i :class="Icon"></i>
    </div>
</template>

<script>
import router from "../../router"
export default {
  props:{
    Icon:{
      type:String,
      default:"el-icon-back"
    }
  },
  setup(props,content){
    function goBack(){
      router.go(-1)
    }
    return{
      goBack
    }
  }
}
</script>

<style scoped lang="scss">
.navtions-icon{
        width: 35px;
        height: 35px;
        line-height: 38px;
        // border: 1px solid rgba(186, 191, 195, 1);
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 0 4px 0 rgb(0 0 0 / 20%);
        background-color: #fff;
        i{
            font-size: 20px;
            font-weight: bold;
            color: rgba(109, 113, 117, 1);
        }
    }
</style>  