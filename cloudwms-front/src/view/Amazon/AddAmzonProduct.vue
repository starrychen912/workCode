<template>
    <el-container>
        <el-header>
          <sidebar LogoName="添加库存"></sidebar>
        </el-header>
        <el-main>
          <div class="property-content flex align-center flex-wrap" ref="property">
              <template v-if="more_property">
                <div class="property-list flex align-center"  v-for="(item,index) in propertylist" :key="index" @click.stop="PropertyToggle(index,item)" >
                    <i class="el-icon-warning" v-if="more_propertylist.indexOf(item) != -1"></i>
                    <span>{{item.name}}</span>
                    <span class="property_before" :class="{'propertyactive':Activeindex != index}" ></span>
                </div>
              </template>
              <template v-else>
                  <div class="property-list flex align-center"  v-for="(item,index) in more_propertylist" :key="index" @click.stop="PropertyToggle(index,item)" >
                      <i class="el-icon-warning" v-if="more_propertylist.indexOf(item) != -1"></i>
                      <span>{{item.name}}</span>
                      <span class="property_before" :class="{'propertyactive':Activeindex != index}" ></span>
                  </div>
              </template>
          </div>
          <div class="property_content">
              <div class="more_property flex align-center">
                  <el-switch
                    v-model="more_property"
                  >
                  </el-switch>
                  <span>更多属性</span>
              </div>
              <div class="information-title">
                  <div class="title">
                      <span>艺术品、工艺品和</span>
                      <i class="el-icon-arrow-right"></i>
                  </div>
              </div>
              <information v-if="Activename == '重要信息'"></information>
              <variants v-if="Activename == '变体'"></variants>
              <quotedprice v-if="Activename == '报价'"></quotedprice>
              <compliance-information v-if="Activename == '合规信息'"></compliance-information>
              <amazonpicture v-if="Activename == '图片'"></amazonpicture>
              <keyword v-if="Activename == '关键字'"></keyword>
              <description v-if="Activename == '描述'"></description>
              <moredetails v-if="Activename == '更多详情'"></moredetails>
          </div>   
        </el-main>
    </el-container>
</template>

<script>
import { reactive, toRefs ,ref, onMounted} from "vue"
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
import Information from "./components/information.vue"
import Quotedprice from "./components/quotedprice.vue"
import Variants from "./components/Variants.vue"
import Amazonpicture from "./components/Amazonpicture.vue"
import ComplianceInformation from "./components/ComplianceInformation.vue"
import Keyword from "./components/Keyword.vue"
import Description from "./components/description.vue"
import Moredetails from "./components/Moredetails.vue"

export default {
    components:{
    Sidebar,
    Information,
    Quotedprice,
    Variants,
    Amazonpicture,
    ComplianceInformation,
    Keyword,
    Description,
    Moredetails
},
    setup(props,content){
      const data = reactive({
          Activeindex:0,
          Activename:"重要信息",
          more_property:false,
          more_propertylist:[
            {
              name:"重要信息",
            },{
              name:"变体",
            },{
              name:"报价",
            },{
              name:"图片",
            }
          ],
          propertylist:[
            {
              name:"重要信息",
            },{
              name:"变体",
            },{
              name:"报价",
            },{
              name:"合规信息",
            },{
              name:"图片",
            },{
              name:"描述",
            },{
              name:"关键字",
            },{
              name:"更多详情",
            },
          ],

      })
      function PropertyToggle(index,item){
        event.stopPropagation();
        data.Activeindex = index
        data.Activename = item.name
      }
      
      return {
        ...toRefs(data),
        PropertyToggle
      }
    },
}
</script>

<style scoped lang="scss">
.el-header{
  background-color: #fff;
}
.property-content{
  width: 100%;
  // height: 70px;
  background-color: #fff;
  justify-content: center;
  box-sizing: border-box;
  border:1px solid #d5dbdb;
}
.property-list{
  padding: 20px 15px;
  box-sizing: border-box;
  cursor: pointer;
  position: relative;
  i{
    margin-right: 5px;
    color: rgb(206, 70, 60);
    font-size: 18px;
    pointer-events: none;
  }
  span{
    pointer-events: none;
  }
}
.Activeproperty{
  border-bottom: 4px solid #00a2ff;
}
.property_before{
  display: block;
  height: 4px;
  background-color: #00a2ff;
  position: absolute;
  bottom: 0px;
  width: 100%;
  left: 0;
  animation: beforeanim 0.5s;
}
// @keyframes beforeanim {
//   0%{
//     width: 0%;
//   }
// }
.propertyactive{
  width: 0%;
  animation: beforeactive 0.5s;
  right: 0;
  left: 100%;
}
// @keyframes beforeactive {
//   0%{
//     width: 100%;
//     left: 0%;
//   }
// }
.property_content{
  // background-color: #fff;
  height: auto;
  margin-top: 5px;
  // border: 1px solid #d5dbdb;
}
.more_property{
  padding: 20px 15px; 
  display: flex;
  flex-direction: row-reverse;
  border: 1px solid #d5dbdb;
  border-bottom: 0px;
  background-color: #fff;
  span{
    margin-right: 10px;
    padding-bottom: 2px;
  }
}
.information-title{
  padding: 20px 20px;
  border: 1px solid #d5dbdb;
  border-bottom: 0px;
  background-color: #fff;
}

.property-content{
  position: relative;
  
}
.property_content-span{
    display: block;
    height: 4px;
    background-color: #00a2ff;
    width: 130px;
    position: absolute;
    bottom: 0px;
    left: 0px;
  }


</style>