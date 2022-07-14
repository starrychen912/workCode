<template>
    <div class="compliancelnformation">
        <div class="alert-warning">
            <i class="el-icon-warning-outline"></i>
            <div class="quotedprice-alert--content">
              <div class="alert-title">当卖家通过单一的详情页面销售相同的商品时，我们会整合最佳商品数据并进行展示，以确保买家获得最佳体验。</div>
            </div>
        </div>
        <div class="compliancelnformation--content">
            <div class="c_content--list">
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        电池成分
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <el-select style="width:100%;" >
                            <el-option></el-option>
                        </el-select>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        电池成分
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input--none">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                            <a>添加更多</a>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        电池数量
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input--none">
                            <el-input placeholder="3"></el-input>
                            <a>添加更多</a>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        每个电池的瓦时数
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex flex-wrap">
                        <div class="l_input">
                            <el-input placeholder="1,2,3"></el-input>
                        </div>
                        <div class="l-select">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        电池包装类型
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        是否附带电池
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        此商品是否使用电池或商品本身是电池                        
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        电池重量（克）
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex flex-wrap">
                        <div class="l_input">
                            <el-input placeholder="1,2,3"></el-input>
                        </div>
                        <div class="l-select">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        锂金属电池单元数量
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="1,2,3"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        锂离子电池单元数量
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input></el-input>
                        </div>
                    </div>
                </div>
                 <div class="from_l-list flex">
                    <label class="from_l-lable">
                        锂含量（克）
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex flex-wrap">
                        <div class="l_input">
                            <el-input placeholder="1,2,3"></el-input>
                        </div>
                        <div class="l-select">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        联合国危险货物编号
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="UN1950"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        安全数据表（SDS）URL
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="http://localhost:8090/Amazonshop/AmazonProducts/AddAmazonProduct"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        容量
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex flex-wrap">
                        <div class="l_input">
                            <el-input placeholder="34.78"></el-input>
                        </div>
                        <div class="l-select">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        闪点（°C）？
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="180"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        商品重量
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex flex-wrap">
                        <div class="l_input">
                            <el-input placeholder="2.33,20.75,10000.00"></el-input>
                        </div>
                        <div class="l-select">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        危险品相关法规
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input--none">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                            <a>添加更多</a>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        分类/GHS图形符号（选择所有使用选项）
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input--none">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                            <a>添加更多</a>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        California Proposition 65 warning Type
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <el-select style="width:100%;" >
                            <el-option></el-option>
                        </el-select>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        California Proposition 65 Chemical Names
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="180"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        Additional Chemical Name1
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="180"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        Additional Chemical Name2
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="180"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        Additional Chemical Name3
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="180"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        Additional Chemical Name4
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input">
                            <el-input placeholder="180"></el-input>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        Pesticide Marking
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input--none">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                            <a>添加更多</a>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        Pesticaide Registration Status
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input--none">
                            <el-select style="width:100%;">
                                <el-option></el-option>
                            </el-select>
                            <a>添加更多</a>
                        </div>
                    </div>
                </div>
                <div class="from_l-list flex">
                    <label class="from_l-lable">
                        Pesticide Certification Number
                        <i class="el-icon-question"></i>
                    </label>
                    <div class="from_l-input flex ">
                        <div class="l_input--none">
                            <el-input placeholder="138263"></el-input>
                            <a>添加更多</a>
                        </div>
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
import { goback } from "../../../utils/utils"
export default {
    setup(props,content){
        return{
            goback
        }
    }
}
</script>

<style scoped lang="scss">
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
.compliancelnformation--content{
    width: 100%;
    height: auto;
    background-color: #fff;
    .c_content--list{

    }
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
</style>