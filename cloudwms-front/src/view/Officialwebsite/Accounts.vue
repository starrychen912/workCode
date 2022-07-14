<template>
    <el-row>
      <collections :Sharestart="false" ></collections>
    </el-row>
    <el-col  :xs="20" :sm="20" :md="16" :lg="14" :xl="14" class="container-fainal">
      <div class="container--content">
          <div class="content ">
              <div class="el-breadcrumb">
                <el-breadcrumb separator="/">
                  <el-breadcrumb-item :to="{ path: '/Officialwebsite/'+item }"  v-for="(item,index) in Routelist" :key="index">{{item}}</el-breadcrumb-item>
                </el-breadcrumb>
              </div>
              <div class="section__bg">
                <el-card class="is-always-shadow">
                    <div class="section_collection--title">
                        <div class="section_collection--svg">
                            <svg role="img" viewBox="0 0 48 48"><g id="biz-shop" fill="none" fill-rule="evenodd"><path d="M43 19.625V44H5V19.625" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M25 38H9V26h16v12zm14 6H29V26h10v18zm4-40H5l-4 8h46l-4-8zm4 10a6 6 0 0 1-6 6c-1.652 0-2.914-.92-4-2-1.416 2.25-4.146 4-7 4a7.973 7.973 0 0 1-6-2.72A7.97 7.97 0 0 1 18 22c-2.854 0-5.584-1.75-7-4-1.084 1.08-2.348 2-4 2a6 6 0 0 1-6-6v-2h46v2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11 18v-6l2-8m11 15.28V4m13 14v-6l-2-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M35 35a1 1 0 1 0 0 2 1 1 0 0 0 0-2" fill="#231F1F"></path></g></svg>
                        </div>
                        <div class="section-collection--title">
                           <div class="Intro_h1">
                             Intro to Oberlo
                           </div>
                           <div class="paper__preview">
                             Learn about Oberlo and dropshipping
                           </div>
                           <div class="avatar">
                               <div class="avatar__photo avatars__images o__ltr">
                                  <img class="avatar__image" src="https://static.intercomassets.com/avatars/2205749/square_128/gravatar-1559737862.jpeg?1559737862">
                               </div>
                               <div class="avatar_info">
                                  <div>5 articles in this collection</div>
                                  Written by
                                  <span>Zan</span>
                                  and
                                  <span> Karolis</span>
                               </div>
                           </div>
                        </div>
                    </div>
                </el-card>
                <div class="g_space">
                    <div class="section__headline">
                      <div class="section__content intercom-force-break"> Oberlo and dropshipping</div>
                    </div>
                    <div class="dropshiping">
                        <el-card @click="CardPing">
                            <div class="article__preview intercom-force-break">Intro to dropshipping with Oberlo</div>
                            <span class="paper__preview c__body">Learn about dropshipping with Oberlo.</span>
                            <div class="avatar">
                               <div class="avatar__photo avatars__images o__ltr">
                                  <img class="avatar__image" src="https://static.intercomassets.com/avatars/2205749/square_128/gravatar-1559737862.jpeg?1559737862">
                               </div>
                               <div class="avatar_info">
                                  <div>5 articles in this collection</div>
                                  Written by
                                  <span>Zan</span>
                                  and
                                  <span> Karolis</span>
                               </div>
                           </div>
                        </el-card>
                        <el-card>
                            <div class="article__preview intercom-force-break">Intro to dropshipping with Oberlo</div>
                            <span class="paper__preview c__body">Learn about dropshipping with Oberlo.</span>
                            <div class="avatar">
                               <div class="avatar__photo avatars__images o__ltr">
                                  <img class="avatar__image" src="https://static.intercomassets.com/avatars/2205749/square_128/gravatar-1559737862.jpeg?1559737862">
                               </div>
                               <div class="avatar_info">
                                  <div>5 articles in this collection</div>
                                  Written by
                                  <span>Zan</span>
                                  and
                                  <span> Karolis</span>
                               </div>
                           </div>
                        </el-card>
                        <el-card>
                            <div class="article__preview intercom-force-break">Intro to dropshipping with Oberlo</div>
                            <span class="paper__preview c__body">Learn about dropshipping with Oberlo.</span>
                            <div class="avatar">
                               <div class="avatar__photo avatars__images o__ltr">
                                  <img class="avatar__image" src="https://static.intercomassets.com/avatars/2205749/square_128/gravatar-1559737862.jpeg?1559737862">
                               </div>
                               <div class="avatar_info">
                                  <div>5 articles in this collection</div>
                                  Written by
                                  <span>Zan</span>
                                  and
                                  <span> Karolis</span>
                               </div>
                           </div>
                        </el-card>
                    </div>
                    <div class="section__headline">
                      <div class="section__content intercom-force-break"> Oberlo integrations</div>
                    </div>
                    <div class="dropshiping">
                        <el-card>
                            <div class="article__preview intercom-force-break">Intro to dropshipping with Oberlo</div>
                            <span class="paper__preview c__body">Learn about dropshipping with Oberlo.</span>
                            <div class="avatar">
                               <div class="avatar__photo avatars__images o__ltr">
                                  <img class="avatar__image" src="https://static.intercomassets.com/avatars/2205749/square_128/gravatar-1559737862.jpeg?1559737862">
                               </div>
                               <div class="avatar_info">
                                  <div>5 articles in this collection</div>
                                  Written by
                                  <span>Zan</span>
                                  and
                                  <span> Karolis</span>
                               </div>
                           </div>
                        </el-card>
                        <el-card>
                            <div class="article__preview intercom-force-break">Intro to dropshipping with Oberlo</div>
                            <span class="paper__preview c__body">Learn about dropshipping with Oberlo.</span>
                            <div class="avatar">
                               <div class="avatar__photo avatars__images o__ltr">
                                  <img class="avatar__image" src="https://static.intercomassets.com/avatars/2205749/square_128/gravatar-1559737862.jpeg?1559737862">
                               </div>
                               <div class="avatar_info">
                                  <div>5 articles in this collection</div>
                                  Written by
                                  <span>Zan</span>
                                  and
                                  <span> Karolis</span>
                               </div>
                           </div>
                        </el-card>
                        <el-card>
                            <div class="article__preview intercom-force-break">Intro to dropshipping with Oberlo</div>
                            <span class="paper__preview c__body">Learn about dropshipping with Oberlo.</span>
                            <div class="avatar">
                               <div class="avatar__photo avatars__images o__ltr">
                                  <img class="avatar__image" src="https://static.intercomassets.com/avatars/2205749/square_128/gravatar-1559737862.jpeg?1559737862">
                               </div>
                               <div class="avatar_info">
                                  <div>5 articles in this collection</div>
                                  Written by
                                  <span>Zan</span>
                                  and
                                  <span> Karolis</span>
                               </div>
                           </div>
                        </el-card>
                    </div>
                </div>
              </div>
              
          </div>
        </div>
    </el-col>
    
</template>

<script>
import { computed } from 'vue'
import collections from '@/components/collectionsheader/collections.vue'
import router from '@/router'
import { useRoute } from 'vue-router'
export default {
  components: { collections },
    setup(){
      const route = useRoute();
      function CardPing(){
         router.push({
           path:'/Officialwebsite/Accounts/dropshippingdetail',
           query:{}
         })
      }
      return {
          CardPing,
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
:deep(.el-card){
  border-radius: 0px;
  margin-top: -2px;
  cursor: pointer;
  // border: none;
  // border-bottom: 1px solid #818a97;
}
*{
  box-sizing: border-box;
}
.is-always-shadow{
  box-shadow: none;
}
.container-fainal{
  float: none;
  margin:0 auto;
}

.container--content{
  max-width: 100%;
  // width: ;
}
.content{
  padding-top: 20px;
}
.section__bg{
    padding-top: 0;
    // padding-bottom: 26px;
    position: relative;
}
.el-breadcrumb{
  padding-bottom: 10px;
}
.section__bg::before{
    content: ' ';
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: #ebeef1;
    border-radius: 4px;
    -webkit-transition: background .3s;
    -o-transition: background .3s;
    transition: background .3s;
    z-index: 0;
}
.section_collection--title{
  position: relative;
  display: flex;
  flex-wrap: wrap;
}
.section_collection--svg{
  width: 120px;

  display: flex;
  align-items: center;
  justify-content: center;
  // position: absolute;
  // left: 0px;
  // top: 0px;
   svg{
     stroke: #818a97;
     width: 48px;
     height: 48px;
   }
}
.Intro_h1{
  font-size: 30px;
  color: #3a3c4c;
  margin:0 0 17px;
}
.paper__preview{
    margin: 5px 0 11px;
    display: block;
    max-width: 630px;
    line-height: 1.4;
}
.avatar{
  font-size: 13px;
  color: #8f919d;
  margin-top: 4px;
  display:flex;
  flex-wrap: wrap;
}
.avatar__photo{

}
.avatar__image{
  width: 32px;
  height: 32px;
  vertical-align: bottom;
  border-radius: 50%;
  -webkit-box-shadow: 0 0 0 2px white;
  box-shadow: 0 0 0 2px white;
  position: relative;
  z-index: 4;
}
.avatar_info{
  margin-left: 10px;
}
.g_space{
  position: relative;
  z-index: 1;
  margin-top: 16px;
}
.section__headline{
    padding: 16px 30px 11px;
    margin: -5px 0;
    color: #3a3c4c;
    font-weight: 600;
    letter-spacing: .02em;
    font-size: 18px;
    position: relative;
    padding-left: 20px;
    padding-right: 20px;
    margin-left: 10px;
    margin-right: 10px;
}
.dropshiping{
    margin-left: 30px;
    margin-right: 30px;
    padding-bottom: 30px;
}
.c__body{
  color: #8f919d;
}
@media only screen and (max-width: 768px){
    .section_collection--svg{
      width: 100%;
    }
    .dropshiping{
      margin-left: 20px;
      margin-right: 20px;
    }
    .section__headline{
      margin-left: 0px;
      margin-right: 0px;
    }
}
</style>