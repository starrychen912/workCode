<template>
  <el-sub-menu v-if="content.list != 0">
    <template #title>{{content.meta.title}}</template>
      <menu-vite v-for="(item,index) in content.list" :key="index" :content="item" ></menu-vite>
  </el-sub-menu>
  <el-menu-item v-else>
      {{content.meta.title}}
  </el-menu-item>
</template>

<script>
import { reactive,toRefs } from 'vue-demi'
export default {
  props:{
    activeindex:{
      type:String,
      default:1
    },
    title:{
      type:String,
      default:"默认名字"
    },
    content:{
      type:[Object,Array],
      default:{},
    }
  },
  setup(props,conent){
    const data = reactive({
      
    })
    return{
      ...toRefs(data)
    }
  }
}
</script>

<style scoped lang="scss">
.el-menu--horizontal>.el-menu-item.is-active{
  border-bottom: 4px solid var(--el-color-primary);
}
</style>