<template>
    <div class="keyword--content">
        <div class="alert-warning">
            <i class="el-icon-warning-outline"></i>
            <div class="quotedprice-alert--content">
              <div class="alert-title">当卖家通过单一的详情页面销售相同的商品时，我们会整合最佳商品数据并进行展示，以确保买家获得最佳体验。</div>
            </div>
        </div>
        <div class="keyword_content-list">
            <div class="from_l-list flex">
                  <label class="from_l-lable">
                    使用人群
                    <i class="el-icon-question"></i>
                  </label>
                  <div class="from_l-input flex ">
                    <div class="l_input--none">
                        <el-input placeholder="138263"></el-input>
                        <a>添加更多</a>
                    </div>
                  </div>
            </div>
            <div class="from_l-list flex">
                  <label class="from_l-lable">
                    用途
                    <i class="el-icon-question"></i>
                  </label>
                  <div class="from_l-input flex ">
                    <div class="l_input--none">
                        <el-input placeholder="138263"></el-input>
                        <a>添加更多</a>
                    </div>
                  </div>
            </div>
            <div class="from_l-list flex">
                  <label class="from_l-lable">
                    其他属性
                    <i class="el-icon-question"></i>
                  </label>
                  <div class="from_l-input flex ">
                    <div class="l_input--none">
                        <el-input placeholder="String(50)"></el-input>
                        <a>添加更多</a>
                    </div>
                  </div>
            </div>
            <div class="from_l-list flex">
                  <label class="from_l-lable">
                    主题关键字词
                    <i class="el-icon-question"></i>
                  </label>
                  <div class="from_l-input flex ">
                    <div class="l_input--none">
                        <el-input placeholder="String(50)"></el-input>
                        <a>添加更多</a>
                    </div>
                  </div>
            </div>
            <div class="from_l-list flex">
                  <label class="from_l-lable">
                    搜索关键词
                    <i class="el-icon-question"></i>
                  </label>
                  <div class="from_l-input flex ">
                    <div class="l_input">
                        <el-input placeholder="String(50)"></el-input>
                    </div>
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
import { reactive, toRefs } from "vue"
import { goback } from "../../../utils/utils"
export default {
  setup(props,content){
    const data = reactive({

    })
    return {
      ...toRefs(data),
      goback
    }
  }
}
</script>

<style scoped lang="scss">
.keyword--content{

}
.alert-warning{
  padding: 30px 20px;
  display: flex;
  align-items: flex-start;
  background-color: rgb(229,242,244);
  border: 1px solid #d5dbdb;
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
.keyword_content-list{
  height: auto;
  background-color: #fff;
  border: 1px solid #d5dbdb;
  // padding: 20px;
}

.from_l-list{
  padding: 20px; 
  width: 100%;
  .from_l-lable{
    width: 30%;
    text-align: right;
    font-size: 16px;
  }
  .from_l-select{

  }

  .from_l-input{
    width: 60%;
    height: auto;
    margin-left: 20px;
    .l_input{
      flex: 1;
      span{
        color: #999;
        font-size: 14px;
        padding-top: 10px;
      }
      a{
          color: #007185;
      }
    }
    .l_input--none{
        width: 50%;
        span{
            color: #999;
            font-size: 14px;
            padding-top: 10px;
        }
      a{
          color: #007185;
      }
    }
    .l-select{
        margin-left: 20px;
        flex: 1;
    }
    .from-svg{
      margin-left: 20px;
      padding-top: 10px;
    }
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
    .from_l-input{
        .l_input--none{
          width: 100%;
        }
    }
    
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
@media only screen and(max-width:500px){
    .from_l-list{
        .from_l-input{
            .l-select{
                width: 100%;
                flex: 100%;
                margin-left: 0px;
                margin-top: 10px;
            }
        }
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
</style>