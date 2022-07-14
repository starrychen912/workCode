<template>
    <el-row>
      <collections :Sharestart="false" ></collections>
    </el-row>
    <el-col  :xs="20" :sm="20" :md="16" :lg="14" :xl="14" class="container-fainal">
      <div class="container--content">
          <div class="content">
              <div class="el-breadcrumb">
                <el-breadcrumb separator="/">
                  <el-breadcrumb-item  :to="{ path: '/Officialwebsite/'+item }"  v-for="(item,index) in Routelist" :key="index" v-if="index != 0" >
                    <span >{{item}}</span>
                  </el-breadcrumb-item>
                </el-breadcrumb>
              </div>  
              <el-card>
                  <div class="intercom-reaction-picker" dir="ltr">
                        <div class="intercom-reaction-prompt">Did this answer your question?</div>
                        <button class="intercom-reaction" data-reaction-text="disappointed" tabindex="0" aria-label="Disappointed Reaction">
                            <span data-emoji="disappointed" title="Disappointed">😞</span>
                        </button>
                        <button class="intercom-reaction" data-reaction-text="neutral_face" tabindex="0" aria-label="Neutral face Reaction">
                            <span data-emoji="neutral_face" title="Neutral face">😐</span>
                        </button>
                        <button class="intercom-reaction" data-reaction-text="smiley" tabindex="0" aria-label="Smiley Reaction">
                            <span data-emoji="smiley" title="Smiley">😃</span>
                        </button>
                    </div>
              </el-card>
          </div>
        </div>
    </el-col>
    
</template>

<script>
import collections from '../../components/collectionsheader/collections.vue'
import { useRoute } from 'vue-router'
import { computed } from 'vue-demi';
export default {
  components: { collections },
  setup(){
     const route = useRoute();
     
     let Routelist = computed(()=> {
         let list = [];
         let path = route.path
         console.log(route.path);
         return route.path;
     })
     return {
         Routelist:computed(()=>{
             let list = [];
             let routelist = route.path.split('/')
             for(let i=0; i<routelist.length;i++){
                 if(i != 0){
                    list.push(routelist[i])
                 }
             }
            return list

         })
     }
  }
}
</script>

<style lang="scss" scoped>
.el-card__body{
    box-sizing: border-box;
}
*{
    box-sizing: border-box;
}
.container-fainal {
    float: none;
    margin: 0 auto;
}
.content {
    padding-top: 20px;
}
.el-breadcrumb {
    padding-bottom: 10px;
}
.intercom-reaction-picker .intercom-reaction-prompt {
    padding-top: 9px;
    padding-bottom: 4px;
    text-align: center;
}
.intercom-reaction-picker {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    padding: 12px;
    text-align: center;
    color: #777;
    background-color: #f0f3f5;
    border-radius: 8px;
}
.intercom-reaction-picker .intercom-reaction {
    background: none;
    color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    cursor: pointer;
    outline: none;
    width: 50px;
    height: 100%;
    display: inline-block;
    text-align: center;
    font-size: 32px;
    -webkit-transition: -webkit-transform 0.16s cubic-bezier(0.65, 0.61, 0.18, 1.8) 0.02s,-webkit-filter 0.32s linear;
    transition: -webkit-transform 0.16s cubic-bezier(0.65, 0.61, 0.18, 1.8) 0.02s,-webkit-filter 0.32s linear;
    -o-transition: transform 0.16s cubic-bezier(0.65, 0.61, 0.18, 1.8) 0.02s,filter 0.32s linear;
    transition: transform 0.16s cubic-bezier(0.65, 0.61, 0.18, 1.8) 0.02s,filter 0.32s linear;
    transition: transform 0.16s cubic-bezier(0.65, 0.61, 0.18, 1.8) 0.02s,filter 0.32s linear,-webkit-transform 0.16s cubic-bezier(0.65, 0.61, 0.18, 1.8) 0.02s,-webkit-filter 0.32s linear;
    cursor: pointer;
    -webkit-transform-origin: 50% 60%;
    -ms-transform-origin: 50% 60%;
    transform-origin: 50% 60%;
    &:hover{
        
    }
}
.intercom-reaction-picker .intercom-reaction:hover, .intercom-reaction-picker .intercom-reaction:focus {
    -webkit-transform: scale(1.32);
    -ms-transform: scale(1.32);
    transform: scale(1.32);
    -webkit-transition: -webkit-transform .04s;
    transition: -webkit-transform .04s;
    -o-transition: transform .04s;
    transition: transform .04s;
    transition: transform .04s, -webkit-transform .04s;
}
.intercom-reaction-picker-reaction-selected .intercom-reaction {
    -webkit-filter: grayscale(100%);
    filter: grayscale(100%);
}
.intercom-reaction-picker .intercom-reaction span {
    cursor: pointer;
    line-height: 55px;
}
</style>