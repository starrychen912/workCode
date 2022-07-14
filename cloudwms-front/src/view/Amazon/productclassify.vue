<template>
<el-container>
      <el-header>
        <sidebar LogoName="查找商品"></sidebar>
      </el-header>
      <el-main class="flex justify-center">
        <el-col class="productclassify-el-col" :xs="24" :sm="24" :md="18" :lg="18" :xl="18">
            <div class="productclassify">
                <div class="productclassify-title">选择商品类别</div>
                <div class="productclassify-tilp">选择最佳商品类型，以确保你看到最适合商你商品的数据字段。直接浏览商品类型或使用搜索。<a href="#">看看你商品是否已存在于亚马逊</a></div>
                <div class="collection-content">
                  <div class="collection-title">收藏的商品数（0）</div>
                  <div class="collection">
                      <div class="collection-list" v-for="(item,index) in list" :key="index">
                          <div class="collection-title flex align-center">
                            <i class="el-icon-star-on"></i>
                            <div class="conllection-titlecontent">
                                <div class="titlecontent-title">手工宠物用品</div>
                                <div class="content-type">艺术品</div>
                            </div>
                          </div>
                          <div class="collection-pre flex align-center" v-if="false">
                            <div class="conllection-info flex align-center">
                              <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect x="6" y="22" width="36" height="22" rx="2" fill="#000" stroke="#000" stroke-width="4" stroke-linejoin="miter"/><path d="M14 22V14C14 8.47715 18.4772 4 24 4C29.5228 4 34 8.47715 34 14V22" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 30V36" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                              <span>了解更多信息</span>
                            </div>
                            <i class="el-icon-arrow-right"></i>
                          </div>
                          <div class="select-button" v-else @click="SelectProductClassify">选择</div>
                      </div>
                  </div>
                </div>
                <div class="search">
                  <div class="search-title">搜索</div>
                  <div class="search-input">
                      <el-input style="height: 100%" v-model="keyword" placeholder="商品名称、通用产品的代码（UPC）、EAN\国际标准（ISBN）或亚马孙商品编码（ASIN）">
                          <template #append>
                            <el-button icon="el-icon-search"></el-button>
                          </template>
                      </el-input>
                  </div>
                </div>
                <div class="select-category">
                    <div class="select-category-title">浏览</div>
                    <div class="select-category-input">
                        <el-input v-model="category_id" clearable="true"></el-input>
                    </div>
                    <div class="category-list">
                        <div class="collection-list" v-for="(item,index) in list" :key="index">
                          <div class="collection-title flex align-center">
                            <i class="el-icon-star-on"></i>
                            <div class="category-list-title">
                              手工宠物用品
                            </div>
                          </div>
                          <div class="collection-pre flex align-center" v-if="false">
                            <div class="conllection-info flex align-center">
                              <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect x="6" y="22" width="36" height="22" rx="2" fill="#000" stroke="#000" stroke-width="4" stroke-linejoin="miter"/><path d="M14 22V14C14 8.47715 18.4772 4 24 4C29.5228 4 34 8.47715 34 14V22" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 30V36" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                              <span>了解更多信息</span>
                            </div>
                            <i class="el-icon-arrow-right"></i>
                          </div>
                          <div class="collection-pre flex align-center" v-else>
                              <div class="category-title">商品类型：FABRIC</div>
                              <div class="select-button" @click="SelectProductClassify">选择</div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </el-col>
      </el-main>
</el-container>
</template>

<script>
import { reactive, toRefs } from "vue"
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
import router from "../../router"
export default {
  components:{
    Sidebar
  },
  setup(props,content){
    const data = reactive({
        list:[
          {
            che:[],
          },{},{},{},{},{},{},{},{},{}
        ],
        keyword:"",
        category_id:""
    })
    function SelectProductClassify(){
      router.push({path:"/Amazonshop/AmazonProducts/AddAmazonProduct"})
    }
    return{
      ...toRefs(data),
      SelectProductClassify
    }
  },
  
}
</script>

<style scoped lang="scss">
.el-header{
  background-color: #fff;
}
.productclassify{
  width: 100%;
  height: auto;
}
.productclassify-title{
  width: 100%;
  font-size: 25px;
}
.productclassify-tilp{
  margin-top: 20px;
  a{
    text-decoration: none;
    color: #00a2ff;
  }
}
.collection-content{
  margin-top: 20px;
  .collection-title{
    font-size: 20px;
    font-weight: bold;
  }
}
.collection{
  background-color: #Fff;
  border: 1px solid #d5dbdb;
  margin-top: 10px;
  cursor: pointer;
  max-height: 500px;
  overflow: auto;
}
.productclassify-el-col{
  .conllection-info,.select-button{
    padding:5px 10px;
    background-color: #e3eced;
    box-shadow: 0 1px 2px 0 #b5b5b5;
    color: rgba(4, 45, 54);
    font-family: "Amazon Ember", Arial, sans-serif;
    span{
      margin-left: 10px;
    }
  }
  .collection-list{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-right: 30px;
    border-bottom: 1px solid #d5dbdb;
    background-color: #fff;
    &:hover{
      background-color: rgb(4, 45, 54,0.1);
    }
    &:last-child{
      border-bottom: none;
    }
    i{
      font-size: 30px;
      &:first-child{
        color: rgb(0,131,149);
        font-size: 40px;
        padding: 10px;
      }
      &:last-child{
        font-weight: bold;
        color: #999;
        margin-left: 20px;
      }
    }
    .conllection-titlecontent{
        .titlecontent-title{
          font-size: 16px;
          color: #000;
        }
        .content-type{
          font-size: 14px;
          color: #999;
        }
    }
  }
}
.search{
  .search-title{
    padding: 20px 0px;
    font-size: 20px;
    font-weight: bold;
  }
  .search-input{
    height: 60px;
    :deep(.el-input){
      width: 100%;
      height: 100%;
      input{
        height: 100%;
      }
      .el-icon-search{
        font-weight: bold;
        font-size: 20px;
      }
    }
  }
}
.select-category{
  cursor: pointer;
  .select-category-title{
    padding: 20px 0px;
    font-size: 20px;
    font-weight: bold;
  }
  .select-category-input{
    height: 60px;
    :deep(.el-input){
      width: 100%;
      height: 100%;
      line-height: 60px;
      input{
        height: 100%;
        font-size: 18px;
      }
      .el-icon-search{
        font-weight: bold;
        font-size: 20px;
      }
    }
  }
  .category-list{
    width: 100%;
    max-height: 500px;
    border: 1px solid #d5dbdb;
    overflow: auto;
    .category-list-title{
      font-size: 18px;
      color: #000;
    }
  }
}
.category-title{
  font-size: 12px;
  color: #999;
  margin-right: 20px;
  cursor: pointer;
}
</style>