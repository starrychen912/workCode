<template>
  <div class="information">
      <!-- <div class="information-title">
          <div class="title">
            <span>艺术品、工艺品和</span>
            <i class="el-icon-arrow-right"></i>
          </div>
      </div> -->
      <div class="alert-warning">
          <i class="el-icon-warning-outline"></i>
          <span>当多一个卖家通过单一详情页面销售相同的商品时，我们会整合最佳商品数据并进行张展示，以确保买家获得最佳体验。</span>
      </div>
      <div class="information-form">
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                变体
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <div class="content--list">
                  <span>这款商品有变体吗？</span>
                  <el-radio v-model="radio" label="1">是</el-radio>
                  <el-radio v-model="radio" label="1">否</el-radio>
                </div>
                <div class="content-varinatr">
                  <div>在商品变体中，这些属性有哪些是不同的？</div>
                  <div class="information-checkbox-list">
                    <el-checkbox>外壳材料</el-checkbox>
                    <el-checkbox>商品尺寸</el-checkbox>
                    <el-checkbox>颜色</el-checkbox>
                    <el-checkbox>商品包装数量</el-checkbox>
                  </div>
                </div>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                商品编码
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content flex">
                <div class="inforamtion-coding">
                  <el-input placeholder="5279173125000"></el-input>
                  <span>提交好，无法更改此字段</span>
                </div>
                <div class="inforamtion-select">
                    <el-select v-model="value" placeholder="请选择">
                      <el-option
                        v-for="item in options"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                      </el-option>
                    </el-select>
                    <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect x="6" y="22" width="36" height="22" rx="2" fill="#000" stroke="#000" stroke-width="4" stroke-linejoin="miter"/><path d="M14 22V14C14 8.47715 18.4772 4 24 4C29.5228 4 34 8.47715 34 14V22" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 30V36" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                </div>
                
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                品牌
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <el-input placeholder="5279173125000"></el-input>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                商品名称
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <div class="inforamtion--content-brand">
                    <el-input placeholder="5279173125000"></el-input>
                </div>
                <div class="brand-checkbox">
                  <el-checkbox>此商品没有品牌名称</el-checkbox>
                  <a>了解有关品牌名称政策的更多信息</a>
                </div>
                <div class="brand-addond">
                  品牌注册成功后，若要发布商品，其品牌名称的拼写和大小写必须与提交申请品牌批准时完全一致。对于您在提交品牌注册申请时选择关键属性请指定一个唯一的值，之后，您可以通过管理库存，随时编辑商品详情。
                </div>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                制造商
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <el-input placeholder="Kitchen Aid"></el-input>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                制造商零件编号
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <el-input placeholder="SB-122"></el-input>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                商品尺寸
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <el-input placeholder="6x18"></el-input>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                尺寸名称
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <el-input placeholder=""></el-input>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                颜色
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <el-input placeholder="Sage"></el-input>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                色表
                <i class="el-icon-question"></i>
            </label>
            <div class="inforamtion--content">
                <el-input placeholder="Green"></el-input>
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
.information-title{
  padding: 20px 20px;
}
.alert-warning{
  padding: 30px 20px;
  display: flex;
  align-items: center;
  background-color: rgb(229,242,244);
  i{
    font-size: 40px;
  }
  span{
    margin-left: 10px;
  }
}
.information-form{
  width: 100%;
  height: auto;
  background-color: #fff;
  font-size: 17px;
  padding: 20px 20px;
  // margin-top: 20px;
  .information-form-list{
    margin-top: 20px;
    &:first-child{
      margin-top: 0px;
    }
  }
}
  .content--list{
    .el-radio{
      height: auto;
    }
    
  }
  .content-varinatr{
    margin-top: 10px;
  }
  .information-form .information--vartains{
    width: 30%;
    text-align: right;
    &::before{
      content: '*';
      color: rgb(250, 0, 0);
    }
  }
  .inforamtion--content{
    width: 70%;
    text-align: left;
    padding-left: 20px;
  }
  .inforamtion-coding{
    width: 30%;
    span{
      color: #777;
      font-size: 12px;
    }
  }
  .inforamtion-select{
    margin-left: 10px;
    svg{
      margin-left: 10px;
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