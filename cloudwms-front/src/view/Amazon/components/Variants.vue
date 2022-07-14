<template>
    <div class="variants-content">
        <div class="alert-warning">
            <i class="el-icon-warning-outline"></i>
            <div class="quotedprice-alert--content">
              <div class="alert-title">当卖家通过单一的详情页面销售相同的商品时，我们会整合最佳商品数据并进行展示，以确保买家获得最佳体验。</div>
              <!-- <el-checkbox >让我跳过报价数据，我稍后再提供</el-checkbox> -->
            </div>
        </div>
        <div class="variants_content">
            <div class="variants--type">
                <div class="variants_type--list flex align-center flex-wrap">
                    <div>选择变体类型：</div>
                    <el-checkbox v-model="Shell_material" :disabled="Number_of_goodsdisable">外壳材料</el-checkbox>
                    <el-checkbox v-model="Product_Size" :disabled="Product_Sizedisable">商品尺寸</el-checkbox>
                    <el-checkbox v-model="Color" :disabled="Colordisable">颜色</el-checkbox>
                    <el-checkbox v-model="Number_of_goods" :disabled="Shell_materialdisable">商品包装数量</el-checkbox>
                </div>
                <div class="type_list-tips">请在下面至少选择指定一个变体</div>
                
            </div>
            <div class="type_content" v-if="Contentdisable">
                <div class="title">列出以下变体类型的所有变体</div>
                <div>在以下输入项中，列出您的商品已有的变体。例如，如果您正在销售海盗衬衫，尺寸为小号、中号和大号，颜色为黑色和白色，请列出所有这些术语。即使您并不拥有所有组合
                  或者某些变体临时缺货、上述操作也是必需的。在下一页，您将能够清楚如何无效的变体。请参阅示例并<a>了解更多信息</a>。
                </div>
                <div class="variants_list">
                    <div class="variants_l--content" v-if="Shell_material">
                        <div class="product_size flex align-center">
                          <label>外壳材料</label>
                          <i class="el-icon-question"></i>
                        </div>
                        <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4" class="variants_input">
                          <el-input></el-input>
                          <span>示例：Oak</span>
                        </el-col>
                    </div>
                    <div class="variants_l--content" v-if="Product_Size">
                        <div class="product_size flex align-center">
                          <label>商品尺寸</label>
                          <i class="el-icon-question"></i>
                        </div>
                        <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4" class="variants_input">
                          <el-input></el-input>
                          <span>示例：6x18</span>
                        </el-col>
                    </div>
                    <div class="variants_l--content" v-if="Color">
                        <div class="product_size flex align-center">
                          <label>商品包装数量</label>
                          <i class="el-icon-question"></i>
                        </div>
                        <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4" class="variants_input">
                          <el-input></el-input>
                          <span>示例：5</span>
                        </el-col>
                    </div>
                    <div class="variants_l--content" v-if="Number_of_goods">
                        <div class="product_size flex align-center">
                          <label>颜色</label>
                          <i class="el-icon-question"></i>
                        </div>
                        <el-col :xs="24" :sm="8" :md="4" :lg="4" :xl="4" class="variants_input">
                          <el-input></el-input>
                          <span>示例：Sage</span>
                        </el-col>
                    </div>
                </div>
                <div class="Add_Varuabts--btn">
                    <el-button type="primary">添加变体</el-button>
                </div>
            </div>
            
        </div>
        <div class="Save-btn">
          <el-button type="primary">保存并完成</el-button>
          <el-button @click="goback()">取消</el-button>
        </div>
    </div>
</template>

<script>
import { computed, reactive,toRefs } from 'vue'
import router from '../../../router'
import { goback } from '../../../utils/utils'
export default {
  setup(props,content){
    const data = reactive({
      Number_of_goods:false,
      Product_Size:false,
      Color:false,
      Shell_material:false,

      Number_of_goodsdisable:computed(() =>{
        return data.Number_of_goods || data.Color || (data.Color && data.Product_Size)
      }),
      Product_Sizedisable:computed(() =>{
        return data.Number_of_goods
      }),
      Colordisable:computed(() =>{
        return data.Shell_material || data.Number_of_goods
      }),
      Shell_materialdisable:computed(() =>{
        return data.Shell_material || data.Product_Size || data.Color
      }),
      Contentdisable:computed(() =>{
        return data.Shell_material || data.Product_Size || data.Color || data.Number_of_goods
      })
    })

    return {
      goback,
      ...toRefs(data)
    }
  }
}
</script>

<style scoped lang="scss">
.variants-content{
  width: auto;
  
} 
.alert-warning{
  padding: 30px 20px;
  display: flex;
  align-items: flex-start;
  background-color: rgb(229,242,244);
  border-bottom: 1px solid #d5dbdb;
  i{
    font-size: 40px;
    font-weight: bold;
  }
  .quotedprice-alert--content{
    margin-left: 10px;
    
    .alert-title{
      font-weight: bold;
    }
  }
}
.variants--type{
  background-color: #fff;
  padding: 20px;
  border: 1px solid #d5dbdb;
  border-top: none;
}
.type_list-tips{
  color: rgb(255, 0, 0);
}
.type_content{
  padding: 20px;
  font-size: 16px;
  border: 1px solid #d5dbdb;
  border-top: none;
  background-color: #fff;
  .title{
    font-weight: bold;
    padding-bottom: 10px;
    font-size: 16px;
  }
}
.variants_list{
  height: auto;
  .variants_l--content{
    padding: 20px 0px;
  }
  .product_size{
    flex: 1;
    i{
      margin-left: 10px;
    }
  }
  .variants-input{
    width: 20%;
  }
} 
.variants_input{
  float: none;
  span{
    color: rgb(122, 122, 122);
  }
}
.Add_Varuabts--btn{
  // padding: 20px;
  // padding-top: 0px;
}
.Save-btn{
    margin-top: 30px;
    padding-bottom: 40px;
    display: flex;
    flex-direction: row-reverse;
    .el-button{
      margin-left: 10px;
    }
  }
</style>