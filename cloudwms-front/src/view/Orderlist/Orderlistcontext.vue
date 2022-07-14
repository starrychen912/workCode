<template>
  <div class="header-content">
    <div class="block">
         <el-image :src="content.images.length>0 ? content.images[0].src:''"></el-image>
    </div>
        <div class="block_content-text">
            <div class="block-content_title">
                {{content.title}}
            <div style="width:100%;color: rgb(150, 150, 150);">by Homeware Stroe(AillExpress)</div>    
            </div>
            <a href="#">View orginal product</a>      
       </div>    
        <div class="block_content">
            <div style="width:100%;">
                <el-form label-position="top" label-width="100px" :model="data">
                    <el-form-item label="Name">
                            <el-input v-model="content.title" @blur="TitleBlur" @input="TiTleInput"></el-input>
                    </el-form-item>
                    <el-select style="width:100%"  multiple filterable allow-create default-first-option v-model="data.collecitions" placeholder="选择事项">
                        <el-option label="主页" value="shanghai"></el-option>
                        <el-option label="其他页" value="beijing"></el-option>
                    </el-select>
                    <div style="width: 100%;margin-top:22px;display:flex;algin-item:center;justify-content: space-between;">
                        <el-select style="width:48%" v-model="data.name" placeholder="选择类型">
                            <el-option label="空空" value="shanghai"></el-option>
                            <el-option label="没有数据" value="beijing"></el-option>
                        </el-select>
                        <el-select style="width:48%" v-model="data.tags" placeholder="添加标签">
                            <el-option label="空空" value="shanghai"></el-option>
                            <el-option label="没有数据" value="beijing"></el-option>
                        </el-select>
                    </div>
                </el-form>      
            </div>
        </div>           
  </div>        
</template>

<script>
import { reactive } from 'vue'
export default {
    props:{
        content:{
            type:[String,Boolean,Array,Object],
            deafult:{}
        }
    },
    setup(props,context){
        console.log(props.content);
        const title = props.content.title
        const data = reactive({
            collecitions:[],
            type:[],
            tags:[],
            dialogVisible:false,
            inputstatus:false,
        })
        function TitleBlur(){

        }
        function TiTleInput(e){
            if(e.length > 0){
                data.inputstatus = true
            }else{
                data.inputstatus = false
            }
        }
        return {
            data,
            title,
            TitleBlur,
            TiTleInput
        }
    }
}
</script>

<style scoped lang="scss">
.header-content{
    display: grid;
    column-gap: 24px;
    row-gap:24px;
    grid-template-columns: 250px minmax(0, auto); //限制第一栏宽度为245px
    grid-template-rows: auto auto;
    padding: 20px;
}
.block{
        width: 100%;
        height: auto;
        grid-row: 1/3;
        grid-column: 1/2;
       
        .el-image{
            width: 100%;
            height: 100%;
        }
    }
    .block_content{
        width: 100%;
        // height: 200px;
        display: flex;
        flex-wrap: wrap;
        align-content: flex-start;
        grid-row: 2/3;
        grid-column:2/3;
        
    }
    .block_content-text{
        grid-row: 1/2;
        grid-column: 2/3;
        display: flex;
        
        .block-content_title{
            flex-grow: 1;
        }
        a{
            color: rgb(0, 162, 255);
            text-decoration: underline;
        }
    }  
    @media only screen and (max-width: 1600px){
       
        .block_content-text{
            display: flex;
            flex-wrap: wrap;
            flex-direction: row-reverse;
        }
    }
     @media only screen and (max-width: 1200px){
        .header-content{
            grid-template-columns: 80px minmax(0,auto);
            grid-template-rows:  auto auto;
        }
        .block{
            grid-row: 1/2;
            grid-column: 1/2;
        }
        .block_content{
            grid-row: 2/2;
            grid-column: 1/3;
        }
        .block_content-text{
            display: flex;
            flex-wrap: wrap;
            flex-direction: row-reverse;
        }
    }
    @media only screen and (max-width: 600px){
        .header-content{
            // grid-template-columns: 250px minmax(0,auto);
            // grid-template-rows:  auto auto;
        }
        .block{
            grid-row: 1/1;
            grid-column: 1/3;
        }
        .block_content{
            grid-row: 3/3;
            grid-column: 1/3;
        }
        .block_content-text{
            grid-row: 2/3;
            grid-column: 1/3;
            flex-direction: row;
            a{
                margin-top: 10px;
            }
        }
    }

</style>