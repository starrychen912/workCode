<template>
  <div class="quotedprice-content">
      <div class="alert-warning">
          <i class="el-icon-warning-outline"></i>
          <div class="quotedprice-alert--content">
            <div class="alert-title">你可以选择暂时将商品保存为“不可售”，稍后再添加商品报价</div>
            <el-checkbox >让我跳过报价数据，我稍后再提供</el-checkbox>
          </div>
      </div>
      <div class="quotedprice-from">
        <el-form ref="rulequotedprice" :model="quotedForm"  :rules="rules">
          <div class="from--list">
              <div class="from_l-list flex">
                <label class="from_l-lable">
                  卖家SKU
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input flex ">
                    <div class="l_input">
                      <el-input></el-input>
                      <span>提交好，无法更改此字段</span>
                    </div>
                    <div class="from-svg">
                      <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect x="6" y="22" width="36" height="22" rx="2" fill="#000" stroke="#000" stroke-width="4" stroke-linejoin="miter"/><path d="M14 22V14C14 8.47715 18.4772 4 24 4C29.5228 4 34 8.47715 34 14V22" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 30V36" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                    </div>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  商品税费代码
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input  ">
                  <el-input></el-input>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  配送模板
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <el-select style="width:100%;">
                      <el-option></el-option>
                  </el-select>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  你的价格
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <els-number-input></els-number-input>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  优惠价
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <els-number-input></els-number-input>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  优惠价开始日期
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <el-date-picker
                    v-model="value1"
                    type="date"
                    placeholder="选择日期">
                  </el-date-picker>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  优惠价结束日期
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <el-date-picker
                    v-model="value1"
                    type="date"
                    placeholder="选择日期">
                  </el-date-picker>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  市场价
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <els-number-input></els-number-input>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  状况
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input flex ">
                    <div class="l_input">
                      <el-input></el-input>
                      <span>提交好，无法更改此字段</span>
                    </div>
                    <div class="from-svg">
                      <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect x="6" y="22" width="36" height="22" rx="2" fill="#000" stroke="#000" stroke-width="4" stroke-linejoin="miter"/><path d="M14 22V14C14 8.47715 18.4772 4 24 4C29.5228 4 34 8.47715 34 14V22" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 30V36" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                    </div>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  状况说明
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input flex ">
                    <el-input type="textarea" rows="4"></el-input>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  订单商品最大数量
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input  ">
                  <el-input placeholder="10"></el-input>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  处理时间
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input  ">
                  <el-input placeholder="10"></el-input>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  可否提供礼品信息
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <el-select style="width:100%;">
                      <el-option></el-option>
                  </el-select>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  可否提供礼品包装
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <el-select style="width:100%;">
                      <el-option></el-option>
                  </el-select>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  商品发布日期
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <el-date-picker
                    v-model="value1"
                    type="date"
                    placeholder="选择日期">
                  </el-date-picker>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  商品结束日期
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <el-date-picker
                    v-model="value1"
                    type="date"
                    placeholder="选择日期">
                  </el-date-picker>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  补货日期
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                  <el-date-picker
                    v-model="value1"
                    type="date"
                    placeholder="选择日期">
                  </el-date-picker>
                </div>
              </div>
              <div class="from_l-list flex ">
                <label class="from_l-lable">
                  配送渠道
                  <i class="el-icon-question"></i>
                </label>
                <div class="from_l-input">
                    <div class="distribute-manner">
                      <div class="distribute_manner-me flex align-center">
                          <el-radio></el-radio>
                          <div>
                            <div class="title">我将自行配送此商品</div>
                            <span>(卖家自行配送)</span>
                          </div>
                      </div>
                      <div class="distribute_manner-amzon flex">
                          <el-radio size="medium"></el-radio>
                          <div>
                            <div class="title">亚马逊将会配送并提供客户服务</div>
                            <span>(亚马逊)</span>
                          </div>
                      </div>
                    </div>
                    <div class="distribute-tips">
                      <i class="el-icon-warning-outline"></i>
                      <span>你已选择使用亚马逊配送改商品的订单，亚马逊接到您的商品后即开始销售，使用亚马逊配送收费标准。</span>
                      <a>了解更多信息</a>
                    </div>
                </div>
              </div>
          </div>
          </el-form>
      </div>
      <!-- <div class="Save-btn">
            <el-button type="primary">保存并完成</el-button>
            <el-button @click="goback()">取消</el-button>
        </div> -->
  </div>
</template>

<script>
import { reactive, toRefs } from 'vue-demi'
import elsNumberInput from '../../../components/input/els-number-input.vue'
import { goback } from '../../../utils/utils'
export default {
  components: { elsNumberInput },
  setup(props,content){
    const data = reactive({
      rules:[

      ],
      quotedForm:{
        
      }
    })
    return {
      ...toRefs(data),
      goback
    }
  }
}
</script>

<style scoped lang="scss">
.information-title{
  padding: 20px 20px;
}
.quotedprice-content{
  content: '';

}
.alert-warning{
  padding: 30px 20px;
  display: flex;
  align-items: flex-start;
  background-color: rgb(229,242,244);
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
.quotedprice-from{
  width: 100%;
  height: auto;
  background-color: #fff;
}
.from_l-list{
  padding: 20px;
  width: 100%;
  .from_l-lable{
    width: 30%;
    text-align: right;
    font-size: 16px;
  }
  .from_l-input{
    width: 70%;
    height: auto;
    margin-left: 20px;
    .l_input{
      flex: 1;
      span{
        color: #999;
        font-size: 14px;
        padding-top: 10px;
      }
    }
    .from-svg{
      margin-left: 20px;
      padding-top: 10px;
    }
  }
}
.distribute-manner{
  border:1px solid #eee;
}
.distribute_manner-me{
  padding: 20px;
  border-bottom: 1px solid #eee;
  .el-radio{
    margin-left: 10px;
  }
  .title{
    font-weight: bold;
    font-size: 18px;
  }
}
.distribute_manner-amzon{
  padding: 20px;
  .title{
    font-weight: bold;
    font-size: 18px;
  }
  .el-radio{
    margin-left: 10px;
  }
}
.distribute-tips{
  font-size: 16px;
  padding: 10px 0px;
  color: #999;
  cursor: pointer;
  i{
    font-size: 20px;
    font-weight: bold;
    margin-right: 10px;
  }
  a{
    color: #007185;
  }
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
@media only screen and(max-width:700px){
  .from_l-list{
    flex-wrap: wrap;
    .from_l-lable{
      width: 100%;
      text-align: left;
    }
    .from_l-input{
      width: 100%;
      margin-left: 0px;
      margin-top: 10px;
    }
  }
  
}


</style>