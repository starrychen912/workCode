<template>
       <div class="addfba_content">
         <div class="addfba_content--title">
           <i class="el-icon-back"></i>
           <span>导入FBA</span>
         </div>
         <div class="import_content">
           <div class="upload_file">
            <el-upload
                class="upload-demo"
                drag
                action="https://jsonplaceholder.typicode.com/posts/"
                multiple>
                <i class="el-icon-upload"></i>
                <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                <div class="el-upload__tip" ></div>
              </el-upload>
          </div>
          <div class="Release_deta">
            <label>发布时间：</label>
            <el-date-picker
              v-model="date"
              type="date"
              placeholder="选择日期">
            </el-date-picker>
          </div>
         
         </div>
          <div class="btn_button--list">
            
            <el-button type="primary">导入</el-button>
            <el-button type="danger">取消</el-button>
          </div>
       </div>
</template>
<script>
import Sidebar from "@/components/Loyout/Sidebar/Sidebar.vue"
import { reactive, toRefs } from 'vue'
export default {
  components:{
    Sidebar
  },
  setup(){
    const data = reactive({
      date:''
    })
    return {
      ...toRefs(data)

    }
  }
}
</script>
<style>
.upload-demo,.el-upload.el-upload--text,.el-upload-dragger{
  width: 100%;
}

</style>
<style scoped lang="scss">
.el-header{
  background-color: $navBg;
  height: auto;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .12), 0 0 3px 0 rgba(0, 0, 0, .04);
  padding: 0px;
}
.addfba_content{
  background-color: $navBg;
  
  // border-radius: 4px;
}
.addfba_content--title{
  font-size: 20px;
  padding: 15px;
  // font-family: ;
  font-weight: bold;
  // color: #909399;
  border-bottom: 1px solid #ebeef5;
  display: flex;
  align-items: center;
  i{
    font-size: 30px;
  }
  span{
    margin-left: 20px;
  }
}
.import_content{
  padding: 20px
}
.upload_file{
  .el-upload.el-upload--text{
    .el-upload-dragger{
      width: 100% !important;
    }
  }
  
}
.Release_deta{
  height: 40px;
  display: flex;
  align-items: center;
  margin:10px 0px;
}
.btn_button--list{
  border-top:1px solid #ebeef5;
  padding: 20px;
}
</style>