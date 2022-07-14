<template>
  <div class="content--title">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
      <h1><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">有问题吗？</font><font style="vertical-align: inherit;">我们是来帮忙的！</font></font></h1>
    </el-col>     
  </div>
  <div class="support--content">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="flex  support--list">
          <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
              <div class="support--content-list">
                <h4>
                   <svg width="45" height="45" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><rect x="6" y="6" width="36" height="36" rx="3" fill="#d14330" stroke="#d14330" stroke-width="4" stroke-linejoin="round"/><path d="M32 28L24 36L16 28" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M24 20V35.5" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 14H32" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">最新版本</font></font>
                </h4>
                <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">请确保您运行的是最新的 PDF Annotator 版本。</font></font></p>
                <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">要找出您当前正在运行的版本，请启动 PDF Annotator 并单击</font></font><i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">帮助、关于 PDF Annotator</font></font></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">。</font></font></p>
                <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">要下载最新版本，请点击这里：</font></font></p>
                <p>
                  <a href="/index/home"><b><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Amani 管理器</font></font></b></a>
                </p>
                <p>
                  <a  target="gr-modal-iframe" class="gr-openmodal" @click="Vertical">
                  <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">版本历史</font>
                  </font>
                  </a><br>
                  <a href="/other/security"  rel="noopener"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">安全公告和建议</font></font></a>                            
                </p>
              </div>
          </el-col>
          <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
              <div class="support--content-list">
                <h4>
                 <svg width="45" height="45" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M39 6H9C7.34315 6 6 7.34315 6 9V39C6 40.6569 7.34315 42 9 42H39C40.6569 42 42 40.6569 42 39V9C42 7.34315 40.6569 6 39 6Z" fill="#d14330" stroke="#d14330" stroke-width="4" stroke-linejoin="round"/><path d="M24 28.6249V24.6249C27.3137 24.6249 30 21.9386 30 18.6249C30 15.3112 27.3137 12.6249 24 12.6249C20.6863 12.6249 18 15.3112 18 18.6249" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path fill-rule="evenodd" clip-rule="evenodd" d="M24 37.6249C25.3807 37.6249 26.5 36.5056 26.5 35.1249C26.5 33.7442 25.3807 32.6249 24 32.6249C22.6193 32.6249 21.5 33.7442 21.5 35.1249C21.5 36.5056 22.6193 37.6249 24 37.6249Z" fill="#FFF"/></svg>
                  <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">常见问题和手册</font></font>
                </h4>
                <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">您的问题有可能以前被问过和回答过！</font></font></p>
                <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">所有这些资源都可能包含有用的信息：</font></font><i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">帮助、关于 PDF Annotator</font></font></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">。</font></font></p>
                <p>
                  <a href="/other/faq"><b>
                  <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">常见的问题的汇总！</font>
                  </font>
                  </b></a>
                </p>
                <!-- <p>
                  <a href="https://www.pdfannotator.com/en/security"  rel="noopener">
                    <font style="vertical-align: inherit;">
                      <font style="vertical-align: inherit;">文章</font>
                    </font>
                  </a>                                         
                </p> -->
                <p>
                  <a  href="/other/articles" rel="noopener">
                    <font style="vertical-align: inherit;">
                      <font style="vertical-align: inherit;">分步教程</font>
                    </font>
                  </a>  
                </p>
              </div>
          </el-col>
          <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
              <div class="support--content-list">
                <h4>
                  <svg width="45" height="45" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M39 6H9C7.34315 6 6 7.34315 6 9V39C6 40.6569 7.34315 42 9 42H39C40.6569 42 42 40.6569 42 39V9C42 7.34315 40.6569 6 39 6Z" fill="#d14330" stroke="#d14330" stroke-width="4"/><path d="M36 16H12V32H36V16Z" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/><path d="M36 16L24 24L12 16" stroke="#FFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">发送支持查询</font></font>
                </h4>
                <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">我们是来帮忙的！</font></font></p>
                
                <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">请点击向我们的支持团队发送请求：</font></font></p>
                <p>
                  <a href="https://www.pdfannotator.com/pdfannotator/std/xx/PDFAnnotatorSetup.exe"><b><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">发送支持查询</font></font></b></a>
                </p>
                <p>
                  <a href="https://www.pdfannotator.com/en/security" target="_blank" rel="noopener"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">丢失了您的许可证密钥？访问您的许可证数据。</font></font></a>                            
                </p>
                <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">我们的目标是在 1-2 个工作日内回复所有查询。</font></font></p>
              </div>
          </el-col>
        </div>
    </el-col>
    <el-col :xs="24" :sm="24" :md="18" :lg="18" :xl="18">
      <div class="search">
        <div class="search--btn">
          <div class="search--title">
            <i class="el-icon-search"></i>
          </div>
          <h1>搜索所有资源</h1>
        </div>
        <div class="search-input">
          <input placeholder="">
          <div class="search_input--btn">搜索</div>
        </div>
      </div>
    </el-col>
  </div>
  <el-dialog
  title="Version History"
  v-model="dialogVisible"
  width="60%"
  custom-class="version_history"
  >
  <div class="">
    Version History
    Copyright © 2004-2021 by GRAHL software design

    版本号：{{vaersion}}
  </div>
  <template #footer>
    <span  class="dialog-footer">
      <el-button @click="dialogVisible = false">取 消</el-button>
      <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
    </span>
  </template>
</el-dialog>

</template>

<script>
import config from '../../../package.json'
import { reactive,toRefs } from 'vue-demi'
export default {
  setup(props,content){
    const data = reactive({
      dialogVisible:false,
      vaersion:config.version
    })
    function Vertical(){
      data.dialogVisible = !data.dialogVisible
    }
    return{
      ...toRefs(data),
      Vertical
    }
  }
}
</script>
<style>
.version_history .el-dialog__header{
  border-bottom: 1px solid #e5e5e5;
}
</style>
<style scoped lang="scss">
.content--title{
  width: 100%;
  height: auto;
  background: #f5f5f5;
  padding: 35px 0 30px 0;
  display: flex;
  justify-content: center;
}
.support--content{
  background-color: #fff;
  display: flex;
  // align-items: center;
  flex-wrap: wrap;
  justify-content: center;
 
  padding: 20px;
  height: auto;
}
.support--list{
  width: 100%;
  height: 100%;
  flex-wrap: wrap;
}
.support--content-list{
  padding: 20px;
  h4{
    font-size: 24px;
    display: flex;
    align-items: center;
    margin:0px;
    font{
      margin-left: 10px;
    }
  }
  p{
    a{
      color: #409eff;
      &:hover{
        text-decoration: underline;
      }
    }
  }
}
.search--btn{
  display: flex;
  align-items: center;
  h1{
    margin-left: 10px;
  }
}
.search_input--btn{
  display: inline-block;
  margin-bottom: 0;
  font-weight: normal;
  text-align: center;
  vertical-align: middle;
  cursor: pointer;
  background-image: none;
  border: 1px solid transparent;
  white-space: nowrap;
  padding: 6px 20px;
  font-size: 14px;
  border-radius: 0;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  color: #ffffff;
  background-color: #d14330;
  border: none;
  height:50px;
  margin-left: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.search{
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin:20px 0px;
  flex-wrap: wrap;
}
.search-input{
  width: 80%;
  height: 100%;
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0px 50px;
  input{
    height: 50px;
    padding: 11px 19px;
    width: 80%;
    font-size: 18px;
    border: 1px solid #ccc;
    &:focus{
      outline: none;
      border: 1px solid #409eff;
    }
  }
}
.search--title{
  display: flex;
  width: 38px;
  height: 38px;
  border-radius: 4px;
  background-color: #d14330;
  align-items: center;
  justify-content: center;
  i{
    font-size: 25px;
    font-weight: 900;
    color: #fff;
  }
}
</style>