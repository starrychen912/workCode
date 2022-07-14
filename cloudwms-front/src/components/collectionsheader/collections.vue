<template>
    <div class="grid-content bg-purple-dark">
            <el-col  class="container" :xs="20" :sm="20" :md="16" :lg="14" :xl="14">
                <div class="header">
                    <div class="header-title">OBERLO | <span>HELP CENTER</span></div>
                    <div class="header-share" >
                        <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M28 6H42V20" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                        <path d="M42 29.4737V39C42 40.6569 40.6569 42 39 42H9C7.34315 42 6 40.6569 6 39V9C6 7.34315 7.34315 6 9 6L18 6" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                        <path d="M25.8 22.2L41.1 6.89999" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                        </svg> Go to Oberlo
                    </div>
                    
                </div>
                <div class="header_content" v-if="Sharestart">
                        Advice and answers from the Oberlo Team
                </div>
             
                <el-input v-model="data.SomeThing" placeholder="Search for articles..." :class="{'el-input--l':!Sharestart}" style="height: 70px;font-size:20px;color:#fff;">
                        <template #prefix>
                            <i class="el-input__icon el-icon-search"></i>
                        </template>
                </el-input>
             </el-col>
             
        </div>
        <div class="container">
            
        </div>
</template>

<script>
import {reactive} from 'vue'
export default {
    props:{
        Sharestart:{
            type:Boolean,
            default:true
        }
    },
    setup(props,context){
        const data = reactive({
            SomeThing:'',
        })
        return {
            data
        }
    }
}
</script>

<style lang="scss" scoped>
.el-input--l{
    margin-top: 0px !important;
}
*{
    box-sizing: border-box;
}
:deep([class*=el-col-]){
    float: none;
}
.container{
    margin:0 auto;
    position: relative;
}
.bg-purple-dark {
  background: #04042d;
  width: 100%;
  height: auto;
  padding: 0 0 35px 0;
}
.header{
    padding: 20px 0px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.header-share{
    color: #fff;
    display: flex;
    align-items: center;
    font-size: 10px;
    padding: 10px 0px;
    svg{
        margin-right: 10px;
    }
}
.header_content{
    font-size: 25px;
    color: #fff;
}
.header-title{
    width: 80%;
    height: auto;
    font-size: 30px;
    color: #b8f0ff;
    span{
        font-size: 20px;
    }
}
.el-input {
 margin-top: 50px;
 height: 70px !important;
 line-height: 70px !important;
  input{
      height: 60px;
      line-height: 60px;
      background-color: rgba(255,255,255,0.5);
      border: none;
      color: #fff;
  }
}

:deep(.el-input--prefix){
    .el-input__inner{
        padding: 20px 32px 21px 59px;
        background: rgba(255,255,255,0.2);
        height: auto;
        line-height: 0px;
        border: none;
        color: #fff;
        transition: background .4s, box-shadow .2s, -webkit-box-shadow .2s;
        &:active{
            -webkit-box-shadow: 0 10px 20px rgb(0 0 0 / 14%);
            box-shadow: 0 10px 20px rgb(0 0 0 / 14%);
            background: white;
            color: #3a3c4c;
        }
        &:hover{
            background: rgba(255,255,255,0.27);
            -webkit-box-shadow: 0 10px 20px rgb(0 0 0 / 3%);
            box-shadow: 0 10px 20px rgb(0 0 0 / 3%);
        }
        &:focus{
            -webkit-box-shadow: 0 10px 20px rgb(0 0 0 / 14%);
            box-shadow: 0 10px 20px rgb(0 0 0 / 14%);
            background: white;
            color: #3a3c4c;
        }
        &:nth-child(2){
            color: #000;
        }
    }
    .el-input__prefix{
        left: 15px;
        top: 1px;
    }
}
.el--body{
    display: flex;
}
@media only screen and (max-width: 768px){
    .header-title{
        width: 100%;
        margin-top: 20px;
    }
    .header-share{
        position: absolute;
        top: 0px;
        right: 0px;
    }
    :deep(.el-card__body){
         justify-content: center;
    }
    .c_l_t_number_img{
        padding: 10px;
    }
}
</style>