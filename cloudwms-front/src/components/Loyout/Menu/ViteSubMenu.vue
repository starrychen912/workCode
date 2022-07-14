<template>
  <el-sub-menu :index="ActiveIndex">
      <template #title >
            <div class="el">
                <i :class="ICon"></i>
            </div>
            <span >{{TempName}}</span>
      </template>
      <slot name="children">

      </slot>
  </el-sub-menu>
</template>

<script>
export default {
    name:"ViteSubMenu",
    props:{
        ActiveIndex:{
            type:[String,Boolean,Number,Array,Object],
            default:"1"
        },
        ICon:{
            type:String,
            default:'el-icon-s-home'
        },
        TempName:{
            type:[String,Number,Array,Object],
            default:"首页"
        },
    },
    setup(){
        
    }

}
</script>

<style>

</style>