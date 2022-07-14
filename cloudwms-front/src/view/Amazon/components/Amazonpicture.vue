<template>
  <div class="picture">
      <div class="alert-warning">
            <i class="el-icon-warning-outline"></i>
            <div class="quotedprice-alert--content">
              <div class="alert-title">当卖家通过单一的详情页面销售相同的商品时，我们会整合最佳商品数据并进行展示，以确保买家获得最佳体验。</div>
            </div>
        </div>
        <div class="picture_list--content">
          <div class="picture_title">您的图片建议</div>
          <div class="picture_title-tips">上传您的商品图片建议</div>
          <div class="picture_upload--detail">
              <div class="picture_up--header" @click="ShowImg">
                <div class="title">{{collapse_detail?'隐藏':'显示'}}图片的指南</div>
                <i :class="collapse_detail?'el-icon-caret-bottom':'el-icon-caret-right'"></i>
              </div>
              <div class="collapse" :class="{'collapse_show':collapse_detail}">
                <a>产品图像风格指南</a>
                <div class="collapse-content">
                    <div class="">缺少主图片的商品将不会出现在搜索或浏览中，除非您为商品添加了主图片请选择清晰、信息丰富且引人注目的图片</div>
                    <div>图片必须满足以下要求</div>
                    <ul>
                      <li>商品必须至少填满85%的图片。图片必须仅显示要出售的商品，可包含部分或不能包含其他道具，不能包含商标、水印或内嵌图片。图片包含的文本内容只能是商品信息。</li>
                      <li>主图片必须为背景是纯白色的商品照片（而不是画出来的图），且不能包含其他搭配品。</li>
                      <li>图片缩放时最长边必须在1000像素以上，最短边必须在200像素上。</li>
                      <li>图片最长边不能超过10000像素。</li>
                      <li>首选JPEG格式的图片，但您也可使用TIFF和GIF格式图片。</li>
                    </ul>
                </div>
              </div>
          </div>
          <div class="upload_muitple--files">
            <div class="upload_muitple-title">or drag and drop 1 or more files below</div>
            <div>上传提示：0 of 10 images.maximum 10 images are allowed. You can arrange the order after uploading</div>
            <div class="upload_files--list flex flex-wrap">
                <div class="files_list--img">
                  <el-upload
                      action="https://jsonplaceholder.typicode.com/posts/"
                      list-type="picture-card"
                      :on-preview="handlePictureCardPreview"
                      :on-remove="handleRemove"
                      :limit="1"
                    >
                    <i class="el-icon-camera-solid"></i>
                    <span class="el-upload__text">上传</span>
                  </el-upload>
                  <div class="files_list--text">主图片</div>
                </div>
                <div class="files_list--img">
                  <el-upload
                      action="https://jsonplaceholder.typicode.com/posts/"
                      list-type="picture-card"
                      :on-preview="handlePictureCardPreview"
                      :on-remove="handleRemove"
                      :limit="1"
                    >
                    <i class="el-icon-camera-solid"></i>
                    <span class="el-upload__text">上传</span>
                  </el-upload>
                  <!-- <div class="files_list--text">主图片</div> -->
                </div>
                <div class="files_list--img">
                  <el-upload
                      action="https://jsonplaceholder.typicode.com/posts/"
                      list-type="picture-card"
                      :on-preview="handlePictureCardPreview"
                      :on-remove="handleRemove"
                      :limit="1"
                    >
                    <i class="el-icon-camera-solid"></i>
                    <span class="el-upload__text">上传</span>
                  </el-upload>
                  <!-- <div class="files_list--text">主图片</div> -->
                </div>
                <div class="files_list--img">
                  <el-upload
                      action="https://jsonplaceholder.typicode.com/posts/"
                      list-type="picture-card"
                      :on-preview="handlePictureCardPreview"
                      :on-remove="handleRemove"
                      :limit="1"
                    >
                    <i class="el-icon-camera-solid"></i>
                    <span class="el-upload__text">上传</span>
                  </el-upload>
                  <!-- <div class="files_list--text">主图片</div> -->
                </div>
                <div class="files_list--img">
                  <el-upload
                      action="https://jsonplaceholder.typicode.com/posts/"
                      list-type="picture-card"
                      :on-preview="handlePictureCardPreview"
                      :on-remove="handleRemove"
                      :limit="1"
                    >
                    <i class="el-icon-camera-solid"></i>
                    <span class="el-upload__text">上传</span>
                  </el-upload>
                  <!-- <div class="files_list--text">主图片</div> -->
                </div>
                <div class="files_list--img">
                  <el-upload
                      action="https://jsonplaceholder.typicode.com/posts/"
                      list-type="picture-card"
                      :on-preview="handlePictureCardPreview"
                      :on-remove="handleRemove"
                      :limit="1"
                    >
                    <i class="el-icon-camera-solid"></i>
                    <span class="el-upload__text">上传</span>
                  </el-upload>
                  <!-- <div class="files_list--text">主图片</div> -->
                </div>
            </div>
          </div>
        </div>
        
  </div>
  <div class="Save-btn">
    <el-button type="primary">保存并完成</el-button>
    <el-button @click="goback()">取消</el-button>
  </div>
</template>

<script>
import { reactive, toRefs } from "vue"
import { goback } from "../../../utils/utils"
export default {
  setup(props,content){
    const data = reactive({
      //图片折叠
      collapse_detail:false,
    })
    function ShowImg(){
      data.collapse_detail = !data.collapse_detail
    }
    return{
      ShowImg,
      ...toRefs(data),
      goback
    }
  }
}
</script>

<style scoped lang="scss">
.picture{
  border: 1px solid #d5dbdb;
  background-color: #fff;
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

.picture_list--content{
  padding: 20px;
  .picture_title{
    font-weight: bold;
  }
  .picture_title-tips{
    padding-top: 10px;
  }
}
.picture_up--header{
  width: 100%;
  padding: 20px 0px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  .title{
    font-weight: bold;
  }
}
.collapse{
  animation: collapse 0.5s;
  min-height: 300px;
  max-height: 100%;
  overflow: hidden;
  display: none;
  a{
    color: #007185;
  }
  .collapse-content{
    margin-top: 20px;
  }
}
.collapse_show{
  display: block;
  animation: collapse 0.5s;
  a{
    color: #007185;
  }
  .collapse-content{
    margin-top: 20px;
  }
}
@keyframes collapse {
  0%{
    height: 0px;
  }
}
.upload_files--list{
  width: 100%;
  height: auto;
  margin-top: 50px;
  
}
.upload_muitple--files{
  
  .upload_muitple-title{
    font-weight: bold;
  }
}
.files_list--text{
  margin-top: 5px;
  text-align: center;
}
.files_list--img{
  margin-left: 30px;
  margin-top: 20px;
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