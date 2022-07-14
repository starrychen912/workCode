<template>
  <el-container>
      <el-header>
        <sidebar LogoName="管理库存"></sidebar>
      </el-header>
      <el-main>
        <div class="Amazonproduct">
            <div class="Amazonproduct_application flex align-center flex-wrap">
                <div class="application-title">商品发布工具：</div>
                <ul class="application_list flex align-center flex-wrap">
                  <li>所有的库存</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>已禁止显示搜索结果且非在售商品(117)</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>商品信息质量控制面板</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>潜在的重复项</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>管理定价</li>
                </ul>
            </div>
            <div class="Amazonproduct_application flex align-center flex-wrap">
                <div class="application-title">FBA库存工具：</div>
                <ul class="application_list flex align-center flex-wrap">
                  <li>亚马逊物流库存</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>亚马逊物流机会</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>库存控制面板</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>管理库存状况</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>移除不可售商品</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>货件处理进度</li>
                </ul>
            </div>
        </div>
        <div class="product-list">
            <div class="Product_list-title">
                <div class="title-header">
                    <h1>管理库存</h1>
                    <div class="title-header-tips">
                      <div>了解更多信息</div>
                      <el-divider direction="vertical"></el-divider>
                      <div>浏览 新功能</div>
                    </div>
                </div>
                <div class="title-application">
                    <loding-btn>添加一个商品变体</loding-btn>
                    <loding-btn @LoadBTN="LoadBTN">添加新商品</loding-btn>
                    <loding-btn @LoadBTN="Prefernces">首选项：隐藏x列</loding-btn>
                </div>
            </div>
            <div class="product-search">
                <div class="search--header flex align-center flex-wrap">
                    <div class="search--header-button">
                      <el-dropdown trigger="click">
                          <el-button  >
                              应用于0件选定商品
                              <i class="el-icon-arrow-down"></i>
                          </el-button>
                          <template #dropdown>
                            <el-dropdown-menu>
                              <el-dropdown-item>Action 1</el-dropdown-item>
                              <el-dropdown-item>Action 2</el-dropdown-item>
                              <el-dropdown-item>Action 3</el-dropdown-item>
                              <el-dropdown-item>Action 4</el-dropdown-item>
                              <el-dropdown-item>Action 5</el-dropdown-item>
                            </el-dropdown-menu>
                          </template>
                      </el-dropdown>
                    </div>
                    <div class="search-input flex">
                      <el-input prefix-icon="el-icon-search">
                          <template #append>
                            <el-button type="primary" >搜索</el-button>
                          </template>
                      </el-input>
                    </div>
                    <div class="addmon">19商品</div>
                </div>
            </div>
        </div>
        <div class="Product-Screening_condition">
            <div class="Screening_condition flex align-center flex-wrap">
                <div>筛选条件：</div>
                <div>商品状态：
                  <el-radio >所有</el-radio>
                  <el-radio>在售</el-radio>
                  <el-radio>不可售</el-radio>
                  <el-radio>不完整</el-radio>
                  <el-radio>商品信息已删除</el-radio>
                  <el-radio>已禁止显示搜索结果</el-radio>
                </div>
                <el-divider direction="vertical"></el-divider>
                <div>配送类型：
                  <el-radio>所有</el-radio>
                  <el-radio>亚马孙</el-radio>
                  <el-radio>卖家</el-radio>
                </div>
                <div class="dropdown-other">
                  <el-dropdown trigger="click">
                          <el-button  type="small">
                              其他筛选条件
                              <i class="el-icon-arrow-down"></i>
                          </el-button>
                          <template #dropdown>
                            <el-dropdown-menu>
                              <el-dropdown-item>搜索开始日期</el-dropdown-item>
                              <el-dropdown-item>搜索结束日期</el-dropdown-item>
                              <el-dropdown-item>价格高于</el-dropdown-item>
                              <el-dropdown-item>价格低于</el-dropdown-item>
                            </el-dropdown-menu>
                          </template>
                      </el-dropdown>
                </div>
            </div>
        </div>
        <div class="Product-tablie">
            <amazon-product-table :tableData="tableData"></amazon-product-table>
            
        </div>
        <div class="pagination-list">
            <el-pagination
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
              :current-page="currentPage4"
              :page-sizes="[100, 200, 300, 400]"
              :page-size="100"
              layout="total, sizes, prev, pager, next, jumper"
              :total="400">
            </el-pagination>
        </div>
      </el-main>
  </el-container>
</template>

<script>
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
import lodingBtn from '../../components/lodingBtn/index.vue'
import { reactive, toRefs } from 'vue'
import AmazonProductTable from './components/AmazonProductTable.vue'
import { useRoute } from 'vue-router'
import router from '../../router'
export default {
  components:{
    Sidebar,
    lodingBtn,
    AmazonProductTable
},
  setup(){
    const route = useRoute();
    const data =  reactive({
      tableData:[
          {
            id:1,
            url:"https://img.alicdn.com/imgextra/i4/2048310124/O1CN01i4T4Iw1Cmppcfoh0c_!!0-saturn_solar.jpg_468x468q75.jpg_.webp",
            name:"CHDKWLJDLWADWADWADWA",
            creade_time:"12/11/20211",
            sku:"XOO31939J",
            Price:"0.00",
            mariker_price:"0.00",
            querty:100,
            kes:27,
            nokes:27,
            yulshu:100,
          }
      ],
    })
    function Prefernces(){
        router.push({
          path:"/Amazonshop/AmazonProducts/preferences"
        })
    }
    function LoadBTN(){
        router.push({
          path:"/Amazonshop/AmazonProducts/SearchAmzonPorduct"
        })
    }
    return {
      ...toRefs(data),
      LoadBTN,
      Prefernces
    }
  }
}
</script>

<style scoped lang="scss">
.el-header{
  background-color: #fff;
}
.Amazonproduct{
  width: 100%;
  background-color: #fff;
  padding: 20px;
}
.Amazonproduct_application{
  .application-title{
    font-size: 18px;
    font-weight: bold;
  }
  .application_list{
    text-decoration: none;
    list-style-type: none;
    padding: 0;
    li{
      padding: 0px 20px;
      font-size: 14px;
      color: #007185;
      cursor: pointer;
    }
  }
}
.Product_list-title{
  padding: 20px;
  max-width: 100%;
  background-color: #fff;
  margin-top: 10px;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  justify-content: space-between;
  .title-header{
    display: flex;
    align-items: center;
    
    h1{
      margin: 0;
      font-size: 25px;
    }
    .title-header-tips{
      margin-left: 20px;
      display: flex;
      align-items: center;
      color: #007185;
      font-size: 12px;
    }
  }
  .title-application{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    .lodingBtn{
      margin-left: 10px;
    }
    .lodingBtn:first-child{
      margin-left: 0px;
    }
  }
}
.search--header{
    background-color: #fff;
    padding: 20px;
    max-width: 100%;
}
.search--header-button{
  // width: 300px;
}
.search-input{
  margin-left: 10px;
}
.addmon{
  margin-left: 20px;
}

@media only screen and(max-width:610px){
    .addmon{
      margin-top: 10px;
      margin-left: 0px;
    }
    .title-application{
      .lodingBtn{
        margin-top: 10px;
      }
    }
}
.Product-Screening_condition{
  padding: 20px;
  background-color: #fff;
  max-width: 100%;
  box-sizing: border-box;
  margin-top: 20px;
}
.Screening_condition{
  // padding: 20px;
  background-color: #fff;
  max-width: 100%;
  box-sizing: border-box;
}
.dropdown-other{
  margin-left: 10px;
}
.Product-tablie{
  padding: 20px;
  background-color: #fff;
}
.pagination-list{
  padding:0px 20px 20px;
  background-color: #fff;
}
@media only screen and(max-width:558px){
    .addmon{
      margin-top: 10px;
      margin-left: 10px;
    }
    .search-input{
      // margin-top: 10px;
      margin-left: 0px;
    }
}
@media only screen and(max-width:540px){
    .search-input{
      margin-top: 10px;
      // margin-left: 0px;
    }
}
@media only screen and(max-width:442px){
   .Product_list-title {
      .title-application{
        .lodingBtn{
            margin-left: 0px;
        }
      }
   } 
    
}
</style>