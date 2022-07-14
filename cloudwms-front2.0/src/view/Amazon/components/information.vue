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
        <el-form ref="ruleFormRef" :model="sizeForm"  :rules="rules"  > 
            <div class="information-form-list flex  justify-center">
              <label class="information--vartains ">
                  变体
                  <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="变体"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
                  
              </label>
              <div class="inforamtion--content ">
                  <div class="content--list">
                    <span>这款商品有变体吗？</span>
                    <el-form-item prop="resource" style="margin-top:10px;">
                      <el-radio-group v-model="sizeForm.resource">
                        <el-radio border label="是">是</el-radio>
                        <el-radio border label="否">否</el-radio>
                      </el-radio-group>
                    </el-form-item>
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
                <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="商品编码"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            <div class="inforamtion--content flex  flex-wrap">
                <div class="inforamtion-coding">
                  <el-form-item prop="product_code">
                    <el-input placeholder="5279173125000" v-model="sizeForm.product_code" ></el-input>
                  </el-form-item>
                  <span>提交好，无法更改此字段</span>
                </div>
                <div class="inforamtion-select">
                    <el-form-item prop="product_code_type">
                      <el-select v-model="sizeForm.product_code_type" placeholder="请选择">
                        <el-option
                          v-for="item in options"
                          :key="item"
                          :label="item"
                          :value="item">
                        </el-option>
                      </el-select>
                    </el-form-item>
                    <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect x="6" y="22" width="36" height="22" rx="2" fill="#000" stroke="#000" stroke-width="4" stroke-linejoin="miter"/><path d="M14 22V14C14 8.47715 18.4772 4 24 4C29.5228 4 34 8.47715 34 14V22" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M24 30V36" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                </div>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains must">
                品牌
                <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="品牌"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            <div class="inforamtion--content">
                <el-form-item prop="brand">
                  <el-input placeholder="5279173125000" v-model="sizeForm.brand"></el-input>
                </el-form-item>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains must">
                商品名称
                <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="商品名称"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            <div class="inforamtion--content">
                <div class="inforamtion--content-brand">
                    <el-form-item prop="product_name"><el-input :disabled="product_name_status" placeholder="5279173125000" v-model="sizeForm.product_name"></el-input></el-form-item>
                </div>
                <div class="brand-checkbox">
                  <el-checkbox @change="BrandCheckbox">此商品没有品牌名称</el-checkbox>
                  <a class="Learn">了解有关品牌名称政策的更多信息</a>
                </div>
                <div class="brand-addond" style="font-size:14px;margin-bottom:10px;">
                  品牌注册成功后，若要发布商品，其品牌名称的拼写和大小写必须与提交申请品牌批准时完全一致。对于您在提交品牌注册申请时选择关键属性请指定一个唯一的值，之后，您可以通过管理库存，随时编辑商品详情。
                </div>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains must">
                制造商
                <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="制造商"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            <div class="inforamtion--content">
              
                <el-form-item prop="manufacturer">
                  <el-input placeholder="Kitchen Aid" v-model="sizeForm.manufacturer"></el-input>
                </el-form-item>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains must">
                制造商零件编号
                <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="制造商零件编号"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            
            <div class="inforamtion--content">
                <el-form-item prop="manufacturer_code">
                  <el-input placeholder="SB-122" v-model="sizeForm.manufacturer_code"></el-input>
                </el-form-item>
            </div>
          </div>
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                商品尺寸
                <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="商品尺寸"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            <div class="inforamtion--content">
                <el-form-item prop="product_question">
                  <el-input placeholder="6x18" v-model="sizeForm.product_question"></el-input>
                </el-form-item>
            </div>
          </div>
          
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                尺寸名称
                <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="尺寸名称"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            <div class="inforamtion--content">
              <el-form-item prop="question_name">
                  <el-input placeholder="请输入尺寸名称" v-model="sizeForm.question_name"></el-input>
                </el-form-item>
            </div>
          </div>
          
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                颜色
                <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="颜色"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            <div class="inforamtion--content">
              <el-form-item prop="product_Sage">
                  <el-input placeholder="Sage" v-model="sizeForm.product_Sage"></el-input>
              </el-form-item>
            </div>
          </div>
          
          <div class="information-form-list flex  justify-center">
            <label class="information--vartains">
                色表
               <el-tooltip
                  class="box-item"
                  effect="dark"
                  content="色表"
                  placement="top"
                >
                  <i class="el-icon-question"></i>
                </el-tooltip>
            </label>
            <div class="inforamtion--content">
              <el-form-item prop="Green_table">
                  <el-input placeholder="Green" v-model="sizeForm.Green_table"></el-input>
              </el-form-item>
            </div>
          </div>
           </el-form>
      </div>
     <!-- <div class="Save-btn">
        <el-button type="primary" @click="submitForm(ruleFormRef)">保存并完成</el-button>
        <el-button @click="goback()">取消</el-button>
      </div> -->
  </div>
</template>

<script>
import { reactive, toRefs,ref } from 'vue-demi'
import { goback } from "../../../utils/utils"
export default {
  emits:['Submit'], 
  setup(props,content){
    const ruleFormRef = ref();
    const data = reactive({
        product_name_status:false,
        sizeForm:{
          resource:'', //变体
          product_code:'', // 商品编码
          product_code_type:'', // 商品编码类型
          brand:'', //品牌
          product_name:'', //商品名称
          manufacturer_code:'',//制造商的零件编码
          manufacturer:'',//制造商
          Green_table:'',//色表
          product_Sage:'',//商品颜色
          question_name:'',//尺寸名称
          product_question:'',//商品尺寸
        },
        rules:{
           resource: [
              {
                required: false,
                message: '请选择是否添加变体',
                trigger: 'change',
              },
          ],//变体
          product_code:[
             {
              required: false,
              message: '请输入商品编码',
              trigger: 'change',
            }, 
          ],//商品编码
          product_code_type:[
            {
                required: false,
                message: '请选择',
                trigger: 'change',
            },
          ],//商品编码类型
          brand:[
            {
                required: true,
                message: '请输入品牌',
                trigger: 'change',
            },
          ],//品牌
          product_name:[
            {
                required: true,
                message: '请输入商品名称',
                trigger: 'change',
            },
          ],//商品名称
          manufacturer:[
            {
                required: true,
                message: '请输入制造商',
                trigger: 'change',
            },
          ],//制造商
          manufacturer_code:[
            {
                required: true,
                message: '请输入制造商的零件编码',
                trigger: 'change',
            },
          ],//制造商的零件编码
          Green_table:[
            {
                required: false,
                message: '请输入色表',
                trigger: 'change',
            },
          ],//色表
          product_Sage:[
            {
                required: false,
                message: '请输入商品颜色',
                trigger: 'change',
            },
          ],//商品颜色
          question_name:[
            {
                required: false,
                message: '请输入尺寸名称',
                trigger: 'change',
            },
          ],//尺寸名称
          product_question:[
            {
                required: false,
                message: '请输入商品尺寸',
                trigger: 'change',
            },
          ],//商品尺寸
        },
        options:[
          'GTIM',
          'EAN',
          'GCID',
          'UPC',
          'ASIN'
        ]
    })
    function submitForm(formEl){
      console.log(formEl);
      formEl.validate((valid) =>{
        console.log(valid);
      })
    }
     function init(){
      console.log(ruleFormRef.value);
     return new Promise((res,rjs) =>{
        ruleFormRef.value.validate((valid) =>{
          if(valid){
            res(data.sizeForm)
          }else{
            res(valid)
          }
        })
      })
    }
    function BrandCheckbox(item){
      data.product_name_status = item
      console.log(item);
      if(item){
        data.sizeForm.product_name = "通用"
      }else{
        data.sizeForm.product_name = ''
      }
    }
    return{
      ...toRefs(data),
      goback,
      submitForm,
      ruleFormRef,
      BrandCheckbox,
      init,
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
    // margin-top: 20px;
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
    &.must::before{
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
    display: flex;
    // align-items: center;
    svg{
      margin-left: 10px;
      margin-top: 10px;
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
  .brand-checkbox{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
  }
  .Learn{
      color: $color-bg;
    }
    
  
  @media only screen and(max-width:3000px){
    .inforamtion-coding{
      width: 20%;
    }
  }
  @media only screen and(max-width:1500px){
    .inforamtion-coding{
      width: 30%;
    }
  }
  @media only screen and(max-width:800px){
    .inforamtion-coding{
      width: 100%;
    }
    .inforamtion-select{
      margin:0px;
    }
  }
  @media only screen and(max-width:600px){
    .inforamtion-coding{
      width: 100%;
    }
  }
</style>