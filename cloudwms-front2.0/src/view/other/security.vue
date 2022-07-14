<template>
  <div class="content--title">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
      <h1>
        <font style="vertical-align: inherit;">安全公告和建议</font>
      </h1>
    </el-col>     
  </div>
  <div class="support--content">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="flex  support--list">
            <h1>
              <font style="vertical-align: inherit;">PFG Annotator 安全公告和建议</font>
            </h1>
            <p>
              <font>安全是我们的首要任务。此页面包含有关可能影响 PDF Annotator 特定版本的安全漏洞的重要信息。</font>
            </p>
            <p>
              <font>根据我们的<a>更新政策</a>，我们为当前主要版本是0.01和之前的版本是0.01</font>
            </p>
            <p>
              <a>请确保使用内置的更新向导</a>随时使您的 PDF Annotator 安装保持最新。
            </p>
            <p>
              <font>使用软件中的帮助、版本检查更新到最新版本。</font>
            </p>
            <p>
              <font>充分考虑系统数据资源的容量、备份、恢复要求。为系统提供强大的数据备份工具。充分考虑政府网站的安全要求，作到内外网分离，信息发布管理责任到人。</font>
            </p>
            
        </div>
    </el-col>
  </div>


</template>

<script>
import { reactive,toRefs } from 'vue-demi'
export default {
  setup(props,content){
    const data = reactive({
    })
    return{

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
.support--list p{
  margin: 0px;
  margin-bottom: 10px;
  word-break: normal;
  white-space: pre-wrap;
  word-wrap: break-word;
  width: 100%;
  a{
    color: #409eff;
  }
}
</style>