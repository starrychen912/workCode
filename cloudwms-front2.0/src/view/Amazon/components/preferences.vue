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
                  <li>已禁止显示搜索结果且非在售商品</li>
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
                  <li>所有的库存</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>已禁止显示搜索结果且非在售商品</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>商品信息质量控制面板</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>潜在的重复项</li>
                  <el-divider direction="vertical"></el-divider>
                  <li>管理定价</li>
                </ul>
            </div>
        </div>
        <el-col class="flex" style="width:100%"  :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
            <div class="preferences">
                <div class="preferences-header">
                    <div class="header-title flex align-end">
                        <div class="title">管理库存</div>
                        <span>了解更多信息</span>
                    </div>
                    <div class="header-tips">您在此设定的值讲作为默认值用于未来查看您的库存商品。您可以随时编辑这些设置。</div>
                </div>
                <div class="preferences-content">
                    <div class="content-title">列显示</div>
                    <div class="checkbox-list">
                      <el-checkbox>状态 （推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>图片 （推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>SKU/状况（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>商品编号（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>商品名称/ASIN（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                     <el-checkbox>可售（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>入库数量（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>不可售数量（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>预留数量（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>每件售出商品的预计费用（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>商品价格 + 运费/定价状态（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>企业商品价格（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                     <el-checkbox>销售排名（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>获得购买按钮的资格（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>FUNSK（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>订单配送方（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>价格下限（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>价格上限（推荐）</el-checkbox>
                    </div>
                    <div class="checkbox-list">
                      <el-checkbox>UPC/EAN（推荐）</el-checkbox>
                    </div>
                </div>
                <div class="Sort_by">
                    <div class="title">初始排序方式</div>
                    <div class="select-option">
                        <el-select v-model="sort_by_id" placeholder="请选择">
                          <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                          </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="btn-address">
                    <div class="title">更改按钮位置</div>
                    <div class="select-option">
                      <el-select v-model="sort_by_id" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                    </div>
                </div>
                <div class="price">
                    <div class="title">在价格列中显示配送费</div>
                    <div class="select-option">
                      <el-select v-model="sort_by_id" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                    </div>
                </div>
                <div class="defalute-select">
                    <div class="title">默认筛选选项</div>
                    <div class="select-option">
                      <el-select v-model="sort_by_id" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                    </div>
                    <div class="select-option">
                      <el-select v-model="sort_by_id" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                    </div>
                </div>
                <div class="page-total">
                    <div class="title">每页的结果数</div>
                    <div class="select-option">
                      <el-select v-model="sort_by_id" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                    </div>
                </div>
                <div class="Basepricecomparison">
                    <div class="title">底价比较</div>
                    <div class="select-option">
                      <el-select v-model="sort_by_id" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                    </div>
                    <div class="select-option">
                      <el-select v-model="sort_by_id" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                    </div>
                </div>
                <!-- <div class="Save-btn">
                  <el-button @click="Cancel">取消</el-button>
                  <el-button @click="Save" type="primary" style="margin-left:10px;">保存</el-button>
                </div> -->
            </div>
            
        </el-col>

      </el-main>
  </el-container>
</template>

<script>
import { reactive, toRefs } from 'vue'
import Sidebar from '../../../components/Loyout/Sidebar/Sidebar.vue'
import router from '../../../router'
export default {
  components:{
    Sidebar
  },
  setup(props,content){
    const data = reactive({
        options:[
          
        ],
        sort_by_id:""
    })
    function Cancel(){
      router.go(-1)
    }
    return{
      ...toRefs(data),
      Cancel
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
    }
  }
}
.preferences{
  width: 100%;
  height: auto;
  margin-top: 10px;
  
}
.preferences-header{
  width: 100%;
  background-color: #fff;
  .header-title{
    width: 100%;
    padding: 20px 20px;
    border-bottom: 1px solid #d5dbdb;
    .title{
      font-size: 30px;
      font-weight: bold;
    }
    span{
      margin-left: 10px;
      color: #007185;
    }
  }
  .header-tips{
    width: 100%;
    padding: 20px;
    border-bottom: 1px solid #d5dbdb;
  }
  
}
.preferences-content{
    padding: 20px;
    background-color: #fff;
    border-bottom: 1px solid #d5dbdb;
    .content-title{
      padding: 0px 0px 10px 0px;
    }
    .checkbox-list{
      width: 100%;
    }
}
.Sort_by,.Basepricecomparison,.page-total,.defalute-select,.price,.btn-address{
    padding: 20px;
    background-color: #fff;
    border-bottom: 1px solid #d5dbdb;
    .title{
      padding: 10px 0px;
    }
    .select-option{
      width: 100%;
      margin-top:10px
    }
}
.Basepricecomparison{
  border: none;
}
.Save-btn{
  display:flex;
  margin-top:20px;
  justify-content: flex-end;
}
</style>