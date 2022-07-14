<template>
    <div class="main-empty"  v-loading="loading">
          <img src="@/assets/svg/empty.svg">
          <div class="text">{{content}}</div>
    </div>
</template>

<script>
import { reactive,onMounted,toRefs} from 'vue'
export default {
  name:"empty",
  props:{
    content:{
      type:String,
      default:"订单为空~"
    }
  },
  setup(){
    const data = reactive({
      loading:false,
    })
    return{
      ...toRefs(data)
    }
  }
}
</script>

<style scoped lang="scss">
.main-empty{
    width: 100%;
    height: 100%;
    // background-color: #fff;
    text-align: center;
    display:flex;
    align-items: center;
    align-content: center;
    flex-wrap: wrap;
    justify-content: center;
    img{
        width: 300px;
        height: 300px;
    }
    .text{
        width: 100%;
    }
}
</style>