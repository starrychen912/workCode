<template>
  <div class="offcialwebsite" v-for="(item,index) in data.list" :key="index" :style="{'z-index':data.list.length-index}">
       <img :src="item" >
  </div>
</template>

<script>
import { reactive } from 'vue'
export default {
    name:'offcialwebsite',
    setup(){
        const data = reactive({
            list:[
                'https://cube.elemecdn.com/6/94/4d3ea53c084bad6931a56d5158a48jpeg.jpeg',
                'https://cube.elemecdn.com/6/94/4d3ea53c084bad6931a56d5158a48jpeg.jpeg',
                'https://cube.elemecdn.com/6/94/4d3ea53c084bad6931a56d5158a48jpeg.jpeg',
                'https://cube.elemecdn.com/6/94/4d3ea53c084bad6931a56d5158a48jpeg.jpeg',
            ]
        })
        return {
            data
        }
    }
}
</script>

<style lang="scss">
.offcialwebsite{
    width: 50px;
    height: 50px;
    // border:3px solid #fff;
    position: relative;
    margin-left: -15px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
        img{
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
}
</style>