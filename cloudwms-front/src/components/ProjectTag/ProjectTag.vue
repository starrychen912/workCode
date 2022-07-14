<template>
  <div class="projecttag" :style="TagStyle">
      <span>{{TagName}}</span>
  </div>
</template>

<script>
export default {
    name:"ProjectTag",
    props:{
        TagName:{
            type:String,
            default:'Step 1'
        },
        TagStyle:{
            type:Object,
            default:{
                'border-radius':'10px',
                'background-color':'rgb(108,253,180)',
                'font-weight':'bold'
            }
        }
    },
    setup(props,context){
        
    }
}
</script>

<style scoped lang="scss">
.projecttag{
    width: 100%;
    height: auto;
    line-height: normal;
    padding: 2px 5px;
    margin-top: 15px;

}
</style>