<template>
    <!-- <div class="el--content">
       <div class="el_content--title">
          Order List
        </div>     
    </div> -->
    <div class="main-content-main user--product" :class="{'product--orderlist':_activeindex != 3}">
      <div class="main-title flex align-center justify-between">        
            <el-checkbox v-model="checkAll" :indeterminate="isIndeterminate" @change="onchangecheckout">全选</el-checkbox>
            <div class="el-dropdown--import flex align-center" >
                <div class="flex align-center button--add" style="min-width:200px;" >
                    <label class="el-drop--label">导入平台：</label>
                    <el-dropdown split-button type="primary" trigger="click" size="medium">
                    商品管理
                    <template #dropdown>
                        <el-dropdown-menu >
                          <el-dropdown-item>商品管理</el-dropdown-item>
                          <el-dropdown-item>亚马逊管理</el-dropdown-item>
                          <el-dropdown-item>shopify管理</el-dropdown-item>
                        </el-dropdown-menu>
                    </template>
                  </el-dropdown>
                </div>
                <div class="medium--input-search ">
                  <el-input class="button--add" size="medium" v-model="input" placeholder="请输入内容"></el-input>
                  <el-button class="button--add" type="primary" icon="el-icon-search" size="medium">查找</el-button>
                </div>
                <el-button class="button--add"  size="medium">同步</el-button>
                <el-button class="button--add" size="medium">商品调价</el-button>
                <el-button class="button--add" size="medium">商品导出</el-button>
            </div>
        </div>
        <div class="content--list" :class="{'content-empty':list.length == 0}" v-loading="loading">
            <block v-if="list.length > 0 && Object.keys(list).length > 0">
                <products 
                  v-for="(item,index) in list" 
                  :key="index" 
                  :product="item"
                  :index="index"
                  @ProductClisk="ProductClisk" 
                  :checkbox="checkStatus[item.id]" 
                  :checkStatus="checkStatus" 
                  :id="item.id"  
                  @oncheckboxchange="oncheckboxchange"
                ></products>
            </block>
            
            <div class="content_list--empty" v-else>
                <img src="@/assets/svg/empty.svg">
                <div>订单是空的~</div>
            </div>
        </div>
    </div>       
</template>

<script>
import { reactive, toRefs ,onMounted,watch} from 'vue'
import Products from './product.vue'
import { interfalse,interCheckall,interlll,interobj } from '../../../../utils/utils'

export default {
  components: { Products },
  name:"UserProduct",
   props:{
    _activeindex:{
      type:[String,Number],
      default:1,
    }
  },
  setup(props,content){
    const data = reactive({
      activeindex:1,
      isIndeterminate:false,
      list:[

      ],
      checkStatus:{},
      checkAll:false,
    })
     onMounted(() =>{
       data.checkStatus = interfalse(data.list,'id');
    })
    watch(
      () => data.checkStatus,
      (newval,oldval) =>{
        if(interlll(newval)){
             data.checkAll = false
             data.isIndeterminate = true;
            if(interCheckall(newval)){
                data.checkAll = true
                data.isIndeterminate = false;
            }
          }else{
              data.checkAll = false
              data.isIndeterminate = false;
          }
        },
        {
            deep:true
        }
    )
    function onchangecheckout(e){
        data.checkAll = e;
        if(e){
          data.checkStatus = interobj(data.list,'id');
        }else{
          data.checkStatus = interfalse(data.list,'id');
        }
    }
    function ProductClisk(){
      content.emit('ProductClisk')
    }
    function Active(e){
       data.activeindex = e
    }
    function oncheckboxchange(e){
      data.checkStatus[e.id] = e.checkbox
    }
    return {
      ...toRefs(data),
      oncheckboxchange,
      ProductClisk,
      Active,
      onchangecheckout
    }
  }
}
</script>

<style scoped lang="scss">
.main-title{
  padding: 10px 20px;
  border-bottom:1px solid #dcdfe6;
  position: sticky;
  top: -20px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  box-sizing: border-box;
  background-color: #fff;
  z-index: 11;
}
.el-drop--label{
  margin-right: 10px;
  font-size: 14px;
}
.el-dropdown--import{
  // margin-right: 20px;
  // width: 100%;
  box-sizing: box-sizing;
}
:deep(.el-card__body){
  padding: 0px;
  border-radius: none !important;
}
.el--content{
  padding: 10px 0px;
  .el_content--title{
    font-weight: bold;
    padding-left: 15px;
    color: $color-bg;
  }
  position: relative;
}
.el--content::after{
  width: 4px;
  content: '';
  background-color:$color-bg;
  display: block;
  height: 20px;
  position: absolute;
  top: 25%;
}

//内容
.content--list{
  // padding: 10px 20px;
  min-width: 300px;
  box-sizing: border-box;
}
.main-content-main{
  background-color: #fff;
  // animation: _Products 1s;
  // transform: translateX(0%);
  box-sizing: border-box;
  min-width: 300px;
}
// @keyframes _Products {
//   0%{
//     transform: translateX(-200%);
//   }
// }
.medium--input-search{
  min-width: 300px;
  display: flex;
  align-items: center;
}
.button--add{
  margin-left: 10px;
}
.content-empty{
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 500px;
}
.content_list--empty{
  width: 200px;
  height:200px;
  text-align: center;
  img{
    width: 200px;
    height: 200px;
  }
}
@media only screen and(max-width:1100px){
  .el-dropdown--import{
    flex-wrap: wrap;
  }
  .button--add{
    margin-top: 10px;
  }

}

@media only screen and(max-width:630px){
  .button--add{
    margin-top: 10px;
  }
}

//动画
.user--product{
  animation: Product .8s;
  transform: translateX(0%);
}
@keyframes Product {
    0%{
      transform: translateX(-200%);
    }
}
.product--orderlist{
  animation: Products .8s;
  transform: translateX(200%);
  position: absolute;
  opacity: 0;
  transition: all .8s;
  top: 20px;
   display: none;
}
@keyframes Products {
    0%{
      transform: translateX(0%);
    }
}


</style>