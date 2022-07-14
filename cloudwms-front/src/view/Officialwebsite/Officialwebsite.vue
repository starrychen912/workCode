<template>
    <el-row>
        <collections></collections>
        <!-- <div class="grid-content bg-purple-dark">
            <el-col  class="container" :xs="20" :sm="20" :md="16" :lg="14" :xl="14">
                <div class="header">
                    <div class="header-title">OBERLO | <span>HELP CENTER</span></div>
                    <div class="header-share">
                        <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M28 6H42V20" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                        <path d="M42 29.4737V39C42 40.6569 40.6569 42 39 42H9C7.34315 42 6 40.6569 6 39V9C6 7.34315 7.34315 6 9 6L18 6" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                        <path d="M25.8 22.2L41.1 6.89999" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                        </svg> Go to Oberlo
                    </div>
                    
                </div>
                <div class="header_content">
                        Advice and answers from the Oberlo Team
                </div>
             
                <el-input v-model="data.SomeThing" placeholder="Search for articles..." style="height: 70px;font-size:20px;color:#fff;">
                        <template #prefix>
                            <i class="el-input__icon el-icon-search"></i>
                        </template>
                </el-input>
             </el-col>
        </div> -->
        
          <el-col  class="container" :xs="20" :sm="20" :md="16" :lg="14" :xl="14">  
            <div class="content-list">
                <el-card class="el_card-list flex-wrap" @click="CardClick">
                    <div class="block">
                       <svg width="50" height="50" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M4 12H44V20L42.6015 20.8391C40.3847 22.1692 37.6153 22.1692 35.3985 20.8391L34 20L32.6015 20.8391C30.3847 22.1692 27.6153 22.1692 25.3985 20.8391L24 20L22.6015 20.8391C20.3847 22.1692 17.6153 22.1692 15.3985 20.8391L14 20L12.6015 20.8391C10.3847 22.1692 7.61531 22.1692 5.39853 20.8391L4 20V12Z" fill="none" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M8 22.4889V44H40V22" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M8 11.8222V4H40V12" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><rect x="19" y="32" width="10" height="12" fill="none" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                    </div>
                    <div class="content-l-text">
                        <div class="c-l-t-title">lntro to Oberlo</div>
                        <div class="c_l_t_type">Learn about Oberlo and dropshipping</div>
                        <div class="c_l_t_number">
                            <div class="c_l_t_number_img">
                                <number-img></number-img>
                            </div>
                            <div class="c_l_t_n_text">
                                <div >13 articles in this collection</div>
                                <div >Written by Zac,Karolis,Mary Smith and 1 other</div>
                            </div>
                        </div>
                    </div>
                </el-card>
                <el-card class="el_card-list">
                    <div class="block">
                        <svg width="50" height="50" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 10H6C4.89543 10 4 10.8954 4 12V38C4 39.1046 4.89543 40 6 40H42C43.1046 40 44 39.1046 44 38V35.5" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                        <path d="M10 23H18" stroke="#818a97" stroke-width="4" stroke-linecap="round"/>
                        <path d="M10 31H34" stroke="#818a97" stroke-width="4" stroke-linecap="round"/>
                        <circle cx="34" cy="16" r="6" fill="none" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/>
                        <path d="M44.0001 28.4187C42.0469 24.6023 38 22 34 22C30 22 28.0071 23.1329 25.9503 25" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                       <!-- <svg width="50" height="50" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M4 12H44V20L42.6015 20.8391C40.3847 22.1692 37.6153 22.1692 35.3985 20.8391L34 20L32.6015 20.8391C30.3847 22.1692 27.6153 22.1692 25.3985 20.8391L24 20L22.6015 20.8391C20.3847 22.1692 17.6153 22.1692 15.3985 20.8391L14 20L12.6015 20.8391C10.3847 22.1692 7.61531 22.1692 5.39853 20.8391L4 20V12Z" fill="none" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M8 22.4889V44H40V22" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><path d="M8 11.8222V4H40V12" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/><rect x="19" y="32" width="10" height="12" fill="none" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg> -->
                    </div>
                    <div class="content-l-text">
                        <div class="c-l-t-title">lntro to Oberlo</div>
                        <div class="c_l_t_type">Learn about Oberlo and dropshipping</div>
                        <div class="c_l_t_number">
                            <div class="c_l_t_number_img">
                                <number-img></number-img>
                            </div>
                            <div class="c_l_t_n_text">
                                <div >13 articles in this collection</div>
                                <div >Written by Zac,Karolis,Mary Smith and 1 other</div>
                            </div>
                        </div>
                    </div>
                </el-card>
                <el-card class="el_card-list">
                    <div class="block">
                        <svg width="50" height="50" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" fill="white" fill-opacity="0.01"/><path d="M44 16C44 22.6274 38.6274 28 32 28C29.9733 28 28.0639 27.4975 26.3896 26.6104L9 44L4 39L21.3896 21.6104C20.5025 19.9361 20 18.0267 20 16C20 9.37258 25.3726 4 32 4C34.0267 4 35.9361 4.50245 37.6104 5.38959L30 13L35 18L42.6104 10.3896C43.4975 12.0639 44 13.9733 44 16Z" fill="none" stroke="#818a97" stroke-width="4" stroke-linecap="round" stroke-linejoin="miter"/></svg>
                    </div>
                    <div class="content-l-text">
                        <div class="c-l-t-title">lntro to Oberlo</div>
                        <div class="c_l_t_type">Learn about Oberlo and dropshipping</div>
                        <div class="c_l_t_number">
                            <div class="c_l_t_number_img">
                                <number-img></number-img>
                            </div>
                            <div class="c_l_t_n_text">
                                <div >13 articles in this collection</div>
                                <div >Written by Zac,Karolis,Mary Smith and 1 other</div>
                            </div>
                        </div>
                    </div>
                </el-card>
            </div>
            </el-col>
  </el-row>
</template>

<script>
import { reactive } from 'vue'
import NumberImg from '../../../src/components/NumberImg/index.vue'
import Collections from '../../components/collectionsheader/collections.vue'
import router from '@/router'
export default {
    components:{
        NumberImg,
        Collections
    },
    setup(){
        const data = reactive({
            SomeThing:'',
        })
        function CardClick(){
            router.push({
                path:"/Officialwebsite/Accounts",
                query:{}
            })
            
        }
        return {
            data,
            CardClick
        }
    }

}
</script>

<style lang="scss" scoped>
*{
    box-sizing: border-box;
}
:deep([class*=el-col-]){
    float: none;
}
.container{
    margin:0 auto;
}
.el-col {
  border-radius: 4px;
}
.bg-purple-dark {
  background: #04042d;
  width: 100%;
  height: auto;
  padding: 0 0 35px 0;
}
.el-row{
    height: 100vh;
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
.content-list{
    width: 100%;
    height: auto;
    // margin-top: 100px;
    .block{
        width: 150px;
        height: 150px;
        display:flex;
        align-items: center;
        justify-content: center;
    }
}
:deep(.el-card__body){
    width: 100%;
    height: auto;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
   
    box-sizing: border-box;
    .c-l-t-title{
        font-size: 25px;
        color: #818a97;
    }
    .c_l_t_type{
        color: #636573;
    }
    .c_l_t_number{
        width: 100%;
        display: flex;
        align-items: center;
         flex-wrap: wrap;
    }
    .c_l_t_number_img{
        width: auto;
        // border-radius: 50%;
        margin-right: 10px;
        display: flex;
        align-items: center;
       
    }
    .c_l_t_n_text{
        font-size: 15px;
        color: #9496a2;
    }
}
.el_card-list{
    margin-top: 30px;
    cursor: pointer;
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
    }
    :deep(.el-card__body){
         justify-content: center;
    }
    .c_l_t_number_img{
        padding: 10px;
    }
}
</style>