<template>
  <el-container>
     <el-header>
        <sidebar></sidebar>
     </el-header>
  <el-main>
    <div class="el-main_content">
        <div class="el-main-content-title">
           <h1> 与町町信息科技建立您的业务</h1>
           <span>以下是一款简短的清单，我们建议完成储存成功。</span>
        </div>
        <el-card class="box-card">
        <el-header class="el_context-header">
             <div class="card-header">
               <span>Les's Get  Started!</span>
               <div>4/4 Completed</div>
            </div>
            <!-- <div class="card-header-content">
                <div class="el-tags">
                    <el-tag type="success">Step 1</el-tag>
                </div>
                <div class="el-tag-content">
                    <span>Create or connect your Shopify store</span>
                    <div class="el-tag-Introduce">
                        in order to start selling you to have to have a Shopify store. Start your <a href="#">free trial of Shopify.</a><i></i>
                    </div>
                </div>
            </div> -->
        </el-header>
        <div class="demo-collapse">
            <el-collapse accordion style="border:0px">
                <el-collapse-item :name="index" class="el_collapse-ites" v-for="(item,index) in data.collapselist" :key="index">
                        <template #title>
                            <div class="el-tags">
                                <!-- <project-tag></project-tag> -->
                                <project-tag :TagName="'Step'+ (index+1)"></project-tag>
                            </div>
                            <div style="margin-left:20px;text-align:left;">
                                <div>Create or connect your Shopify store</div>
                                <div style="line-height: normal;">
                                    in order to start selling you to have to have a Shopify store. Start your <a href="#">free trial of Shopify.</a><i></i>
                                </div>
                            </div>
                        </template>
                        <div class="el--collaps_context">
                            我丢
                        </div>
                </el-collapse-item>
            </el-collapse>
        </div>
    </el-card>
    </div>
  </el-main>     
  </el-container>
</template>

<script>
import { reactive } from 'vue'
import Sidebar from '../../components/Loyout/Sidebar/Sidebar.vue'
import ProjectTag from '../../components/ProjectTag/ProjectTag.vue'
// import Header from '../header/index.vue'
export default {
    components:{
        Sidebar,
        ProjectTag
    },
    setup(props,context){
        let data  = reactive({
            collapselist:[
                {},
                {},
                {},
                {}
            ]
        })
        return {
            data
        }
    }

}
</script>

<style lang="scss" scoped>
@import url('@/assets/style/index.css');
:deep(.el_collapse-ites .el-collapse-item__header){
    height: auto;
    line-height: auto;
    align-items: flex-start;
    padding: 20px 20px;

}
:deep(.el-card__body){
    padding: 0px;
}
.el--collaps_context{
    text-align: left;
    padding: 10px 20px;
}
.el_context-header{
    padding: 20px 20px;
}
.box-card{
    margin-top: 20px;
}
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.el-main-content-title span{
    margin-top: 10px;
    color: #999;
    display: block;
    font-size: 15px;
}
.el-main-content-title h1{
    margin-block-start:0em !important;
    margin-block-end: 0em !important;
    width: 100%;
    height: auto;
    font-size: 40px;
}
.el-cotainer{
   height: 100vh;
}
 .el-header,
  .el-footer {
    background-color:$menuBg;
    color: var(--el-text-color-primary);
    text-align: center;
    --el-header-height: 80px;
  }

  .el-aside {
    background-color: $menuBg;
    color: var(--el-text-color-primary);
    text-align: center;
  }

  .el-main {
    color: var(--el-text-color-primary);
    padding: 20px;
    text-align: center;
  }
  .el-main .el-main_content{
      width: 100%;
      height: 100%;
    //   background-color: #fff;
  }
  body > .el-container {
    margin-bottom: 40px;
  }

  .el-container:nth-child(5) .el-aside,
  .el-container:nth-child(6) .el-aside {
    line-height: 260px;
  }

  .el-container:nth-child(7) .el-aside {
    line-height: 320px;
  }

</style>