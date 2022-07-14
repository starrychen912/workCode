<template>
  <el-breadcrumb>
    <transition-group name="breadcrumb">
      <el-breadcrumb-item v-for="(item,index) in levelList" :key="index">
        <h1>{{item.meta.title}}</h1>
      </el-breadcrumb-item>
    </transition-group>
  </el-breadcrumb>
</template>

<script>
import { computed, reactive, toRefs } from 'vue'
import { useRoute } from 'vue-router'
export default {
  created(){
    this.getBreadcrumb();
  },
  setup(props,content){
    const route = useRoute();
    const data = reactive({
      levelList:[{},{},{}]
    })
    
    function getBreadcrumb(){
       data.levelList = computed(() => route.matched.filter(item => item.meta && item.meta.title))
    }
    return{
      ...toRefs(data),
      getBreadcrumb
    }
  }
}
</script>

<style lang="scss" scoped>
.el-breadcrumb{
  display: flex;
  float: none;
  align-items: center;
  .el-breadcrumb__item{
    display: flex;
    float: none;
    align-items: center;
  }
}
</style>