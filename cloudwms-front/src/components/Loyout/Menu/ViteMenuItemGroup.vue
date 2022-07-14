<template>
    <el-menu-item-group :title="Title">
        <slot>

        </slot>
      </el-menu-item-group>
</template>

<script>
export default {
    name:"ViteMenuItemGroup",
    props:{
        Title:{
            type:[String,Number],
            default:'Group Two'
        }
    },
    setup(){
        
    }
}
</script>

<style lang="scss" scoped>

</style>