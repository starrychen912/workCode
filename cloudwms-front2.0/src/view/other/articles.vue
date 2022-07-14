<template>
  <div class="content--title">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
      <h1>
        <font style="vertical-align: inherit;">分布教程</font>
      </h1>
    </el-col>     
  </div>
  <div class="support--content">
    <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
        <div class="  support--list">
            <h1>使用工具管理</h1>
            <div class="support--title">
              <ul>
                <li><a href="/other/explain">在使用工具的登录、注册操作流程</a></li>
                <li><a href="/other/storeshop">如何理性的对商铺的操作流程呢！</a></li>
                 <!-- <li><a href="/other/storeshop">如何添加新的商品</a></li> -->
                <li><a href="/other/storeshop">如何对订单的管理已经对订单的认识。</a></li>
                <!-- <li><a>对工具的设置已经管理</a></li> -->
              </ul>
            </div>
            
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
  min-height: 500px;
  padding: 20px 0px;
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
.support--title{
  ul{
    li{
      list-style: none;
      a{
        color: #409eff;
        &:hover{
          text-decoration: underline;
        }
      }
    }
  }
}
</style>